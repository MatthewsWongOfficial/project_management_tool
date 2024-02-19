# Project Management Tool

## Overview

This project is a PHP website integrated with PostgreSQL, serving as a project management tool. It allows users to create projects, assign tasks, manage teams, and track progress.

## ERD

![ERD](https://github.com/MatthewsWongOfficial/project_management_tool/blob/main/Project%20Management%20Tool%20ERD%20-%20Matthews%20Wong.drawio%20(1).png?raw=true)

## DDL Query of creating tables

Below are the Data Definition Language (DDL) queries to create the necessary tables in PostgreSQL:

```sql
-- Users Table
CREATE TABLE Users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Projects Table
CREATE TABLE Projects (
    project_id SERIAL PRIMARY KEY,
    project_name VARCHAR(100) NOT NULL,
    start_date DATE,
    end_date DATE,
    manager_id INT REFERENCES Users(user_id)
);

-- Tasks Table
CREATE TABLE Tasks (
    task_id SERIAL PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    description TEXT,
    project_id INT REFERENCES Projects(project_id),
    assigned_to INT REFERENCES Users(user_id),
    due_date DATE,
    status VARCHAR(50)
);

-- Teams Table
CREATE TABLE Teams (
    team_id SERIAL PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL,
    lead_id INT REFERENCES Users(user_id)
);

-- Team Members Table (to handle many-to-many relationship between Users and Teams)
CREATE TABLE Team_Members (
    team_id INT REFERENCES Teams(team_id),
    user_id INT REFERENCES Users(user_id),
    PRIMARY KEY (team_id, user_id)
);

ALTER TABLE Projects ADD COLUMN number_of_tasks INT DEFAULT 0;

ALTER TABLE Tasks ADD COLUMN overdue BOOLEAN DEFAULT FALSE;

ALTER TABLE Tasks ADD COLUMN last_assigned_to INT;

## All PL/pgSQL CRUD Functions
-- Users Table CRUD Functions

-- Create User
CREATE OR REPLACE FUNCTION create_user(_username VARCHAR, _email VARCHAR, _password VARCHAR)
RETURNS void AS $$
BEGIN
    INSERT INTO Users (username, email, password) VALUES (_username, _email, _password);
END;
$$ LANGUAGE plpgsql;

-- Read Users
CREATE OR REPLACE FUNCTION read_user(_user_id INT)
RETURNS TABLE(user_id INT, username VARCHAR, email VARCHAR, created_at TIMESTAMP) AS $$
BEGIN
    RETURN QUERY SELECT Users.user_id, Users.username, Users.email, Users.created_at FROM Users WHERE Users.user_id = _user_id;
END;
$$ LANGUAGE plpgsql;

-- Update User
CREATE OR REPLACE FUNCTION update_user(_user_id INT, _username VARCHAR, _email VARCHAR, _password VARCHAR)
RETURNS void AS $$
BEGIN
    UPDATE Users SET username = _username, email = _email, password = _password WHERE user_id = _user_id;
END;
$$ LANGUAGE plpgsql;

-- Delete User
CREATE OR REPLACE FUNCTION delete_user(_user_id INT)
RETURNS void AS $$
BEGIN
    DELETE FROM Users WHERE user_id = _user_id;
END;
$$ LANGUAGE plpgsql;

-- Projects Table CRUD Functions

-- Create Project
CREATE OR REPLACE FUNCTION create_project(_project_name VARCHAR, _start_date DATE, _end_date DATE, _manager_id INT)
RETURNS void AS $$
BEGIN
    INSERT INTO Projects (project_name, start_date, end_date, manager_id) VALUES (_project_name, _start_date, _end_date, _manager_id);
END;
$$ LANGUAGE plpgsql;

-- Read Project
CREATE OR REPLACE FUNCTION read_project(_project_id INT)
RETURNS TABLE(project_id INT, project_name VARCHAR, start_date DATE, end_date DATE, manager_id INT) AS $$
BEGIN
    RETURN QUERY SELECT project_id, project_name, start_date, end_date, manager_id FROM Projects WHERE project_id = _project_id;
END;
$$ LANGUAGE plpgsql;

-- Update Project
CREATE OR REPLACE FUNCTION update_project(_project_id INT, _project_name VARCHAR, _start_date DATE, _end_date DATE, _manager_id INT)
RETURNS void AS $$
BEGIN
    UPDATE Projects SET project_name = _project_name, start_date = _start_date, end_date = _end_date, manager_id = _manager_id WHERE project_id = _project_id;
END;
$$ LANGUAGE plpgsql;

-- Delete Project
CREATE OR REPLACE FUNCTION delete_project(_project_id INT)
RETURNS void AS $$
BEGIN
    DELETE FROM Projects WHERE project_id = _project_id;
END;
$$ LANGUAGE plpgsql;

-- Tasks Table CRUD Functions

-- Create Task
CREATE OR REPLACE FUNCTION create_task(_task_name VARCHAR, _project_id INT, _assigned_to INT, _due_date DATE, _status VARCHAR)
RETURNS void AS $$
BEGIN
    INSERT INTO Tasks (task_name, project_id, assigned_to, due_date, status) VALUES (_task_name, _project_id, _assigned_to, _due_date, _status);
END;
$$ LANGUAGE plpgsql;

-- Read Tasks
CREATE OR REPLACE FUNCTION read_task(_task_id INT)
RETURNS TABLE(task_id INT, task_name VARCHAR, project_id INT, assigned_to INT, due_date DATE, status VARCHAR) AS $$
BEGIN
    RETURN QUERY SELECT Tasks.task_id, Tasks.task_name, Tasks.project_id, Tasks.assigned_to, Tasks.due_date, Tasks.status FROM Tasks WHERE Tasks.task_id = _task_id;
END;
$$ LANGUAGE plpgsql;

-- Update Task
CREATE OR REPLACE FUNCTION update_task(_task_id INT, _task_name VARCHAR, _project_id INT, _assigned_to INT, _due_date DATE, _status VARCHAR)
RETURNS void AS $$
BEGIN
    UPDATE Tasks SET task_name = _task_name, project_id = _project_id, assigned_to = _assigned_to, due_date = _due_date, status = _status WHERE task_id = _task_id;
END;
$$ LANGUAGE plpgsql;

-- Delete Task
CREATE OR REPLACE FUNCTION delete_task(_task_id INT)
RETURNS void AS $$
BEGIN
    DELETE FROM Tasks WHERE task_id = _task_id;
END;
$$ LANGUAGE plpgsql;

-- Teams Table CRUD Functions

-- Create team
CREATE OR REPLACE FUNCTION create_team(_team_name VARCHAR, _lead_id INT)
RETURNS void AS $$
BEGIN
    INSERT INTO Teams (team_name, lead_id) VALUES (_team_name, _lead_id);
END;
$$ LANGUAGE plpgsql;

-- Read Team
CREATE OR REPLACE FUNCTION read_team(_team_id INT)
RETURNS TABLE(team_id INT, team_name VARCHAR, lead_id INT) AS $$
BEGIN
    RETURN QUERY SELECT Teams.team_id, Teams.team_name, Teams.lead_id FROM Teams WHERE Teams.team_id = _team_id;
END;
$$ LANGUAGE plpgsql;

-- Update Team
CREATE OR REPLACE FUNCTION update_team(_team_id INT, _team_name VARCHAR, _lead_id INT)
RETURNS void AS $$
BEGIN
    UPDATE Teams SET team_name = _team_name, lead_id = _lead_id WHERE team_id = _team_id;
END;
$$ LANGUAGE plpgsql;

-- Delete Team
CREATE OR REPLACE FUNCTION delete_team(_team_id INT)
RETURNS void AS $$
BEGIN
    DELETE FROM Teams WHERE team_id = _team_id;
END;
$$ LANGUAGE plpgsql;

--PL/pgSQL Triggers
-- Trigger 1: Auto-Update Task Status on Due Date
-- Trigger Function
CREATE OR REPLACE FUNCTION check_task_due_date()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.due_date < CURRENT_DATE AND NEW.status != 'Completed' THEN
        NEW.overdue := TRUE;
    ELSE
        NEW.overdue := FALSE;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
-- Trigger
CREATE TRIGGER trigger_check_task_due_date
BEFORE UPDATE ON Tasks
FOR EACH ROW
EXECUTE FUNCTION check_task_due_date();

-- Trigger2: Updating the number of tasks for each project
-- Trigger Function
CREATE OR REPLACE FUNCTION increment_task_count()
RETURNS TRIGGER AS $$
BEGIN
    -- Increment the number of tasks in the associated project
    UPDATE Projects SET number_of_tasks = number_of_tasks + 1 WHERE project_id = NEW.project_id;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
-- Create the Trigger
CREATE TRIGGER trigger_increment_task_count
AFTER INSERT ON Tasks
FOR EACH ROW
EXECUTE FUNCTION increment_task_count();

-- Trigger 3: Log Task Assignment Changes
-- Trigger Function
CREATE OR REPLACE FUNCTION log_task_assignment_change()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.assigned_to IS DISTINCT FROM OLD.assigned_to THEN
        NEW.last_assigned_to := OLD.assigned_to;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
-- Trigger
CREATE TRIGGER trigger_log_task_assignment_change
BEFORE UPDATE ON Tasks
FOR EACH ROW
EXECUTE FUNCTION log_task_assignment_change();


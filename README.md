# Project Management Tool

## Overview

This project is a PHP website integrated with PostgreSQL, serving as a project management tool.

**Final Project: Project Management Tool**  
**Made By:** Matthews Wong (12202010)

## Content

1. [ERD](#erd)
2. [DDL Query of creating table](#ddl-query-of-creating-table)
3. [All PL/pgSQL CRUD Functions](#all-plpgsql-crud-functions)
4. [PL/pgSQL Triggers](#plpgsql-triggers)

## ERD

[ERD Placeholder]

## DDL Query of creating table

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

## PL/pgSQL CRUD Functions

### Users Table

```sql
-- Create User
CREATE OR REPLACE FUNCTION create_user(_username VARCHAR, _email VARCHAR, _password VARCHAR)
RETURNS void AS $$
BEGIN
    INSERT INTO Users (username, email, password) VALUES (_username, _email, _password);
END;
$$ LANGUAGE plpgsql;

-- Read User
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

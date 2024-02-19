<!DOCTYPE html>
<html>

<head>
    <title>Add Task</title>
</head>

<body>
    <h2>Add New Task</h2>
    <form action="process_add_task.php" method="post">
        Task Name: <input type="text" name="task_name"><br>
        Project ID: <input type="number" name="project_id"><br>
        Assigned To (User ID): <input type="number" name="assigned_to"><br>
        Due Date: <input type="date" name="due_date"><br>
        Status: <input type="text" name="status"><br>
        <input type="submit" value="Add Task">
    </form>
</body>

</html>
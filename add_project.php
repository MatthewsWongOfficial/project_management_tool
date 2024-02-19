<!DOCTYPE html>
<html>

<head>
    <title>Add Project</title>
</head>

<body>
    <h2>Add New Project</h2>
    <form action="process_add_project.php" method="post">
        Project Name: <input type="text" name="project_name"><br>
        Start Date: <input type="date" name="start_date"><br>
        End Date: <input type="date" name="end_date"><br>
        Manager ID: <input type="number" name="manager_id"><br>
        <input type="submit" value="Add Project">
    </form>
</body>

</html>
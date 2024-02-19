<?php
include 'db.php';

function getTask($taskId)
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_task($taskId)");

    if (!$result) {
        echo "An error occurred: " . pg_last_error($dbconn);
        exit;
    }

    return pg_fetch_assoc($result);
}
function getUser($userId)
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_user($userId)");

    if (!$result) {
        echo "An error occurred.\n";
        echo pg_last_error($dbconn);
        exit;
    }
    return pg_fetch_assoc($result);
}





$taskId = $_GET['id'] ?? null;
$task = $taskId ? getTask($taskId) : null;

if (!$task) {
    echo "Task not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Task</title>
</head>

<body>
    <h2>Edit Task</h2>
    <form action="process_edit_task.php" method="post">
        <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
        Task Name: <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>"><br>
        Project ID: <input type="number" name="project_id" value="<?php echo $task['project_id']; ?>"><br>
        Assigned To (User ID): <input type="number" name="assigned_to" value="<?php echo $task['assigned_to']; ?>"><br>
        Due Date: <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>"><br>
        Status: <input type="text" name="status" value="<?php echo $task['status']; ?>"><br>
        <input type="submit" value="Update Task">
    </form>
</body>

</html>
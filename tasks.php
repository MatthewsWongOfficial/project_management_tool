<?php
include 'db.php';

function readTasks()
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_tasks()");
    return $result;
}
echo "<a href='index.php'>Back to Menu</a><br/><br/>";

echo "<h2>Tasks</h2>";
echo "<a href='add_task.php'>Add New Task</a><br/><br/>";
$tasks = readTasks();
while ($row = pg_fetch_assoc($tasks)) {
    echo "Task ID: " . $row['task_id'] . ", Task Name: " . $row['task_name'];
    echo " - <a href='edit_task.php?id=" . $row['task_id'] . "'>Edit</a>";
    echo " - <a href='delete_task.php?id=" . $row['task_id'] . "'>Delete</a><br/>";
}

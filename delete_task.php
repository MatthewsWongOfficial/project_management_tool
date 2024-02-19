<?php
include 'db.php';

if (!empty($_GET['id'])) {
    $taskId = $_GET['id'];
    $dbconn = getDbConnection();
    $query = "SELECT delete_task(" . intval($taskId) . ")";
    $result = pg_query($dbconn, $query);

    if (!$result) {
        echo "An error occurred.\n";
        echo pg_last_error($dbconn);
    } else {
        echo "Task successfully deleted.";
    }
}

header("Location: tasks.php"); // Redirect back to the tasks page

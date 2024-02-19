<?php
include 'db.php';

function executeQuery($query)
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, $query);

    if (!$result) {
        echo "An error occurred.\n";
        echo pg_last_error($dbconn);
        exit;
    }
    return $result;
}

if (!empty($_POST['task_name']) && isset($_POST['project_id']) && isset($_POST['assigned_to']) && !empty($_POST['due_date']) && !empty($_POST['status'])) {
    $query = "SELECT create_task('" . pg_escape_string($_POST['task_name']) . "', " . intval($_POST['project_id']) . ", " . intval($_POST['assigned_to']) . ", '" . pg_escape_string($_POST['due_date']) . "', '" . pg_escape_string($_POST['status']) . "')";
    executeQuery($query);
}

header("Location: tasks.php");

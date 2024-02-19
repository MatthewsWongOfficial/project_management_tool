<?php
include 'db.php';

if (!empty($_POST['task_id']) && !empty($_POST['task_name']) && isset($_POST['project_id']) && isset($_POST['assigned_to']) && !empty($_POST['due_date']) && !empty($_POST['status'])) {
    $dbconn = getDbConnection();
    $query = "SELECT update_task(" . intval($_POST['task_id']) . ", '" . pg_escape_string($_POST['task_name']) . "', " . intval($_POST['project_id']) . ", " . intval($_POST['assigned_to']) . ", '" . pg_escape_string($_POST['due_date']) . "', '" . pg_escape_string($_POST['status']) . "')";
    pg_query($dbconn, $query);
}

header("Location: tasks.php");

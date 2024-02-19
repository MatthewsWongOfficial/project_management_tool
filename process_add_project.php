<?php
include 'db.php';

if (!empty($_POST['project_name']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && isset($_POST['manager_id'])) {
    $dbconn = getDbConnection();
    $query = "SELECT create_project('" . pg_escape_string($_POST['project_name']) . "', '" . pg_escape_string($_POST['start_date']) . "', '" . pg_escape_string($_POST['end_date']) . "', " . intval($_POST['manager_id']) . ")";
    $result = pg_query($dbconn, $query);

    if (!$result) {
        die('Query failed: ' . pg_last_error($dbconn));
    }
}

header("Location: projects.php");

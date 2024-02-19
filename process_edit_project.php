<?php
include 'db.php';

if (!empty($_POST['project_id']) && !empty($_POST['project_name']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && isset($_POST['manager_id'])) {
    $dbconn = getDbConnection();
    $query = "SELECT update_project(" . intval($_POST['project_id']) . ", '" . pg_escape_string($_POST['project_name']) . "', '" . pg_escape_string($_POST['start_date']) . "', '" . pg_escape_string($_POST['end_date']) . "', " . intval($_POST['manager_id']) . ")";
    pg_query($dbconn, $query);
}

header("Location: projects.php");

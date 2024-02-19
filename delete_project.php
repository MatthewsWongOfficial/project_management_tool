<?php
include 'db.php';

if (!empty($_GET['id'])) {
    $dbconn = getDbConnection();
    $query = "SELECT delete_project(" . intval($_GET['id']) . ")";
    pg_query($dbconn, $query);
}

header("Location: projects.php");

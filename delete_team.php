<?php
include 'db.php';

if (!empty($_GET['id'])) {
    $teamId = $_GET['id'];
    $dbconn = getDbConnection();
    $query = "SELECT delete_team(" . intval($teamId) . ")";
    $result = pg_query($dbconn, $query);

    if (!$result) {
        echo "An error occurred.\n";
        echo pg_last_error($dbconn);
    } else {
        echo "Team successfully deleted.";
    }
}

header("Location: teams.php"); // Redirect back to the teams page

<?php
include 'db.php';

if (!empty($_POST['team_name']) && isset($_POST['lead_id'])) {
    $dbconn = getDbConnection();
    $query = "SELECT create_team('" . pg_escape_string($_POST['team_name']) . "', " . intval($_POST['lead_id']) . ")";
    pg_query($dbconn, $query);
}

header("Location: teams.php");

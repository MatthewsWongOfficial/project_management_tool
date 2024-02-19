<?php
include 'db.php';

if (!empty($_POST['team_id']) && !empty($_POST['team_name']) && isset($_POST['lead_id'])) {
    $dbconn = getDbConnection();
    $query = "SELECT update_team(" . intval($_POST['team_id']) . ", '" . pg_escape_string($_POST['team_name']) . "', " . intval($_POST['lead_id']) . ")";
    pg_query($dbconn, $query);
}

header("Location: teams.php");

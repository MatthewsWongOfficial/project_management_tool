<?php
include 'db.php';

if (!empty($_POST['user_id']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $dbconn = getDbConnection();
    $query = "SELECT update_user(" . intval($_POST['user_id']) . ", '" . pg_escape_string($_POST['username']) . "', '" . pg_escape_string($_POST['email']) . "', '" . pg_escape_string($_POST['password']) . "')";
    pg_query($dbconn, $query);
}

header("Location: users.php");

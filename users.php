<?php
include 'db.php';

function readUsers()
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_users()");
    return $result;
}
echo "<a href='index.php'>Back to Menu</a><br/><br/>";
echo "<h2>Users</h2>";
echo "<a href='add_user.php'>Add New User</a><br/><br/>";
$users = readUsers();
while ($row = pg_fetch_assoc($users)) {
    echo "User ID: " . $row['user_id'] . ", Username: " . $row['username'];
    echo " - <a href='edit_user.php?id=" . $row['user_id'] . "'>Edit</a>";
    echo " - <a href='delete_user.php?id=" . $row['user_id'] . "'>Delete</a><br/>";
}

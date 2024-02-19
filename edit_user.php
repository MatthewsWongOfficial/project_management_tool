<?php
include 'db.php';

function getUser($userId)
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_user($userId)");
    return pg_fetch_assoc($result);
}

$userId = $_GET['id'] ?? null;
$user = $userId ? getUser($userId) : null;

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
</head>

<body>
    <h2>Edit User</h2>
    <form action="process_edit_user.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        Username: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>
        Password: <input type="password" name="password"><br> <!-- Password should be re-entered -->
        <input type="submit" value="Update User">
    </form>
</body>

</html>
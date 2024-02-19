<?php
include 'db.php';

function getTeam($teamId)
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_team($teamId)"); // Ensure read_team function exists in your database
    return pg_fetch_assoc($result);
}

$teamId = $_GET['id'] ?? null;
$team = $teamId ? getTeam($teamId) : null;

if (!$team) {
    echo "Team not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Team</title>
</head>

<body>
    <h2>Edit Team</h2>
    <form action="process_edit_team.php" method="post">
        <input type="hidden" name="team_id" value="<?php echo $team['team_id']; ?>">
        Team Name: <input type="text" name="team_name" value="<?php echo htmlspecialchars($team['team_name']); ?>"><br>
        Lead ID (User ID): <input type="number" name="lead_id" value="<?php echo $team['lead_id']; ?>"><br>
        <input type="submit" value="Update Team">
    </form>
</body>

</html>
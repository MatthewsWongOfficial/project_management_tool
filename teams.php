<?php
include 'db.php';

function readTeams()
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_teams()");
    return $result;
}
echo "<a href='index.php'>Back to Menu</a><br/><br/>";

echo "<h2>Teams</h2>";
echo "<a href='add_team.php'>Add New Team</a><br/><br/>";
$teams = readTeams();
while ($row = pg_fetch_assoc($teams)) {
    echo "Team ID: " . $row['team_id'] . ", Team Name: " . $row['team_name'];
    echo " - <a href='edit_team.php?id=" . $row['team_id'] . "'>Edit</a>";
    echo " - <a href='delete_team.php?id=" . $row['team_id'] . "'>Delete</a><br/>";
}

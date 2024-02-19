<?php
include 'db.php';

function readProjects()
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_projects()");
    return $result;
}
echo "<a href='index.php'>Back to Menu</a><br/><br/>";

echo "<h2>Projects</h2>";
echo "<a href='add_project.php'>Add New Project</a><br/><br/>";
$projects = readProjects();
while ($row = pg_fetch_assoc($projects)) {
    echo "Project ID: " . $row['project_id'] . ", Project Name: " . $row['project_name'];
    echo " - <a href='edit_project.php?id=" . $row['project_id'] . "'>Edit</a>";
    echo " - <a href='delete_project.php?id=" . $row['project_id'] . "'>Delete</a><br/>";
}

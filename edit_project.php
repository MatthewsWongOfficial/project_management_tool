<?php
include 'db.php';

function getProject($projectId)
{
    $dbconn = getDbConnection();
    $result = pg_query($dbconn, "SELECT * FROM read_project($projectId)");

    if (!$result) {
        echo "An error occurred: " . pg_last_error($dbconn);
        exit;
    }

    $project = pg_fetch_assoc($result);
    if (!$project) {
        echo "Project not found.";
        exit;
    }

    return $project;
}


$projectId = $_GET['id'] ?? null;
$project = $projectId ? getProject($projectId) : null;

if (!$project) {
    echo "Project not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Project</title>
</head>

<body>
    <h2>Edit Project</h2>
    <form action="process_edit_project.php" method="post">
        <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
        Project Name: <input type="text" name="project_name" value="<?php echo htmlspecialchars($project['project_name']); ?>"><br>
        Start Date: <input type="date" name="start_date" value="<?php echo $project['start_date']; ?>"><br>
        End Date: <input type="date" name="end_date" value="<?php echo $project['end_date']; ?>"><br>
        Manager ID: <input type="number" name="manager_id" value="<?php echo $project['manager_id']; ?>"><br>
        <input type="submit" value="Update Project">
    </form>
</body>

</html>
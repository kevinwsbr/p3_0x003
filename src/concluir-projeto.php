<?php

require_once 'configs/Database.php';
require_once 'configs/Project.php';

$conn = new Database();
$project = new Project($conn->db);

$project->completeProject();
header('Location: index.php');

?>
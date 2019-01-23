<?php

require_once 'configs/Autoload.php';

$project = new Project($conn->getInstance());

$project->completeProject();
header('Location: index.php');

?>
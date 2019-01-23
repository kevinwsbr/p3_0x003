<?php

require_once 'configs/Autoload.php';

$collaborator = new Collaborator($conn->getInstance());
$project = new Project($conn->getInstance());
$publication = new Publication($conn->getInstance());
$orientation = new Orientation($conn->getInstance());

$collaboratorsNumber = $collaborator->getNumberOfCollaborators();
$projectsNumber = $project->getNumberOfProjects();
$completedProjectsNumber = $project->getNumberOfSpecificProjects("completed");
$inProgressProjectsNumber = $project->getNumberOfSpecificProjects("in_progress");
$inPreparationProjectsNumber = $project->getNumberOfSpecificProjects("in_preparation");
$publicationsNumber = $publication->getNumberOfPublications();
$orientationsNumber = $orientation->getNumberOfOrientations();
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <title>Relatório de Produtividade | SGPA</title>
  </head>

  <body>
    <?php require 'components/header.php'; ?>
    <div class="container">
      <div class="row">
        <div class="col">
          <h3>Relatório de Produtividade Acadêmica</h3>
          <div class="dropdown-divider mb-4"></div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>Número de colaboradores</h5>
          <p><?=$collaboratorsNumber?></p>
        </div>
        <div class="col">
          <h5>Número total de projetos</h5>
          <p><?=$projectsNumber?></p>
        </div>
        <div class="col">
          <h5>Número total de produções</h5>
          <p><?=$publicationsNumber.' publicações'?> e <?=$orientationsNumber.' orientações'?></p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>Projetos em preparação</h5>
          <p><?=$inPreparationProjectsNumber?></p>
        </div>
        <div class="col">
          <h5>Projetos em andamento</h5>
          <p><?=$inProgressProjectsNumber?></p>
        </div>
        <div class="col">
          <h5>Projetos concluídos</h5>
          <p><?=$completedProjectsNumber?></p>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

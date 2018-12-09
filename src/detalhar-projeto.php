<?php

require_once 'configs/Database.php';
require_once 'configs/Project.php';

$conn = new Database();
$project = new Project($conn->db);

$project->getProject();
$collaborators = $project->getCollaboratorsName($_GET['id']);
$publications = $project->getPublications($_GET['id']);
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
          <h3>Detalhar projeto</h3>
          <div class="dropdown-divider mb-4"></div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>Nome</h5>
          <p><?=$project->getTitle()?></p>
          <h5>Objetivo</h5>
          <p><?=$project->getObjective()?></p>
          <h5>Descrição</h5>
          <p><?=$project->getDescription()?></p>
          <div class="row">
              <div class="col">
                  <h5>Ag. Financiadora</h5>
                  <p><?=$project->getFundingAgency()?></p>
              </div>
              <div class="col col-5">
                  <h5>Custo total</h5>
                  <p><?=$project->getFinancedAmount()?></p>
              </div>
          </div>
          <div class="row">
              <div class="col">
                  <h5>Ínicio</h5>
                  <p><?=date('d/m/y', strtotime($project->getStartDate()))?></p>
              </div>
              <div class="col">
                  <h5>Término</h5>
                  <p><?=date('d/m/y', strtotime($project->getEndDate()))?></p>
              </div>
          </div>
        </div>
        <div class="col">
          <h5>Colaboradores envolvidos</h5>
          <?php foreach ($collaborators as $col) { ?>
            <span class="d-block"><?=$col['name']?></span>
          <?php } ?>
        </div>
        <div class="col">
          <h5>Publicações realizadas</h5>
          <?php foreach ($publications as $pub) { ?>
            <span class="d-block"><?=$pub['title']?> (<?=$pub['year']?>)</span>
          <?php } ?>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

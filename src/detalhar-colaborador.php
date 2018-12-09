<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';
require_once 'configs/Project.php';
require_once 'configs/Publication.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$project = new Project($conn->db);
$publication = new Publication($conn->db);

$collaborator->getCollaborator($_GET['id']);
$projects = $collaborator->getProjects($_GET['id']);
$publications = $collaborator->getPublications($_GET['id']);
$inProProjects = $collaborator->getInProgressProjects($_GET['id']);
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
          <h3>Detalhar colaborador</h3>
          <div class="dropdown-divider mb-4"></div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>Nome</h5>
          <p><?=$collaborator->getName()?></p>
          <h5>E-mail</h5>
          <p><?=$collaborator->getEmail()?></p>
          <h5>Nível acadêmico</h5>
          <p><?php 
                  if ($collaborator->getRole() == 'teacher') {
                    echo 'Professor';
                  }else if ($collaborator->getRole() == 'researcher') {
                    echo 'Pesquisador';
                  }else if ($collaborator->getRole() == 'grad_student') {
                    echo 'Graduando';
                  }else if ($collaborator->getRole() == 'mast_student') {
                    echo 'Mestrando';
                  }else if ($collaborator->getRole() == 'doct_student') {
                    echo 'Doutorando';
                  }
                ?></p>
          <h5>Institição de origem</h5>
          <p><?=$collaborator->getInstitution()?></p>
        </div>
        <div class="col">
          <h5>Projetos realizados</h5>
          <?php foreach ($projects as $pro) { ?>
            <span class="d-block"><?=$pro['title']?></span>
          <?php } ?>
          <h5 class="mt-3">Projetos em andamento</h5>
          <?php foreach ($inProProjects as $pro) { ?>
            <span class="d-block"><?=$pro['title']?></span>
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

<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';
require_once 'configs/Project.php';
require_once 'configs/Publication.php';
require_once 'configs/Orientation.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$project = new Project($conn->db);
$publication = new Publication($conn->db);
$orientation = new Orientation($conn->db);

$collaborators = $collaborator->getCollaborators();
$inPreProjects = $project->getInPreparationProjects();
$inProProjects = $project->getInProgressProjects();
$compProjects = $project->getCompletedProjects();
$publications = $publication->getPublications();
$orientations = $orientation->getOrientations();
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
    <title>Sistema de Gerenciamento de Atividade Acadêmica</title>
  </head>

  <body>
    <?php require 'components/header.php'; ?>
    <div class="container">
      <div class="row my-3">
        <div class="col">
          <a class="btn btn-success btn-block" href="cadastrar-colaborador.php" role="button">Cadastrar colaborador</a>
        </div>
        <div class="col">
          <a class="btn btn-success btn-block" href="cadastrar-projeto.php" role="button">Cadastrar projeto</a>
        </div>
        <div class="col">
          <a class="btn btn-success btn-block" href="cadastrar-publicacao.php" role="button">Cadastrar publicação</a>
        </div>
        <div class="col">
          <a class="btn btn-success btn-block" href="cadastrar-orientacao.php" role="button">Cadastrar orientação</a>
        </div>
        <div class="col">
          <a class="btn btn-success btn-block" href="relatorio-de-produtividade.php" role="button">Emitir relatório</a>
        </div>
      </div>
      <div class="row">
        <div class="col col-7">
          <section class="projects">
            <h3>Todos os projetos</h3>
            <div class="dropdown-divider"></div>
            <h5>Em preparação</h5>
            <table class="table">
          <thead class="text-white bg-danger">
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($inPreProjects as $pre) {?>
            <tr>
              <td scope="row">
                <?=$pre['title']?>
              </td>
              <td>
                <a class="btn btn-success btn-block" href="finalizar-elaboracao.php?id=<?=$pre['ID']?>" role="button">Finalizar elaboração</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <h5>Em andamento</h5>
        <small>Apenas é possível finalizar projetos que possuam publicações associadas.</small>
            <table class="table">
          <thead class="text-white bg-danger">
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($inProProjects as $pro) {?>
            <tr>
              <td scope="row">
                <a href="detalhar-projeto.php?id=<?=$pro['ID']?>"><?=$pro['title']?></a>
              </td>
              <td>
                <?php
                
                if($project->getNumberOfPublications($pro['ID']) > 0) {
                  ?>
                  <a class="btn btn-success btn-block" href="concluir-projeto.php?id=<?=$pro['ID']?>" role="button">Concluir projeto</a>
                
                
                <?php } ?>
                
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <h5>Concluídos</h5>
            <table class="table">
          <thead class="text-white bg-danger">
            <tr>
              <th scope="col">Nome</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($compProjects as $cpr) {?>
            <tr>
              <td scope="row">
                <a href="detalhar-projeto.php?id=<?=$cpr['ID']?>"><?=$cpr['title']?></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
          </section>
        </div>
        <div class="col col-5">
          <section class="members">
            <h3>Colaboradores atuais</h3>
            <div class="dropdown-divider"></div>
            <table class="table">
          <thead class="text-white bg-danger">
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Nível</th>
              <th scope="col">Instituição</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($collaborators as $col) {?>
            <tr>
              <td scope="row">
                <a href="detalhar-colaborador.php?id=<?=$col['ID']?>"><?php echo $col['name']; ?></a>
              </td>
              <td>
                <?php 
                  if ($col['role'] == 'teacher') {
                    echo 'Professor';
                  }else if ($col['role'] == 'researcher') {
                    echo 'Pesquisador';
                  }else if ($col['role'] == 'grad_student') {
                    echo 'Graduando';
                  }else if ($col['role'] == 'mast_student') {
                    echo 'Mestrando';
                  }else if ($col['role'] == 'doct_student') {
                    echo 'Doutorando';
                  }
                ?>
              </td>
              <td>
                <?php echo $col['institution']; ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
          </section>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h3>Produções acadêmicas</h3>
          <div class="dropdown-divider"></div>
          <div class="row">
            <div class="col">
              <h5>Publicações</h5>
              <table class="table">
          <thead class="text-white bg-danger">
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Conferência</th>
              <th scope="col">Ano</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($publications as $pub) {?>
            <tr>
              <th scope="row">
                <?=$pub['title']?>
              </th>
              <td>
                <?=$pub['conference_name']?>
              </td>
              <td>
                <?=$pub['year']?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
            </div>
            <div class="col">
              <h5>Orientações</h5>
              <table class="table">
          <thead class="text-white bg-danger">
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Ano</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orientations as $ori) {?>
            <tr>
              <td scope="row">
                <?=$pub['title']?>
              </td>
              <td>
                <?=$pub['year']?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

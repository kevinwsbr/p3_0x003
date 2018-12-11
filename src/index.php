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
          <a class="btn btn-success btn-block <?php if($collaborator->getNumberOfTeachers() == 0) { echo 'disabled'; } ?>" href="cadastrar-projeto.php" role="button">Cadastrar projeto</a>
        </div>
        <div class="col">
          <a class="btn btn-success btn-block <?php if($collaborator->getNumberOfTeachers() == 0) { echo 'disabled'; } ?>" href="cadastrar-publicacao.php" role="button">Cadastrar publicação</a>
        </div>
        <div class="col">
          <a class="btn btn-success btn-block <?php if($collaborator->getNumberOfTeachers() == 0 || $collaborator->getNumberOfStudents() == 0) { echo 'disabled'; } ?>" href="cadastrar-orientacao.php" role="button">Cadastrar orientação</a>
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
            <?php if($project->getNumberOfSpecificProjects('in_preparation') == 0) { ?>
            <span class="d-block mb-3">Não existem nenhum projeto em preparação. <?php if($collaborator->getNumberOfTeachers() == 0)  { ?><br/> Adicione um professor para poder iniciar um projeto. <?php } else { ?>Que tal <a href="cadastrar-projeto.php">iniciar um?</a> <?php } ?></span>
            <?php } else { ?>
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
        <?php } ?>
        <h5>Em andamento</h5>
        <?php if($project->getNumberOfSpecificProjects('in_progress') == 0) { ?>
        <span class="d-block mb-3">Não existem nenhum projeto em andamento.</span>
        <?php } else { ?>
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
                  <a class="btn btn-success btn-block <?php if($project->getNumberOfPublications($pro['ID']) == 0) { echo 'disabled'; } ?>" href="concluir-projeto.php?id=<?=$pro['ID']?>" role="button">Concluir projeto</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php } ?>
        <h5>Concluídos</h5>
        <?php if($project->getNumberOfSpecificProjects('completed') == 0) { ?>
          <span class="d-block mb-3">Ainda não existe nenhum projeto finalizado.</span>
        <?php } else { ?>
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
        <?php } ?>
          </section>
        </div>
        <div class="col col-5">
          <section class="members">
            <h3>Colaboradores atuais</h3>
            <div class="dropdown-divider"></div>
            <?php
            if($collaborator->getNumberOfCollaborators() == 0) { ?>
              <span class="d-block mb-3">Atualmente não há colaboradores cadastrados no laboratório.</span>
            <?php
            } else {
            ?>
            
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
        <?php } ?>
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
              <?php if($publication->getNumberOfPublications() == 0) { ?>
                <span class="d-block mb-3">Ainda não existem publicações cadastradas.</span>
              <?php } else { ?>
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
        <?php } ?>
            </div>
            <div class="col">
              <h5>Orientações</h5>
              <?php if($orientation->getNumberOfOrientations() == 0) { ?>
                <span class="d-block mb-3">Nenhuma orientação foi registrada ainda.</span>
              <?php } else { ?>
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
                <?=$ori['title']?>
              </td>
              <td>
                <?=$ori['year']?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

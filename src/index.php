<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';
require_once 'configs/Project.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$project = new Project($conn->db);

$collaborators = $collaborator->getCollaborators();
$inPreProjects = $project->getInPreparationProjects();
$inProProjects = $project->getInProgressProjects();
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
              <th scope="row">
                <?=$pre['title']?>
              </th>
              <td>
                <a class="btn btn-info btn-block" href="finalizar-elaboracao.php?id=<?=$pre['ID']?>" role="button">Finalizar elaboração</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <h5>Em andamento</h5>
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
              <th scope="row">
                <?=$pro['title']?>
              </th>
              <td>
                <a class="btn btn-info btn-block" href="finalizar-elaboracao.php?id=<?=$pro['ID']?>" role="button">Concluir projeto</a>
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
              <th scope="col">E-mail</th>
              <th scope="col">Nível</th>
              <th scope="col">Instituição</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($collaborators as $col) {?>
            <tr>
              <th scope="row">
                <?php echo $col['name']; ?>
              </th>
              <td>
                <?php echo $col['email']; ?>
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
        <a class="btn btn-info btn-block" href="cadastrar-colaborador.php" role="button">Adicionar colaborador</a>
          </section>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

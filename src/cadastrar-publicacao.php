<?php

require_once 'configs/Autoload.php';

$collaborator = new Teacher($conn->getInstance());
$project = new Project($conn->getInstance());
$publication = new Publication($conn->getInstance());

$collaborators = $collaborator->getCollaborators();
$teachers = $collaborator->getTeachers();
$projects = $project->getInProgressProjects();

$publication->register();
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>Cadastrar Publicação | SGPA</title>
</head>

<body>
  <?php require_once "components/header.php"; ?>
  <section class="container">
    <div class="row my-3">
      <div class="col col-12">
        <h3>Cadastrar nova publicação</h3>
      </div>
    </div>
    <div class="row">
      <div class="col col-12">
        <form action="cadastrar-publicacao.php" method="POST">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <label for="title">Título</label>
                    <input required type="text" name="title" class="form-control" id="title">
                </div>
                </div>
                <div class="col">
                    <div class="form-group">
                    <label for="conference_name">Conferência de publicação</label>
                    <input required type="text" name="conference_name" class="form-control" id="conference_name">
                </div>
                </div>
                <div class="col col-2">
                    <div class="form-group">
                    <label for="year">Ano de publicação</label>
                    <input required type="text" name="year" class="form-control" id="year">
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="project">Projeto associado</label>
                        <select required name="project" class="form-control" id="project">
                        <option selected value="0">n/a</option>
                        <?php foreach($projects as $pro) { ?>
                        <option value="<?=$pro['ID']?>"><?=$pro['title']?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <h5>Autores</h5>
            <?php foreach ($collaborators as $col) { ?>
                <div class="form-check-inline">
                    <input class="form-check-input" name="members[]" type="checkbox" value="<?=$col['ID']?>" id="check_<?=$col['ID']?>">
                    <label class="form-check-label" for="check_<?=$col['ID']?>">
                            <?php echo $col['name']; ?>
                        </label>
                    </div>
                    <?php } ?>
                </div>
            </div>
          <button type="submit" class="btn btn-success mb-4">Cadastrar publicação</button>
        </form>
      </div>
    </div>
  </section>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
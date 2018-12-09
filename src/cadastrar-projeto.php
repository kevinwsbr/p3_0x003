<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';
require_once 'configs/Project.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$project = new Project($conn->db);

$collaborators = $collaborator->getCollaborators();
$teachers = $collaborator->getTeachers();
$project->register();
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>Cadastrar Projeto | SGPA</title>
</head>

<body>
  <?php require_once "components/header.php"; ?>
  <section class="container">
    <div class="row my-3">
      <div class="col col-12">
        <h3>Cadastrar novo projeto</h3>
      </div>
    </div>
    <div class="row">
      <div class="col col-12">
        <form action="cadastrar-projeto.php" method="POST">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <label for="title">Título</label>
                    <input required type="text" name="title" class="form-control" id="title">
                </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="id_responsible">Professor responsável</label>
                        <select required name="id_responsible" class="form-control" id="id_responsible">
                        <?php foreach($teachers as $tea) { ?>
                        <option value="<?php echo $tea['ID']; ?>"><?php echo $tea['name']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
          
          <div class="form-group">
            <label for="objective">Objetivo</label>
            <textarea class="form-control" id="objective" name="objective" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="description">Descrição</label>
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
          </div>
          <div class="row">
              <div class="col">
                  <div class="form-group">
                    <label for="financed_amount">Custo</label>
                    <input type="text" name="financed_amount" class="form-control" id="financed_amount" placeholder="ex.: 50000,00">
                </div>
              </div>
              <div class="col">
                  <div class="form-group">
                    <label for="funding_agency">Entidade financiadora</label>
                    <input type="text" name="funding_agency" class="form-control" id="funding_agency" placeholder="ex.: CNPq">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                    <label for="start_date">Data de início</label>
                    <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo date("d/m/Y"); ?>">
                </div>
              </div>
              <div class="col">
                  <div class="form-group">
                    <label for="end_date">Data de término</label>
                    <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo date("d/m/Y"); ?>">
                </div>
              </div>
          </div>
          <button type="submit" class="btn btn-success mb-4">Cadastrar</button>
        </form>
      </div>
    </div>
  </section>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
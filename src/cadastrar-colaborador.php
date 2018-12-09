<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$collaborator->register();

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>Cadastrar Colaborador | SGPA</title>
</head>

<body>
  <?php require_once "components/header.php"; ?>
  <section class="container">
    <div class="row my-3">
      <div class="col col-12">
        <h3>Cadastrar novo colaborador</h3>
      </div>
    </div>
    <div class="row">
      <div class="col col-12">
        <form action="cadastrar-colaborador.php" method="POST">
          <div class="form-group">
            <label for="name">Nome</label>
            <input required type="text" name="name" class="form-control" id="name" placeholder="Nome do colaborador">
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="ex.: fulano@detal.com">
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="role">Nível acadêmico</label>
                <select name="role" class="form-control" id="role">
                  <option selected value="grad_student">Aluno de graduação</option>
                  <option value="mast_student">Aluno de mestrado</option>
                  <option value="doct_student">Aluno de doutorado</option>
                  <option value="teacher">Professor</option>
                  <option value="researcher">Pesquisador</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="institution">Instituição de origem</label>
                <input type="text" name="institution" class="form-control" id="institution" placeholder="ex.: UFAL">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-success">Cadastrar colaborador</button>
        </form>
      </div>
    </div>
  </section>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
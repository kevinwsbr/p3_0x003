<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';
require_once 'configs/Orientation.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$orientation = new Orientation($conn->db);

$teachers = $collaborator->getTeachers();
$students = $collaborator->getGraduationStudents();

$orientation->register();
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>Cadastrar Orientação | SGPA</title>
</head>

<body>
  <?php require_once "components/header.php"; ?>
  <section class="container">
    <div class="row my-3">
      <div class="col col-12">
        <h3>Cadastrar nova orientação</h3>
      </div>
    </div>
    <div class="row">
      <div class="col col-12">
        <form action="cadastrar-orientacao.php" method="POST">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <label for="title">Título</label>
                    <input required type="text" name="title" class="form-control" id="title">
                </div>
                </div>
                <div class="col col-3">
                    <div class="form-group">
                    <label for="year">Ano</label>
                    <input required type="text" name="year" class="form-control" id="year">
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="id_teacher">Professor responsável</label>
                        <select required name="id_teacher" class="form-control" id="id_teacher">
                        <?php foreach($teachers as $tea) { ?>
                        <option value="<?php echo $tea['ID']; ?>"><?php echo $tea['name']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="id_student">Aluno orientado</label>
                        <select required name="id_student" class="form-control" id="id_student">
                        <?php foreach($students as $stu) { ?>
                        <option value="<?php echo $stu['ID']; ?>"><?php echo $stu['name']; ?></option>
                        <?php } ?>
                        </select>
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
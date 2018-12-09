<?php

require_once 'configs/Database.php';
require_once 'configs/Collaborator.php';
require_once 'configs/Project.php';

$conn = new Database();
$collaborator = new Collaborator($conn->db);
$project = new Project($conn->db);

$project->getProject();
$collaborators = $collaborator->getCollaboratorsExcept($project->getIDResponsible());
$project->getStartDate();
$project->finalizeDraft();
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>Finalizar Elaboração | SGPA</title>
</head>

<body>
  <?php require_once "components/header.php"; ?>
  <section class="container">
    <div class="row my-3">
      <div class="col col-12">
        <h3>Finalizar elaboração de projeto</h3>
      </div>
    </div>
    <form action="finalizar-elaboracao.php?id=<?=$project->getID()?>" method="POST">
    <div class="row">
      <div class="col col-9">
          <h4>Detalhes da proposta</h4>
            <div class="dropdown-divider"></div>
            <div class="form-group">
                    <label for="title">Título</label>
                    <input required type="text" name="title" class="form-control" id="title" value="<?=$project->getTitle()?>">
                </div>
          
          <div class="form-group">
            <label for="objective">Objetivo</label>
            <textarea required class="form-control" id="objective" name="objective" rows="3"><?=$project->getObjective()?></textarea>
          </div>
          <div class="form-group">
            <label for="description">Descrição</label>
            <textarea required class="form-control" id="description" name="description" rows="5"><?=$project->getDescription()?></textarea>
          </div>
          <div class="row">
              <div class="col">
                  <div class="form-group">
                    <label for="financed_amount">Custo</label>
                    <input required type="text" name="financed_amount" class="form-control" id="financed_amount" value="<?=$project->getFinancedAmount()?>">
                </div>
              </div>
              <div class="col">
                  <div class="form-group">
                    <label for="funding_agency">Entidade financiadora</label>
                    <input required type="text" name="funding_agency" class="form-control" id="funding_agency" value="<?=$project->getFundingAgency()?>">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                    <label for="start_date">Data de início</label>
                    <input required type="date" name="start_date" class="form-control" id="start_date" value="<?php if(!empty($project->getStartDate())) { echo date("Y-m-d", strtotime($project->getStartDate())); } ?>">
                </div>
              </div>
              <div class="col">
                  <div class="form-group">
                    <label for="end_date">Data de término</label>
                    <input required type="date" name="end_date" class="form-control" id="end_date" value="<?php if(!empty($project->getEndDate())) { echo date("Y-m-d", strtotime($project->getEndDate())); } ?>">
                </div>
              </div>
          </div>
          
        </div>
        <div class="col col-3">
            <h4>Membros do projeto</h4>
            <div class="dropdown-divider"></div>
            <?php foreach ($collaborators as $col) {
              if(($col['role'] == "grad_student" && $collaborator->isStudentAvailable($col['ID'])) || $col['role'] != "grad_student") {  
              ?>
                <div class="form-check">
                    <input class="form-check-input" name="members[]" type="checkbox" value="<?=$col['ID']?>" id="check_<?=$col['ID']?>">
                    <label class="form-check-label" for="check_<?=$col['ID']?>">
                            <?php echo $col['name']; ?>
                        </label>
                    </div>
                    <?php } } ?>
                </div>
            </div>
            <button type="submit" class="btn btn-success mb-4">Iniciar projeto</button>
        </form>
  </section>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
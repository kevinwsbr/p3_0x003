<?php

include "Production.php";
include "iProduction.php";

class Project extends Production implements iProduction {
    protected $objective;
    protected $description;
    protected $fundingAgency;
    protected $financedAmount;
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $idResponsible;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getObjective ()
    {
        return $this->objective;
    }

    public function getDescription ()
    {
        return $this->description;
    }

    public function getFundingAgency ()
    {
        return $this->fundingAgency;
    }

    public function getFinancedAmount ()
    {
        return $this->financedAmount;
    }

    public function getStartDate ()
    {
        return $this->startDate;
    }

    public function getEndDate ()
    {
        return $this->endDate;
    }

    public function getStatus ()
    {
        return $this->status;
    }

    public function getIDResponsible ()
    {
        return $this->idResponsible;
    }

    public function getProject() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='GET') {
                $sql='SELECT * FROM `projects` WHERE `ID` = :ID ;';

                $db=$this->db->prepare($sql);
                $db->bindValue(':ID', $_GET['id'], PDO::PARAM_STR);
                $db->execute();

                $this->setData($db->fetch(PDO::FETCH_ASSOC));
            }
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getInPreparationProjects() {
        try {
            $sql = 'SELECT * from `projects` WHERE `status` = "in_preparation";';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getInProgressProjects() {
        try {
            $sql = 'SELECT * from `projects` WHERE `status` = "in_progress";';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getNumberOfPublications($projectID) {
        try {
            $sql = 'SELECT * from `publications` WHERE `id_project` = :idProject;';

            $db=$this->db->prepare($sql);

            $db->bindValue(':idProject', $projectID, PDO::PARAM_STR);
            $db->execute();

            return $db->rowCount();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getNumberOfProjects() {
        try {
            $sql = 'SELECT * from `projects`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->rowCount();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getNumberOfSpecificProjects($status) {
        try {
            $sql = 'SELECT * from `projects` WHERE `status` = :status;';

            $db=$this->db->prepare($sql);

            $db->bindValue(':status', $status, PDO::PARAM_STR);

            $db->execute();

            return $db->rowCount();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getCollaboratorsName($projectID) {
        try {
            $sql = 'SELECT `collaborators`.`name` from `projects` INNER JOIN `projects_and_collaborators` ON `projects_and_collaborators`.`id_project` = `projects`.`ID` INNER JOIN `collaborators` ON `projects_and_collaborators`.`id_collaborator` = `collaborators`.`ID` WHERE `projects`.`ID` = :projectID;';

            $db=$this->db->prepare($sql);

            $db->bindValue(':projectID', $projectID, PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getPublications($projectID) {
        try {
            $sql = 'SELECT * FROM `publications` WHERE `id_project` = :projectID ORDER BY `year` DESC;';

            $db=$this->db->prepare($sql);

            $db->bindValue(':projectID', $projectID, PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }
 
    public function completeProject() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='GET') {
                if($this->getNumberOfPublications($_GET['id']) > 0) {
                    $sql='UPDATE `projects` SET `status` = "completed" WHERE `ID` = :projectID;';
                    $db=$this->db->prepare($sql);

                    $db->bindValue(':projectID', $_GET['id'], PDO::PARAM_STR);
                    $db->execute();
                }
            }
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getCompletedProjects() {
        try {
            $sql = 'SELECT * from `projects` WHERE `status` = "completed";';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }

    }

    public function insertCollaborators ($idProject, $idCollaborator) {
        try {
            $sql='INSERT INTO `projects_and_collaborators` (`id_project`, `id_collaborator`) VALUES (:idProject, :idCollaborator);';

            $db=$this->db->prepare($sql);
            $db->bindValue(':idProject', $idProject, PDO::PARAM_STR);
            $db->bindValue(':idCollaborator', $idCollaborator, PDO::PARAM_STR);

            $db->execute();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function finalizeDraft() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql='UPDATE `projects` SET `title` = :title, `objective` = :objective, `description` = :description, `funding_agency` = :fundingAgency, `financed_amount` = :financedAmount, `start_date` = :startDate, `end_date` = :endDate, `status` = :status WHERE `ID` = :projectID;';

                if(empty($_POST['financed_amount'])) {
                    $value = NULL;
                } else {
                    $value = $_POST['financed_amount'];
                }

                if(empty($_POST['start_date'])) {
                    $start_date = NULL;
                } else {
                    $start_date = $_POST['start_date'];
                }

                if(empty($_POST['end_date'])) {
                    $end_date = NULL;
                } else {
                    $end_date = $_POST['end_date'];
                }

                $db=$this->db->prepare($sql);

                $db->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
                $db->bindValue(':objective', $_POST['objective'], PDO::PARAM_STR);
                $db->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $db->bindValue(':fundingAgency', $_POST['funding_agency'], PDO::PARAM_STR);
                $db->bindValue(':financedAmount', $value, PDO::PARAM_STR);
                $db->bindValue(':startDate', $start_date, PDO::PARAM_STR);
                $db->bindValue(':endDate', $end_date, PDO::PARAM_STR);
                $db->bindValue(':status', "in_progress", PDO::PARAM_STR);
                $db->bindValue(':projectID', $_GET['id'], PDO::PARAM_STR);

                if(isset($_POST['members']) && !empty($_POST['members'])) {
                    foreach($_POST['members'] as $member) {
                        $this->insertCollaborators($_GET['id'], $member);
                    }
                }

                $db->execute();
                header('Location: index.php');
            }
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function setData($project) {
        $this->ID = $project['ID'];
        $this->title = $project['title'];
        $this->objective = $project['objective'];
        $this->description = $project['description'];
        $this->fundingAgency = $project['funding_agency'];
        $this->financedAmount = $project['financed_amount'];
        $this->startDate = $project['start_date'];
        $this->endDate = $project['end_date'];
        $this->status = $project['status'];
        $this->idResponsible = $project['id_responsible'];
    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql='INSERT INTO `projects` (`title`, `objective`, `description`, `funding_agency`, `financed_amount`, `start_date`, `end_date`, `status`, `id_responsible`) VALUES (:title, :objective, :description, :funding_agency, :financed_amount, :start_date, :end_date, :status, :idresponsible);';

                if(empty($_POST['financed_amount'])) {
                    $value = NULL;
                } else {
                    $value = $_POST['financed_amount'];
                }

                if(empty($_POST['start_date'])) {
                    $start_date = NULL;
                } else {
                    $start_date = $_POST['start_date'];
                }

                if(empty($_POST['end_date'])) {
                    $end_date = NULL;
                } else {
                    $end_date = $_POST['end_date'];
                }

                $db=$this->db->prepare($sql);
                $db->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
                $db->bindValue(':objective', $_POST['objective'], PDO::PARAM_STR);
                $db->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $db->bindValue(':funding_agency', $_POST['funding_agency'], PDO::PARAM_STR);
                $db->bindValue(':financed_amount', $value, PDO::PARAM_STR);
                $db->bindValue(':start_date', $start_date, PDO::PARAM_STR);
                $db->bindValue(':end_date', $end_date, PDO::PARAM_STR);
                $db->bindValue(':status', "in_preparation", PDO::PARAM_STR);
                $db->bindValue(':idresponsible', $_POST['id_responsible'], PDO::PARAM_STR);

                $db->execute();

                $sql='SELECT ID FROM `projects` WHERE `title` = :projTitle;';

                $db=$this->db->prepare($sql);
                $db->bindValue(':projTitle', $_POST['title'], PDO::PARAM_STR);

                $db->execute();

                $pro = $db->fetch(PDO::FETCH_ASSOC);

                $this->insertCollaborators($pro['ID'], $_POST['id_responsible']);

                header('Location: index.php');
            }
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }
    
}
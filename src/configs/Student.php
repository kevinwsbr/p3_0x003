<?php

class Student extends Collaborator
{
    protected $role;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function isStudentAvailable($collaboratorID) {
        $sql = 'SELECT * FROM `collaborators` INNER JOIN `projects_and_collaborators` ON `projects_and_collaborators`.`id_collaborator` = `collaborators`.`ID` INNER JOIN `projects` ON `projects`.`ID` = `projects_and_collaborators`.`id_project` AND `projects`.`status` = "in_progress" WHERE `collaborators`.`ID` = :collaboratorID;';

        $db=$this->db->prepare($sql);

        $db->bindValue(':collaboratorID', $collaboratorID, PDO::PARAM_STR);

        $db->execute();

        return ($db->rowCount() < 2) ? 1 : 0;
    }

    public function getNumberOfStudents() {
        $sql='SELECT * FROM `collaborators` WHERE `role` = "grad_student";';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->rowCount();
    }

    public function getGraduationStudents() {
        $sql='SELECT * FROM `collaborators` WHERE `role` = "grad_student";';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }
}
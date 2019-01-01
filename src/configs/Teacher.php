<?php 

class Teacher extends Collaborator {
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getTeachers() {
        $sql='SELECT * FROM `collaborators` WHERE `role` = "teacher";';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNumberOfTeachers() {
        $sql='SELECT * FROM `collaborators` WHERE `role` = "teacher";';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->rowCount();
    }
}

?>
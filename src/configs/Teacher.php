<?php 

class Teacher extends Collaborator {
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getTeachers() {
        try {
            $sql='SELECT * FROM `collaborators` WHERE `role` = "teacher";';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }

    }
}
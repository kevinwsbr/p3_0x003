<?php

class Orientation extends Production implements iProduction {
    protected $year;
    protected $idTeacher;
    protected $idStudent;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getYear ()
    {
        return $this->year;
    }

    public function getIDTeacher ()
    {
        return $this->idTeacher;
    }

    public function getIDStudent ()
    {
        return $this->idStudent;
    }

    public function setData($orientation) {
        $this->ID = $orientation['ID'];
        $this->title = $orientation['title'];
        $this->year = $orientation['year'];
        $this->idTeacher = $orientation['idTeacher'];
        $this->idStudent = $orientation['idStudent'];
    }
    
    public function getOrientations() {
        try {
            $sql = 'SELECT * from `orientations`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getOrientationsOf($collaboratorID) {
        try {
            $sql = 'SELECT * from `orientations` WHERE `id_teacher` = :collaboratorID OR `id_student` = :collaboratorID ORDER BY `year` DESC;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':collaboratorID', $collaboratorID, PDO::PARAM_STR);

            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function getNumberOfOrientations() {
        try {
            $sql = 'SELECT * from `orientations`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->rowCount();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST') {

                $sql='INSERT INTO `orientations` (`title`, `year`, `id_teacher`, `id_student`) VALUES (:title, :year, :idTeacher, :idStudent);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
                $db->bindValue(':year', $_POST['year'], PDO::PARAM_STR);
                $db->bindValue(':idTeacher', $_POST['id_teacher'], PDO::PARAM_STR);
                $db->bindValue(':idStudent', $_POST['id_student'], PDO::PARAM_STR);

                $db->execute();

                header('Location: index.php');
            }
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }
    }
}
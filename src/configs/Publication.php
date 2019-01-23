<?php

class Publication extends Production implements iProduction {
    protected $conferenceName;
    protected $year;
    protected $authors;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getConferenceName ()
    {
        return $this->conferenceName;
    }

    public function getYear ()
    {
        return $this->year;
    }

    public function getAuthors ()
    {
        return $this->authors;
    }

    public function setData($publication) {
        $this->ID = $publication['ID'];
        $this->title = $publication['title'];
        $this->conferenceName = $publication['conferenceName'];
        $this->year = $publication['year'];
        $this->authors = $publication['authors'];
    }
    
    public function getPublications() {
        try {
            $sql = 'SELECT * from `publications`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }

    }

    public function getNumberOfPublications() {
        try {
            $sql = 'SELECT * from `publications`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->rowCount();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }

    }

    public function insertAuthors ($idPublication, $idAuthor) {
        try {
            $sql='INSERT INTO `publications_and_collaborators` (`id_publication`, `id_collaborator`) VALUES (:idPublication, :idCollaborator);';

            $db=$this->db->prepare($sql);
            $db->bindValue(':idPublication', $idPublication, PDO::PARAM_STR);
            $db->bindValue(':idCollaborator', $idAuthor, PDO::PARAM_STR);

            $db->execute();
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }

    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                print_r($_POST);
                $sql='INSERT INTO `publications` (`title`, `conference_name`, `year`, `id_project`) VALUES (:title, :conferenceName, :year, :idProject);';

                if(empty($_POST['project']) || $_POST['project'] == '0') {
                    $project = NULL;
                } else {
                    $project = $_POST['project'];
                }

                $db=$this->db->prepare($sql);
                $db->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
                $db->bindValue(':conferenceName', $_POST['conference_name'], PDO::PARAM_STR);
                $db->bindValue(':year', $_POST['year'], PDO::PARAM_STR);
                $db->bindValue(':idProject', $project, PDO::PARAM_STR);

                $db->execute();

                $sql='SELECT ID FROM `publications` WHERE `title` = :pubTitle;';

                $db=$this->db->prepare($sql);
                $db->bindValue(':pubTitle', $_POST['title'], PDO::PARAM_STR);

                $db->execute();

                $pub = $db->fetch(PDO::FETCH_ASSOC);

                if(isset($_POST['members']) && !empty($_POST['members'])) {
                    foreach($_POST['members'] as $member) {
                        $this->insertAuthors($pub['ID'], $member);
                    }
                }

                header('Location: index.php');
            }
        } catch(PDOException $e) {
            echo 'Ops, o sistema apresentou o seguinte erro: ' . $e->getMessage();
        }

    }
    
}
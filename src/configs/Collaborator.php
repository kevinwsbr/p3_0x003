<?php

class Collaborator {
    protected $ID;
    protected $name;
    protected $email;
    protected $role;
    protected $institution;
    protected $dn;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getID ()
    {
        return $this->ID;
    }

    public function getName ()
    {
        return $this->name;
    }

    public function getEmail ()
    {
        return $this->email;
    }

    public function getRole ()
    {
        return $this->role;
    }

    public function getInstitution ()
    {
        return $this->institution;
    }


    public function getCollaborator($collaboratorID) {
        $sql='SELECT * FROM `collaborators` WHERE `ID` = :ID ;';

        $db=$this->db->prepare($sql);
        $db->bindValue(':ID', $collaboratorID, PDO::PARAM_STR);
        $db->execute();

        $this->setData($db->fetch(PDO::FETCH_ASSOC));
    }

    public function getTeachers() {
        $sql='SELECT * FROM `collaborators` WHERE `role` = "teacher";';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setData($collaborator)
    {
        $this->ID = $collaborator['ID'];
        $this->name = $collaborator['name'];
        $this->email = $collaborator['email'];
        $this->role = $collaborator['role'];
        $this->institution = $collaborator['institution'];
    }

    public function getCollaborators()
    {
        $sql='SELECT * FROM `collaborators`;';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNumberOfCollaborators()
    {
        $sql='SELECT * FROM `collaborators`;';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->rowCount();
    }

    public function getCollaboratorsExcept($collaboratorID)
    {
        $sql='SELECT * FROM `collaborators` WHERE `ID` != :collaboratorID;';

        $db=$this->db->prepare($sql);

        $db->bindValue(':collaboratorID', $collaboratorID, PDO::PARAM_STR);
        
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql='INSERT INTO `collaborators` (`name`, `email`, `role`, `institution`) VALUES (:name, :email, :role, :institution);';
            
            $db=$this->db->prepare($sql);
            $db->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
            $db->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $db->bindValue(':role', $_POST['role'], PDO::PARAM_STR);
            $db->bindValue(':institution', $_POST['institution'], PDO::PARAM_STR);
            
            $db->execute();
            header('Location: index.php');
        }
    }
    
}
?>
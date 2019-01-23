<?php

class Production
{
    protected $ID;
    protected $title;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getID ()
    {
        return $this->ID;
    }

    public function getTitle ()
    {
        return $this->title;
    }
}
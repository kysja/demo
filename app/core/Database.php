<?php

namespace app\core;

use PDO;

class Database 
{   
    public $dbc;
    private $stm;

    public function __construct($dbConfig)
    {
        $dsn = "mysql:host=" . $dbConfig['host'] . ";port=" . $dbConfig['port'] . ";dbname=" . $dbConfig['dbname'];
        $this->dbc = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }

	public function query($query, $params = [])
	{
		$this->stm = $this->dbc->prepare($query);
        $this->stm->execute($params);
        return $this;
	}
    
    public function fetch()
    {
        return $this->stm->fetch();
    }

    public function fetchAll()
    {
        return $this->stm->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->dbc->lastInsertId();
    }

    public function rowCount()
    {
        return $this->stm->rowCount();
    }
	
    public function fetchColumn()
    {
        return $this->stm->fetchColumn();
    }

}
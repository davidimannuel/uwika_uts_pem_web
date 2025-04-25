<?php

namespace Core;

use PDO;

class Database 
{
  public $connection;
  public $statement;

  public function __construct($config) {
    // connect to postgresql database
    // $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=postgres;options='--search_path=public'";
    $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};options='--search_path={$config['schema']}'";
    $this->connection = new PDO($dsn, $config["username"], $config["password"], [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode to associative array
    ]);
  }

  public function query($query, $params = []) { 

    $this->statement = $this->connection->prepare($query);
    $this->statement->execute($params);

    return $this;
  }

  // fetch all rows
  // return $this->statement->fetchAll(PDO::FETCH_ASSOC); // example of fetching all rows as associative array
  // return $this->statement->fetchAll(PDO::FETCH_OBJ); // example of fetching all rows as objects
  public function get() 
  {
    return $this->statement->fetchAll();
  }
  
  // retrieve a single row
  public function find()
  {
    return $this->statement->fetch();
  }
  
  public function findOrFail()
  {
    $result = $this->find();
    if (!$result) {
      abort(404);
    }

    return $result;
  }
}

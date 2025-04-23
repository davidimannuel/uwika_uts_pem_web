<?php

class Database {
  public $connection;

  public function __construct($config) {
    // connect to postgresql database
    // $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=postgres;options='--search_path=public'";
    $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};options='--search_path={$config['schema']}'";
    $this->connection = new PDO($dsn, $config["username"], $config["password"], [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode to associative array
    ]);
  }

  public function query($query, $params = []) { 

    $statement = $this->connection->prepare($query);
    $statement->execute($params);

    return $statement;
  }
  
}

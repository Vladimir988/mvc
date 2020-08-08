<?php

namespace application\lib;

use PDO;

class Db {

  private $pdo;
  private $tables;

  /**
   * Database constructor
   */
  public function __construct() {
    $this->connect();

    $users     = 'users';
    $countries = 'countries';
    if( ! $this->tableExists( $users ) || ! $this->tableExists( $countries ) ) {

      $countries = require_once( 'application/config/countries.php' );
      try {
          $this->pdo->exec("CREATE TABLE `users` (
                              `ID` int(11) NOT NULL,
                              `name` varchar(255) NOT NULL,
                              `email` varchar(100) NOT NULL,
                              `country` varchar(100) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

          $this->pdo->exec("CREATE TABLE `countries` (
                              `ID` int(11) NOT NULL,
                              `lang` varchar(100) NOT NULL,
                              `lang_name` varchar(100) NOT NULL,
                              `country_alpha2_code` varchar(100) NOT NULL,
                              `country_alpha3_code` varchar(100) NOT NULL,
                              `country_numeric_code` varchar(100) NOT NULL,
                              `country_name` varchar(100) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

          $this->pdo->exec("ALTER TABLE `users` ADD PRIMARY KEY (`ID`)");
          $this->pdo->exec("ALTER TABLE `users` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT");
          $this->pdo->exec("ALTER TABLE `countries` ADD PRIMARY KEY (`ID`)");
          $this->pdo->exec("ALTER TABLE `countries` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT");


          $this->pdo->exec("{$countries}");

      } catch (PDOException $e) {
          die("DB ERROR: ". $e->getMessage());
      }
    }
  }

  /**
   * @return $this
   */
  private function connect() {
    $config     = require_once( 'application/config/db-config.php' );
    $dsn        = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
    $username   = $config['username'];
    $password   = $config['password'];
    return $this->pdo = new PDO( $dsn, $username, $password );
  }

  /**
   * @param $table
   * @return boolean
  */
  public function tableExists( $table ) {

    try {
      $result = $this->pdo->query("SELECT 1 FROM {$table} LIMIT 1");
    } catch (Exception $e) {
      return false;
    }
    return $result !== false;
  }

  /**
   * @param $sql
   * @return mixed
   */
  public function query( $sql ) {
    $query  = $this->pdo->query( $sql );
    return $query;
  }

  /**
   * @param $sql
   * @return string
   */
  public function row( $sql ) {
    $query  = $this->pdo->query( $sql );
    $result = $query->fetchAll( PDO::FETCH_ASSOC );
    return $result;
  }

  /**
   * @param $sql
   * @return array
   */
  public function column( $sql ) {
    $query  = $this->pdo->query( $sql );
    $result = $query->fetchColumn();
    return $result;
  }

  /**
   * @param $table, $args
   * @return mixed
  */
  public function insert( $table, $args ) {
    $keys      = implode( ',', array_keys( $args ) );
    $values    = ':' . implode( ', :', array_keys( $args ) );
    $sql       = "INSERT INTO {$table} ({$keys}) VALUES ({$values})";
    $statement = $this->pdo->prepare( $sql );
    return $statement->execute( $args );
  }

  /**
   * @param $table, $args, $where
   * @return int|false The number of rows updated, or false on error.
  */
  public function update( $table, $args, $where ) {

    if ( ! is_array( $args ) || ! is_array( $where ) ) {
      return false;
    }

    $fields     = array();
    $conditions = array();

    foreach( $args as $field => $value ) {
      $fields[] = "{$field} = :" . $field;
    }

    foreach( $where as $field => $value ) {
      $conditions[] = "{$field} = :" . $field;
    }

    $fields     = implode( ', ', $fields );
    $conditions = implode( ' AND ', $conditions );

    $sql = "UPDATE {$table} SET {$fields} WHERE {$conditions}";
    $statement = $this->pdo->prepare( $sql );
    return $statement->execute( $args );
  }

  /**
   * @param $table, $where
   * @return int|false The number of rows updated, or false on error.
  */
  public function delete( $table, $where ) {

    if ( ! is_array( $where ) ) {
      return false;
    }

    $conditions = array();
    foreach( $where as $field => $value ) {
      $conditions[] = "{$field} = :" . $field;
    }

    $conditions = implode( ' AND ', $conditions );

    $sql = "DELETE FROM {$table} WHERE {$conditions}";
    $statement = $this->pdo->prepare( $sql );
    return $statement->execute( $where );
  }
}
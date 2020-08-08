<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

  public function getUsers( $sql ) {
    return $result = $this->pdo->row( $sql );
  }

  public function deleteUser( $table, $where ) {
    return $result = $this->pdo->delete( $table, $where );
  }
}
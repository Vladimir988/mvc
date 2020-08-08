<?php

namespace application\models;

use application\core\Controller;
use application\core\View;
use application\core\Model;

class User extends Model {

  public function getQuery( $sql ) {
    return $result = $this->pdo->row( $sql );
  }

  public function addUser( $table, $args ) {
    if( $this->checkEmail( $args ) === '0' ) {
      return $result = $this->pdo->insert( $table, $args );
    } else {
      return false;
    }
  }

  public function checkEmail( $args ) {
    $sql = "SELECT COUNT(`ID`) FROM `users` WHERE `email` = '{$args['email']}'";
    return $result = $this->pdo->column( $sql );
  }

  public function updateUser( $table, $args, $where ) {
    $sql         = "SELECT COUNT(`ID`) FROM {$table} WHERE `email` = '{$args['email']}' AND `ID` NOT IN ('{$args['ID']}')";
    $check_email = $this->pdo->column( $sql );

    if( (int) $check_email === 0 ) {
      return $result = $this->pdo->update( $table, $args, $where );
    } elseif((int) $check_email > 0  ) {
      return 'This email is already registered, please choose another one.';
    } else {
      return false;
    }
  }
}
<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\core\Model;

class UserController extends Controller {

  public function addAction() {
    $sql    = "SELECT * FROM `countries`";
    $result = $this->model->getQuery( $sql );
    $vars   = array( 'countries' => $result );

    if( ! empty( $_POST ) ) {
      $args = array(
        'name'    => $_POST['name'],
        'email'   => $_POST['email'],
        'country' => $_POST['country']
      );
      $result = $this->model->addUser( $_POST['table'], $args );
      if( $result === true ) {
        $this->view->location( '/' );
      } else {
        $this->view->message( 400, 'This email already exists!' );
      }
    }

    $this->view->render( 'Add User Page', $vars );
  }

  public function editAction() {

    if( ! empty( $_POST ) ) {
      $args = array(
        'ID'      => $_POST['userid'],
        'name'    => $_POST['name'],
        'email'   => $_POST['email'],
        'country' => $_POST['country']
      );
      $where = array( 'ID' => $_POST['userid'] );
      $result = $this->model->updateUser( $_POST['table'], $args, $where );
      if( $result === true ) {
        $this->view->location( '/' );
      } elseif( $result === false ) {
        $this->view->message( 400, 'Something went wrong!' );
      } else {
        $this->view->message( 400, $result );
      }
    }

    $vars = array();
    if( isset( $_GET['userid'] ) && $_GET['userid'] != '' ) {
      $user          = "SELECT * FROM `users` WHERE `ID` = '" . $_GET['userid'] . "'";
      $user_res      = $this->model->getQuery( $user );
      if( ! empty( $user_res ) ) {
        $countries     = "SELECT * FROM `countries`";
        $countries_res = $this->model->getQuery( $countries );
        $vars          = array( 'user' => $user_res[0], 'countries' => $countries_res );
      }
    }

    $this->view->render( 'Edit Page', $vars );
  }
}
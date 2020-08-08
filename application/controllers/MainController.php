<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\core\Model;

class MainController extends Controller {

  public function indexAction() {

    if( isset( $_POST['action'] ) && $_POST['action'] == 'edit_user' ) {
      $this->view->location( '/user/edit' );
      exit;
    }

    if( isset( $_POST['action'] ) && $_POST['action'] == 'delete_user' ) {
      $result = $this->model->deleteUser( $_POST['table'], array( 'ID' => $_POST['user_id'] ) );
      if( $result !== false ) {
        $this->view->message( 200, 'User was deleted!' );
      } else {
        $this->view->message( 400, 'Something went wrong!' );
      }
    }

    $limit = 10;
    $from  = 0;
    if( isset( $_GET['p'] ) && $_GET['p'] != '' ) {
      $page = $_GET['p'];
      $from = $page * $limit - $limit;
    }

    $users_sql = "SELECT * FROM `users` LIMIT {$from}, {$limit}";
    $users     = $this->model->getUsers( $users_sql );
    
    $count_pages_sql = "SELECT COUNT(*) AS count FROM `users`";
    $count_pages     = $this->model->getUsers( $count_pages_sql );

    $vars = array(
      'users'       => $users,
      'count_pages' => ceil( $count_pages[0]['count'] / $limit )
    );
    $this->view->render( 'Main Page', $vars );
  }
}
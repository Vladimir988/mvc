<?php

namespace application\core;

use application\core\View;

abstract class Controller {

  public $route;
  public $view;
  public $model;

  public function __construct( $route ) {
    $this->route = $route;
    $this->checkAcl();
    $this->view  = new View( $route );
    $this->model = $this->loadModel( $route['controller'] );
  }

  public function loadModel( $name ) {
    $class = 'application\models\\' . ucfirst( $name );
    if( class_exists( $class ) ) {
      return new $class;
    }
  }

  public function checkAcl() {
    $acl = 'application/acl/' . $this->route['controller'] . '.php';
    if( file_exists( $acl ) ) {
      require $acl;
    }
  }
}
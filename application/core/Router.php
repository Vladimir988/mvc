<?php

namespace application\core;

use application\core\View;

class Router {

  protected $routes = array();

  protected $params = array();

  public function __construct() {
    $arr = require 'application/config/routes.php';

    foreach( $arr as $key => $val ) {
      $this->add( $key, $val );
    }
  }

  public function add( $route, $params ) {
    $route = '#^' . $route . '$#';
    $this->routes[$route] = $params;
  }

  public function match() {
    $url = trim( $_SERVER['REQUEST_URI'], '/' );
    foreach( $this->routes as $route => $params ) {

      if( $params['controller'] == 'user' && $params['action'] == 'edit' ) {
        $pattern = str_replace( '$#', '(\\?userid=\d+)??$#', $route );
      } elseif( $params['controller'] == 'main' && $params['action'] == 'index' ) {
        $pattern = str_replace( '$#', '(\\?p=\d+)??$#', $route );
      } else {
        $pattern = $route;
      }

      if( preg_match( $pattern, $url, $matches ) ) {
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  public function run() {
    if( $this->match() ) {
      $path = 'application\controllers\\' . ucfirst( $this->params['controller'] ) . 'Controller';
      if( class_exists( $path ) ) {
        $action = ucfirst( $this->params['action'] ) . 'Action';
        if( method_exists( $path, $action ) ) {
          $controller = new $path( $this->params );
          $controller->$action();
        } else {
          View::errorCode(404);
        }
      } else {
        View::errorCode(404);
      }
    } else {
      View::errorCode(404);
    }
    exit;
  }
}
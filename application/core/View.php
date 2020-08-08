<?php

namespace application\core;

class View {

  public $path;
  public $route;
  public $layout = 'default';

  public function __construct( $route ) {
    $this->route = $route;
    $this->path  = $route['controller'] . '/' . $route['action'];
  }

  public function render( $title, $vars = array() ) {
    if( file_exists( 'application/views/' . $this->path . '.php' ) ) {
      extract( $vars );
      ob_start();
      require 'application/views/' . $this->path . '.php';
      $content = ob_get_clean();
      if( file_exists( 'application/views/layouts/' . $this->layout . '.php' ) ) {
        require 'application/views/layouts/' . $this->layout . '.php';
      }
    } else {
      echo 'Location not found: ' . $this->path;
    }
  }

  public static function errorCode( $code ) {
    http_response_code( $code );
    if( file_exists( 'application/views/errors/' . $code . '.php' ) ) {
      exit( require 'application/views/errors/' . $code . '.php' );
    }
  }

  public static function redirect( $url ) {
    header( 'Location: ' . $url );
    exit;
  }

  public function message( $status, $message ) {
    exit( json_encode( array( 'status' => $status, 'message' => $message ) ) );
  }

  public function location( $url ) {
    exit( json_encode( array( 'url' => $url ) ) );
  }
}
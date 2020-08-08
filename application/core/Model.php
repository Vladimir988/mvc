<?php

namespace application\core;

use application\lib\Db;

abstract class Model {

  public $pdo;

  public function __construct() {
    $this->pdo = new Db;
  }
}
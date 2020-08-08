<?php

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

function dd( $str ) {
  echo '<pre>';
  var_dump($str);
  echo '</pre>';
  exit;
}

function get_pagination( $count_pages = 1, $page = 1 ) {

  $back        = null;
  $forward     = null;
  $startpage   = null;
  $endpage     = null;
  $page2left   = null;
  $page1left   = null;
  $page2right  = null;
  $page1right  = null;

  if( $page > 1 ) {
    $back = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".($page-1)."'><i class='fa fa-angle-left'></i></a>";
  }
  if( $page < $count_pages ) {
    $forward = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".($page+1)."'><i class='fa fa-angle-right'></i></a>";
  }
  if( $page > 3 ) {
    $startpage = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".(1)."'><i class='fa fa-angle-double-left'></i></a>";
  }
  if( $page < ($count_pages - 2) ) {
    $endpage = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".$count_pages."'><i class='fa fa-angle-double-right'></i></a>";
  }
  if( $page - 2 > 0 ) {
    $page2left = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".($page-2)."'>".($page-2)."</a>";
  }
  if( $page - 1 > 0 ) {
    $page1left = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".($page-1)."'>".($page-1)."</a>";
  }
  if( $page + 1 <= $count_pages ) {
    $page1right = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".($page+1)."'>".($page+1)."</a>";
  }
  if( $page + 2 <= $count_pages ) {
    $page2right = "<a style='margin:0 5px;' class='btn btn-outline-primary' href='?p=".($page+2)."'>".($page+2)."</a>";
  }

  return sprintf(
    '<div class="pagination-links" style="text-align:center;">%s</div>', 
    $startpage.$back.$page2left.$page1left.'<a class="btn btn-primary" style="color:#fff;margin:0 5px;">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage
  );
}
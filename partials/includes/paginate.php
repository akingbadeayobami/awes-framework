<?php
public static function pagination($data,$number,$class){

  $allPages = ceil(count($data) / $number);

  if(isset($_GET['page']) && $_GET['page'] > 0){

    if ($_GET['page'] > 0){

      $previous = $_GET['page'] - 1;

    } else {

      $previous = 1;

    }


    echo '<a href="?page=' . $previous . '" class="'.$class.'">Previous</a>';

  }

  echo "&nbsp;&nbsp;";

  if (isset($_GET['page'])){

    $page = $_GET['page'];

    $next = $_GET['page'] + 1;

  } else {

    $next = 1;

    $page = 0;

  }

  if($page < $allPages - 1){

    echo '<a href="?page='.$next.'" class="'.$class.'">Next</a>';

  }

  echo '( Page of ' . ($page + 1) .  '/' . $allPages . ')';

  return $data = array_slice($data, $page * $number, $number);



?>

<?php
class Error{

  public static function get($field){

    if(isset($GLOBALS['errors'])){

      foreach($GLOBALS['errors'] as $temp){

        if ($temp[0] == $field){

          return $temp[1];

        }

      }

    }

    return false;

  }

  public static function has($field){

    if(isset($GLOBALS['errors'])){

      foreach($GLOBALS['errors'] as $temp){

        if ($temp[0] == $field){

          return true;

        }

      }

    }

    return false;

  }

}

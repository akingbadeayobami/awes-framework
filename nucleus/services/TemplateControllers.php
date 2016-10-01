<?php

class TemplateController {

  public static function admin(){

    $this->processForm('create',$instance,'create');

    $this->processForm('delete',$instance,'delete');

    $this->processForm('update',$instance,'update');

    $return = [];

    $return['view'] =  $this->callFunc($instance,'readThis',[$viewId])->data;

    $return['notifications'] = $this->callFunc('notification','get')->data;

    $return['profile'] =  $this->callFunc('profile','get', [Session::get('matric')])->data;

    return $return;

  }

  public static function default(){

    $this->processForm('logout','User','logout');

    $this->permission(true);

    $return = [];

    $return['myCourses'] =  $this->callFunc('course','my')->data;

    $return['notifications'] = $this->callFunc('notification','get')->data;

    $return['profile'] =  $this->callFunc('profile','get', ["person" => Session::get('matric')])->data;

    return $return;

  }

}

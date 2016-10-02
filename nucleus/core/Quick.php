<?php

use Nucleus\Core\Neutron;
use Nucleus\Core\Config;
use Nucleus\Core\Route;
use Nucleus\Core\Token;
use Nucleus\Core\Validate;

  function url($to = ""){

    return Route::to($to);

  }

  function cg($object){

    return Config::get($object);

  }

  function ns($string){

    return Neutron::sanitize($string);

  }

  function vd($data){
  	return var_dump($data);
  }

  function ve($data){
    var_dump($data);
    exit();
  }

  function csrfToken(){

    return '<input type="hidden" name="' . cg('session.token_name') . '" value="' . Token::generate() . '">';

  }

  function inputField($object){

    $object = explode('.',$object);

    $model = $object[0];

    $field = $object[1];

    $nameSpace = "Nucleus\Model\\" . $model;

    $model = new $nameSpace;

    $validate = new Validate();

    $fieldValidation = $model->validations()->$field;

    $fieldValidation = explode('|',$fieldValidation);

    $type = "text";

    $htmlValidation = "";

    foreach($fieldValidation as $each){

      if(!strpos($each,":")){

        if(in_array($each,array_keys(CoreExtension::get('validation.input_fields')))){

          $type = "$each";

        }

        switch($each){

          case "required" :

            $htmlValidation .= " required ";

          break;

        }

      }else{

        $each = explode(":",$each);

        $value = $each[1];

        switch($each[0]){

          case 'title' :

            $htmlValidation .= ' placeholder="' . $value . '" ';

          break;

          case 'min' :

            $htmlValidation .= ' min="' . $value . '" ';

          break;

          case 'max' :

            $htmlValidation .= ' max="' . $value . '" ';

          break;

          case 'pattern' :

            $htmlValidation .= ' pattern="' . $value . '" title="' . $each[2] . '" ';

          break;

          default:

          //  $htmlValidation .= ' ' . $each[0] . '="' . $value . '" ';

          break;

        }

      }

    }

    return 'type="' . $type . '" name="' . $field . '"' . $htmlValidation;

    //$validation = (isset($model->validations()->$method)) ? $model->validations()->$method : [];


  }

 ?>

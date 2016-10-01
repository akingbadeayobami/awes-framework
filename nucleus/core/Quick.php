<?php
  function url($content = ""){
      return Config::get('site/url') . '/' . $content;
  }

  function vd($data){
  	return var_dump($data);
  }

  function ve($data){
    var_dump($data);
    exit();
  }

  function csrfToken(){

    return '<input type="hidden" name="' . Config::get('session.token_name') . '" value="' . Token::generate() . '">';

  }

  function inputField($model,$field){

    $model = new $model();

    $validate = new Validate();

    $fieldValidation = $model->validations()->$field;

    $fieldValidation = explode(',',$fieldValidation);

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

            $htmlValidation .= ' pattern="' . $value . '" ';

          break;

          default:

            $htmlValidation .= ' ' . $each[0] . '="' . $value . '" ';

          break;

        }

      }

    }

    return 'type="' . $type . '" name="' . $field . '"' . $htmlValidation;

    //$validation = (isset($model->validations()->$method)) ? $model->validations()->$method : [];


  }

 ?>

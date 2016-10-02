<?php
namespace Nucleus\Core;

  trait ModelWrapper{

    public function validations(){

      return (object) $this->_validations;

    }

}

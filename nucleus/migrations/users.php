<?php
  class Users Extends Migration {

    public __construct(){

        $this->id();

        $this->field('email')->text()->default('0')->max(32);

        $this->field('fname')->varchar(32);

        $this->field('lname')->varchar(32);

    }


  }


 ?>

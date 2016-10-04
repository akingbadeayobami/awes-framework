<?php
  class Users Extends Migration {

    public $sql = "";

    public $fieldsSql = "";

    public __construct(){

        $this->generate('users', function($this){

          $this->id()->migrate();

          $this->field('email')->text()->default('0')->max(32)->migrate();

          $this->field('fname')->varchar(32)->migrate();

          $this->field('lname')->varchar(32)->migrate();

      });


    }

    public function migrate(){

      column_name1 data_type(size),
 // null ables
      $sql = $this->colummname . " " $this->data_type . '( '. $this->size .' )';
      NOT NULL - Each row must contain a value for that column, null values are not allowed
      DEFAULT value - Set a default value that is added when no other value is passed
      UNSIGNED - Used for number types, limits the stored data to positive numbers and zero
      AUTO INCREMENT - MySQL automatically increases the value of the field by 1 each time a new record is added
      PRIMARY KEY - Used to uniquely identify the rows in a table. The column with PRIMARY KEY setting is often an ID number, and is often used with AUTO_INCREMENT
    }

    public function generate($table, $callback){

      $sql = "CREATE XXX ";

      $sql. = $this->$fieldsSql;

      $sql = "}";

https://dev.mysql.com/doc/refman/5.5/en/data-types.html
    }

    public function id(){



    }


  }


 ?>

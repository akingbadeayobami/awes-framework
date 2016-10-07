<?php
  class Users Extends Migration {

    public $sql = "";

    public $fieldsSql = "";

    protected $nullable = "NOT NULL";

    public __construct(){

        $this->generate('users', function($this){

          $this->id();

          $this->text('email')->()->default('0')->max(32)->unique();

          $this->varchar('fname')->limit(32)->nullable();

          $this->varchar('lname')->limit(32)->default('akingbade');

      });

    }
text COLLATE utf8_unicode_ci
UNIQUE KEY `profiles_phone_number_unique` (`phone_number`)
  `expired` tinyint(1) NOT NULL DEFAULT '0',
    protected $columnName = "";
    protected $dataType = "";
    protected $size = "";
    protected $nullable = "";
    protected $default = "";


    public function migrate(){

      column_name1 data_type(size),
 // null ables
      $sql = $this->colummname . " " $this->data_type . '( '. $this->size .' )' . $this->null . $this->default;
      UNSIGNED - Used for number types, limits the stored data to positive numbers and zero
      AUTO INCREMENT - MySQL automatically increases the value of the field by 1 each time a new record is added
      PRIMARY KEY - Used to uniquely identify the rows in a table. The column with PRIMARY KEY setting is often an ID number, and is often used with AUTO_INCREMENT
    }
// Note text doen not have limit
    CREATE TABLE `paddimi`.`testing` (
    `Awesome` VARCHAR NOT NULL DEFAULT '444'
    , `rock` TEXT NULL ,
    `created_at` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP


    CREATE TABLE IF NOT EXISTS `system_accounts` (
      `game_id` int(11) NOT NULL,
      `amount` varchar(255) NOT NULL,
      `type` varchar(255) NOT NULL,
      `created_at` timestamp NOT NULL,
      `updated_at` timestamp NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;



    public function generate($table, $callback){

      $sql = "DROP TABLE IF EXISTS `" . cg('site.db') . "`.`$table`";
      $sql .= "CREATE TABLE IF NOT EXISTS `$table` (";

      $sql. = $this->$fieldsSql;

      if($this->id){

       $sql .=  ",PRIMARY KEY (`id`)";

      }

      $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";

https://dev.mysql.com/doc/refman/5.5/en/data-types.html
    }

    public function id(){

        $sql. = "`id` INT(11) NOT NULL AUTO_INCREMENT";

    }


  }


 ?>

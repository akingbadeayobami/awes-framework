<?php
$GLOBALS['coreextension'] = array(
    'validation' => [
      'input_fields' => [
          'text' => ".*",
          'number' => "/d",
          'date' => "",
          'url' => "",
          'password' => "",
          'file' => "",
          'email' => "",
          'range' => "",
          'search' => "",
          'time' => "",
          'color' => "",
          'tel' => "",
          'month' => "",
          'datetime' => "",
        ],
      ],
      'route'=>[
        'default' =>[
          'controller' => 'home',
          'method' => 'index'
        ]
      ]
);
?>

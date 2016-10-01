<?php
class Analytics{

	protected $_table = 'analytics';

	public static $_sTable = "analytics";

	protected $_dictionary = array(

		'clp' => 'ClassList Print',

		'mp' => 'Materials Print'

	);

	public function log($activity){

		$person = Session::get('matric') || 'offline';

		$fields = array(

			'person' => Session::get('matric'),

			'activity' => $activity,

			'time' => time(),

		);

		if(!$this->_db->insert($this->_table, $fields)){

			return false;

		}

		return true;

	}


		public static function sLog($activity){ // static

			$person = Session::get('matric') || 'offline';

			$fields = array(

				'person' => Session::get('matric'),

				'activity' => $activity,

				'time' => time(),

			);

			if(!DB::getInstance()->insert(self::$_sTable, $fields)){

				return false;

			}

			return true;

		}

}

?>

<?php
class Filters{

	public static function timeAgo($timeAago){

		$currentTime   = time();

		$timeElapsed   = $currentTime - $timeAago;

		$seconds    = $timeElapsed ;

		$minutes    = round($timeElapsed / 60 );

		$hours      = round($timeElapsed / 3600);

		$days       = round($timeElapsed / 86400 );

		$weeks      = round($timeElapsed / 604800);

		$months     = round($timeElapsed / 2600640 );

		$years      = round($timeElapsed / 31207680 );

		if($seconds <= 60){

			return "just now";

		}

		else if($minutes <=60){

			if($minutes==1){

				return "one minute ago";

			}

			else{

				return "$minutes minutes ago";

			}

		}

		else if($hours <=24){

			if($hours==1){

				return "an hour ago";

			}else{

				return "$hours hrs ago";

			}

		}

		else if($days <= 7){

			if($days==1){

				return "yesterday";

			}else{

				return "$days days ago";

			}

		}

		else if($weeks <= 4.3){

			if($weeks==1){

				return "a week ago";

			}else{

				return "$weeks weeks ago";

			}

		}

		else if($months <=12){

			if($months==1){

				return "a month ago";

			}else{

				return "$months months ago";

			}
		}

		else{

			if($years==1){

				return "a year ago";

			}else{

				return "$years years ago";
			}

		}

	}

	public static function notificationHref($notification) {

		switch ($notification->type){

			case 'timetable' :

				return 'timetable';

			break;

			case 'classthread' :

				return 'classthread';

			break;

			case 'coursethread' :

				return 'coursethread/read/' . $notification->targetID;

			break;

			case 'materials' :

				return 'materials/folder/' . $notification->targetID;

			break;


			case 'message' :

				return 'message/thread/' . $notification->targetID;

			break;


		}

	}

	public static function hisOrHer($sex) {

		switch($sex){

			case 'Male' :

				return 'His';

			break;

			case 'Female' :

				return 'Her';

			break;

			default :

				return 'Their';

			break;

		}

	}

	public static function unReadMessages($messages) {

		$count = 0;

		foreach ($messages as $temp){

			if($temp->opened == 'no' && $temp->receiver == Session::get('matric')){

				$count++;

			}

		}

		return ( $count > 0 ) ? "(" . $count . ")" : "";

	}

	public static function femaleDp($dp,$sex) {

		if ($dp == 'assets/images/avatars/default.png' &&  $sex == 'Female'){

			return 'assets/images/avatars/defaultfemale.png';

		}

		return $dp;

	}

  public static function arrayWhere($array,$type,$equal){

		$return = [];

		foreach($array as $temp){

			if($temp->$type == $equal){

				$return[] = $temp;

			}

		}

		return $return;

	}

}

?>

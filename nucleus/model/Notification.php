<?php
class Notification extends ClassInterface{

	protected $_table = 'notification';

	public function create($message,$target,$type,$course){

		$recepients = false;

		if ($type == 'coursethread' || $type == 'timetable' || $type == 'materials' ){

			$Course = new Course;

			$recepients = $Course->allOfferingCourse($course);

		} else if ($type == 'classthread'){

			$User = new User;

			$recepients = $User->allFromMySet();

		} else if($type == 'message'){

			$recepients = (object)array( (object)array( 'matric' => $target ));

			$target = Session::get('matric');

		}

		if ($recepients == false) {

			return true;

		}

		$toReceivePUSH = [];

		foreach ($recepients as $recepient){

			$receiver = (isset($recepient->student)) ? $recepient->student  : $recepient->matric;

			if($receiver == Session::get('matric')){

				 continue;

			}

			$toReceivePUSH[] = $receiver;

			$fields = array(

				'message' => $message,

				'recepient' => $receiver,

				'targetID' => $target,

				'type' => $type,

				'time' => time()

			 );

			if(!$this->_db->insert($this->_table, $fields)){

				return false;

			}

		}

		$toReceivePUSH = implode(", ", $toReceivePUSH);

		$data = $this->_db->get('profile', 	'pushID',

										'[["matric", "IN", "'.$toReceivePUSH.'"], "AND", ["pushID", "!=", "null"]]');

		if($data->count() > 0){

			$registrationIDs = [];

			foreach($data->results() as $temp){

				$registrationIDs[] = $temp->pushID;

			}

			if(Config::get('site/environment') == 'live') {

				$this->send_push_notification($registrationIDs, $message);

			}

		}

		return true;

	}

	public function clear(){

		$type = Input::get('type');

		$targetID = (Input::get('targetID')) ? Input::get('targetID') : "";

		if($type == 'coursethread' || $type == 'materials' || $type == 'message'){

			$data = $this->_db->get($this->_table, 'id', '[["recepient", "=", "'.Session::get('matric').'"], "AND", ["type", "=", "'.$type.'"], "AND", ["targetID", "=", "'.$targetID.'"]]');

		}else if($type == 'timetable' || $type == 'classthread' ){

			$data = $this->_db->get($this->_table, 'id', '[["recepient", "=", "'.Session::get('matric').'"], "AND", ["type", "=", "'.$type.'"]]');

		}

		foreach($data->results() as $datum){

			if(!$this->_db->delete($this->_table, $datum->id)){

				return false;

			}

		}

		return true;

	}

	public function get(){

		$this->_data = $this->where('recepient',Auth::id())->get();

		return true;

	}

	public function send_push_notification($registrationIDs, $message) {

		 $GOOGLE_API_KEY = "AIzaSyCzr6K_W3ImYwVQ-vQyhFztDSmchkFjeGQ";

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => ['message' => $message, 'title' => Config::get('site/name') ]
        );

        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );




        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
          // log this  die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
      //  echo $result;
    }


}

?>

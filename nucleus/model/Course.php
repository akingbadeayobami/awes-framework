<?php
class Course extends ClassInterface{

	protected $_table = 'studentcourses';

	protected $coursesTable = 'kademiks.courses';

	protected $_validations =

	[

		"add" => [

			'course' => ['name' => 'Course', 'required' => true, 'pattern' => ["%^[A-Za-z]{3}\s[0-9]{3}$%", "Course Seems To Be Invalid"]]

		 ],

		"missing" => [

			'course' => ['name' => 'Course', 'required' => true, 'pattern' => ["%^[A-Za-z]{3}\s[0-9]{3}$%", "Course Seems To Be Invalid"]]

		 ],

		"remove" => [

			'course' => ['name' => 'Course', 'required' => true, 'pattern' => ["%^[A-Za-z]{3}\s[0-9]{3}$%", "Course Seems To Be Invalid"]]

		 ]

	];


	public function add(){

		$course = Input::get('course');

		if(!$this->isCourseValid($course)){

			$this->_message = "Course Seems To Be Invalid";

			return false;

		}


		$data = $this->_db->get($this->_table, '1', '[["student", "=", "' . Session::get('matric') . '"], "AND", ["course", "=", "' . $course . '"]]');

		if($data->count() == 1){

			$this->_message = "Course Has Already Been Added";

			return true;

		}

		$fields = array(

			'student' => Session::get('matric'),

			'course' => $course


		 );

		if(!$this->_db->insert($this->_table, $fields)){

			$this->_message = 'An Error Ocurred while processing your request';

			return false;

		}

		$this->_message = "Course Added Successfully";

		return true;

	}

	public function missing(){

		$course = Input::get('course');

		$course = strtoupper($course);

		$data = $this->_db->get(Config::get('site/db_prefix') . $this->coursesTable, '1', '[["course", "=", "' . $course . '"]]');

		if($data->count() == 1){

			$this->_message = "Course Exists";

			return true;

		}

		$User = new User;

		$fields = array(

			'refid' => $User->getWhatFromMatric('department'),

			'course' => $course,

			'created' => time() ,

			'updated' => time()
			
		 );

		if(!$this->_db->insert(Config::get('site/db_prefix') . $this->coursesTable, $fields)){

			$this->_message = 'An Error Ocurred while processing your request';

			return false;

		}

		$this->_message = "Course Added Successfully";

		return true;

	}

	public function remove(){

		$course = Input::get('course');

		$data = $this->_db->get($this->_table, 'id', '[["student", "=", "'.Session::get('matric').'"], "AND", ["course", "=", "'.$course.'"]]');

		if($data->count() == 1 ){

			$temp = $data->first();

			if(!$this->_db->delete($this->_table, $temp->id)){

				$this->_message = 'An Error Ocurred while processing your request';

				return false;

			}

		}

		$this->_message = 'Course Removed Successfully';

		return true;

	}

	public function all($search=""){

	$search = (Input::get('search')) ? Input::get('search') : "LordPein";

	$limit = 100;

	$data = $this->_db->get(Config::get('site/db_prefix') . $this->coursesTable, 'id,course', '[["course", "LIKE", "%' . $search . '%"], " ORDER BY course LIMIT '.$limit.'"]');

		if(!$data->error()){

			$this->_data = $data->results();

			return true;

		}

		$this->_message = 'An Error Ocurred while processing your request';

		return false;

	}

	public function mates($courseid){

		$courseid = ($courseid) ? $courseid : Input::get('');

		$course = $this->getCourseFromID($courseid);

		if(!$course){

			$this->_message = "Course Seems To Be Invalid";

			return false;

		}

		$courseList = $this->allOfferingCourse($course);

		if(!$courseList){

			$this->_message = "It Seems You Are The Only Person Offering Course";

			return true;

		}

		foreach($courseList as $temp){

			$lists[] = $temp->student;

		}

		$courseList = implode(", ", $lists);

		$data = $this->_db->get('profile', 'lname,fname,matric', '[["matric", "IN", "' . $courseList . '"], "ORDER BY matric ASC" ]');

		if(!$data->error()){

			$this->_data = $data->results();

			return true;

		}

		$this->_message = 'An Error Ocurred while processing your request';

		return false;


	}

	public function allOfferingCourse($course){

		 $data = $this->_db->get($this->_table, 'student', '[["course", "=", "' . $course . '"]]');

		if($data->count() > 0){

			return $data->results();

		}

		return false;

	}

	public function my(){

		$data = $this->_db->get(Config::get('site/db_prefix') . $this->coursesTable . ' JOIN studentcourses ON studentcourses.course = ' . Config::get('site/db_prefix')  . $this->coursesTable . '.course',

										 Config::get('site/db_prefix') . $this->coursesTable . '.id , ' . Config::get('site/db_prefix') . $this->coursesTable . '.course',

										'[["studentcourses.student", "=", "'.Session::get('matric').'"], "ORDER BY ' . Config::get('site/db_prefix') . $this->coursesTable . '.course" ]');

		if(!$data->error()){

			$this->_data = $data->results();

			return true;

		}

		$this->_message = 'An Error Ocurred while processing your request';

		return false;

	}

	public function allFaculties() {

		$data = $this->_db->get('faculties', 'id, faculty', '["id != 1 ORDER BY faculty"]');

		if(!$data->error()){

			$this->_data =  $data->results();

			return true;

		}

		$this->_message = 'An Error Ocurred while processing your request';

		return false;

	}

	public function allDepartments() {

		$id = Input::get('id');

		$data = $this->_db->get('departments', 'id, department', '[["refid", "=", "'.$id.'"], "ORDER BY department"]');

		if(!$data->error()){

			$this->_data =  $data->results();

			return true;

		}

		$this->_message = 'An Error Ocurred while processing your request';

		return false;

	}

	public function getFacultyFromId ($id) {

		$data = $this->_db->get('faculties', 'faculty', '[["id", "=", "' . $id . '"]]');

		if($data->count() == 1){

			return $data->first()->faculty;

		}

		return false;

	}

	public function getDepartmentFromId ($id) {

		$data = $this->_db->get('departments', 'department', '[["id", "=", "' . $id . '"]]');

		if($data->count() == 1){

			return $data->first()->department;

		}

		return false;

	}

	public function getCourseFromID ($id) {

		$data = $this->_db->get(Config::get('site/db_prefix') . $this->coursesTable, 'course', '[["id", "=", "' . $id . '"]]');

		if($data->count() == 1){

			return $data->first()->course;

		}

		return false;

	}

	public function _getCourseFromID ($id) {

		$data = $this->_db->get(Config::get('site/db_prefix') . $this->coursesTable, 'course', '[["id", "=", "' . $id . '"]]');

		if($data->count() == 1){

			$this->_data = $data->first()->course;

			return true;

		}

		return false;

	}

	public function isCourseValid($course) {

		$data = $this->_db->get(Config::get('site/db_prefix') . $this->coursesTable, '1', '[["course", "=", "' . $course . '"]]');

		if($data->count() == 1){

			return true;

		}

		return false;

	}

}

?>

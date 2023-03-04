<?php 
class Register {
	public $id;
	public $student_id;
	public $subject_id;
	public $score;
	public $created_at;
	public $student_name;
	public $subject_name;

	function __construct($id,$student_id, $subject_id, $score, $created_at, $student_name, $subject_name) {
		$this->id = $id;
		$this->student_id = $student_id;
		$this->subject_id = $subject_id;
		$this->score = $score;
		$this->created_at = $created_at;
		$this->student_name = $student_name;
		$this->subject_name = $subject_name;
	}

}

 ?>
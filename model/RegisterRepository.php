<?php 
class RegisterRepository {
	protected $error;
	function fetch($cond = null) {
		global $conn;
		$sql = "SELECT register.*, student.name AS student_name, subject.name AS subject_name FROM register
				JOIN student ON register.student_id = student.id
				JOIN subject ON register.subject_id = subject.id
				";
		if ($cond) {
			$sql .=  " WHERE $cond";
		}
		$result = $conn->query($sql);
		$registers = [];
		while($row = $result->fetch_assoc()) {
			$register = new Register($row["id"], $row["student_id"], $row["subject_id"], $row["score"], $row["created_at"], $row["student_name"], $row["subject_name"]);
			$registers[] = $register;
		}
		return $registers;
	}

	function save($data) {
		global $conn;
		$student_id = $data["student_id"];
		$subject_id = $data["subject_id"];
		$created_at = date("Y-m-d");
		$sql = "INSERT INTO register (student_id, subject_id, created_at) VALUES($student_id, $subject_id, '$created_at')";
		if ($conn->query($sql)) {
			return true;
		}
		$this->error=  "Error: " . $sql . "<br>" . $conn->error;
		return false;
	}

	function getError() {
		return $this->error;
	}

	function find($id) {
		$cond = "register.id=$id";
		$registers = $this->fetch($cond);
		$register = current($registers);
		return $register;
	}

	function update(Register $register) {
		global $conn;
		$score = $register->score;
		$id = $register->id;
		$sql = "UPDATE register SET score=$score WHERE id=$id";
		if ($conn->query($sql)) {
			return true;
		}
		$this->error=  "Error: " . $sql . "<br>" . $conn->error;
		return false;

	}

	function delete($id) {
		global $conn;
		$sql = "DELETE FROM register WHERE id=$id";
		if ($conn->query($sql)) {
			return true;
		}
		$this->error=  "Error: " . $sql . "<br>" . $conn->error;
		return false;
	}

	function getByPattern($search) {
		$cond = "student.name LIKE '%$search%' OR subject.name LIKE '%$search%' OR register.score LIKE '%$search%'";
		$registers = $this->fetch($cond);
		return $registers;
	}

}

 ?>
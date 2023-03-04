<?php 
class StudentRepository {
	protected $error; 
	function fetch($cond = null) {
		global $conn; //  bển trong hàm k nhìn thấy bên ngoài hàm nhìn thấy bằng cách global;
		$sql = "SELECT * FROM student";
		if ($cond) {
			$sql .=  " WHERE $cond";
		}
		$result = $conn->query($sql);
		$students = [];
		while($row = $result->fetch_assoc()) {
			$student = new Student($row["id"], $row["name"], $row["birthday"], $row["gender"]);
			$students[] = $student;
		}
		return $students;
	}

	function save($data) {
		global $conn;
		$name = $data["name"];
		$birthday = $data["birthday"];
		$gender = $data["gender"];
		if (!empty($data["id"])) {
			$id = $data["id"];
			$sql = "INSERT INTO student (id, name, birthday, gender) VALUES($id, '$name', '$birthday', $gender)";
		}
		else {
			$sql = "INSERT INTO student (name, birthday, gender) VALUES('$name', '$birthday', $gender)";
		}
		
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
		$cond = "id=$id";
		$students = $this->fetch($cond);
		$student = current($students); // current lấy 1 đối tượng
		return $student;
	}

	function update(Student $student) {
		global $conn;
		$name = $student->name;
		$birthday = $student->birthday;
		$gender = $student->gender;
		$id = $student->id;
		$sql = "UPDATE student SET name='$name', birthday='$birthday', gender=$gender WHERE id=$id";
		if ($conn->query($sql)) {
			return true;
		}
		$this->error=  "Error: " . $sql . "<br>" . $conn->error;
		return false;

	}

	function delete($id) {
		global $conn;
		$sql = "DELETE FROM student WHERE id=$id";
		if ($conn->query($sql)) {
			return true;
		}
		$this->error=  "Error: " . $sql . "<br>" . $conn->error;
		return false;
	}

	function getByPattern($search) {
		$cond = "name LIKE '%$search%'";
		$students = $this->fetch($cond);
		return $students;
	}

}

 ?>
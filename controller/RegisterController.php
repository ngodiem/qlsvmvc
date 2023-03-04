<?php 
class RegisterController {
	function export() {

	}
	
	function list() {
		$registerRepository = new RegisterRepository();
		
		$search = !empty($_GET["search"]) ? $_GET["search"] : "";
		if (!empty($search)) {
			$registers = $registerRepository->getByPattern($search);
		}
		else {
			$registers = $registerRepository->fetch();
		}
		require "view/register/list.php";
	}

	function add() {
		$studentRepository = new StudentRepository();
		$students = $studentRepository->fetch();

		$subjectRepository = new SubjectRepository();
		$subjects = $subjectRepository->fetch();
		require "view/register/add.php";
	}

	function save() {
		$registerRepository = new RegisterRepository();
		$data = [];
		$data["student_id"] = $_POST["student_id"];
		$data["subject_id"] = $_POST["subject_id"];
		if($registerRepository->save($data)) {
			$_SESSION["success"] = "Đã tạo đăng ký môn học thành công";
		}
		else {
			$_SESSION["error"] = $registerRepository->getError();
		}
		header("location: index.php?c=register");
	}

	function edit() {
		$id = $_GET["id"];
		$registerRepository = new RegisterRepository();
		$register = $registerRepository->find($id);
		require "view/register/edit.php";
	}

	function update() {
		$id = $_POST["id"];
		$score = $_POST["score"];
		
		$registerRepository = new RegisterRepository();
		$register = $registerRepository->find($id);
		$register->score = $score;
		
		if($registerRepository->update($register)) {
			$_SESSION["success"] = "Sinh viên {$register->student_name} học môn {$register->subject_name} được $score điểm";
		}
		else {
			$_SESSION["error"] = $registerRepository->getError();
		}
		header("location: index.php?c=register");
	}

	function delete() {
		$id = $_GET["id"];
		$registerRepository = new RegisterRepository();
		if($registerRepository->delete($id)) {
			$_SESSION["success"] = "Đã xóa đăng ký môn học thành công";
		}
		else {
			$_SESSION["error"] = $registerRepository->getError();
		}
		header("location: index.php?c=register");
	}
}

 ?>
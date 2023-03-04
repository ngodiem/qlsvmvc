<?php 
class SubjectController {
	function export() {

	}
	function list() {
		$subjectRepository = new SubjectRepository();
		
		$search = !empty($_GET["search"]) ? $_GET["search"] : "";
		if (!empty($search)) {
			$subjects = $subjectRepository->getByPattern($search);
		}
		else {
			$subjects = $subjectRepository->fetch();
		}
		require "view/subject/list.php";
	}

	function add() {
		require "view/subject/add.php";
	}

	function save() {
		$subjectRepository = new SubjectRepository();
		$data = [];
		$data["name"] = $_POST["name"];
		$data["number_of_credit"] = $_POST["number_of_credit"];
		if($subjectRepository->save($data)) {
			$_SESSION["success"] = "Đã tạo môn học thành công";
		}
		else {
			$_SESSION["error"] = $subjectRepository->getError();
		}
		header("location: index.php?c=subject");
	}

	function edit() {
		$id = $_GET["id"];
		$subjectRepository = new SubjectRepository();
		$subject = $subjectRepository->find($id);
		require "view/subject/edit.php";
	}

	function update() {
		$id = $_POST["id"];
		$name = $_POST["name"];
		$number_of_credit = $_POST["number_of_credit"];
		
		$subjectRepository = new SubjectRepository();
		$subject = $subjectRepository->find($id);
		$subject->name = $name;
		$subject->number_of_credit = $number_of_credit;
		
		if($subjectRepository->update($subject)) {
			$_SESSION["success"] = "Đã cập nhật môn học $name thành công";
		}
		else {
			$_SESSION["error"] = $subjectRepository->getError();
		}
		header("location: index.php?c=subject");
	}

	function delete() {
		$id = $_GET["id"];
		$subjectRepository = new SubjectRepository();
		if($subjectRepository->delete($id)) {
			$_SESSION["success"] = "Đã xóa môn học thành công";
		}
		else {
			$_SESSION["error"] = $subjectRepository->getError();
		}
		header("location: index.php?c=subject");
	}
}

 ?>
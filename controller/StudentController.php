<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController {

	function import() {
		$inputFileName = $_FILES["excel"]["tmp_name"];
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
		$sheet = $spreadsheet->getActiveSheet();
		$begin = 2;
		$end = $sheet->getHighestRow();
		$studentRepository = new StudentRepository();
		for ($row = $begin; $row <= $end; $row++) {
			$id = $sheet->getCell("A$row")->getValue();
			$name = $sheet->getCell("B$row")->getValue();
			$birthday = $sheet->getCell("C$row")->getValue();
			$gender = $sheet->getCell("D$row")->getValue();

			$student = $studentRepository->find($id);
			$mapGender = ["nam" => 0, "nữ" => 1, "khác" => 2];
			if (empty($student)):
			//insert: nếu sinh viên chưa tồn tại
				$data = [
					"id" => $id,
					"name" => $name,
					"birthday" => $birthday,
					"gender" => $mapGender[$gender]
				];
				if (!$studentRepository->save($data)):
					$_SESSION["error"] = $studentRepository->getError();
					break;//thoát khỏi for
				endif;
				

			else: 
			//update: nếu sinh viên đã tồn tại
				$student->name = $name;
				$student->birthday = $birthday;
				$student->gender = $mapGender[$gender];
				if (!$studentRepository->update($student)):
					$_SESSION["error"] = $studentRepository->getError();
					break;//thoát khỏi for
				endif;
			endif;
			}
	header("location: index.php");
		}

	function formImport() {
		require "view/student/formUpload.php";
	}

	function export() {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$studentRepository = new StudentRepository();
		$students = $studentRepository->fetch();
		//dòng tiêu đề
		$sheet->setCellValue("A1", "Mã SV");
		$sheet->setCellValue("B1", "Tên");
		$sheet->setCellValue("C1", "Ngày Sinh");
		$sheet->setCellValue("D1", "Giới tính");

		$row = 1;
		foreach ($students as $student):
			$row++;
			$sheet->setCellValue("A$row", $student->id);
			$sheet->setCellValue("B$row", $student->name);
			$sheet->setCellValue("C$row", $student->birthday);
			$sheet->setCellValue("D$row", $student->getGenderName());
		endforeach;
		// Format (background/color) cho cells
		$styleArray = [                       
				'font' => [
					'color' => ['argb' => 'FFFFFFFF'],
				],
				'fill' => [
			        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			        'startColor' => [
			            'argb' => 'FF375623',
			        ]
			    ]
			];
		$sheet->getStyle('A1:D1')->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet); //Tạo khung excel và gắn spreadsheet vào
		//Hiển thị form download và đẩy dữ liệu về file khi người dùng download
		$fileName = "ExportListStudent.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
		$writer->save("php://output");
	}
	function list() {
		$studentRepository = new StudentRepository();
		
		$search = !empty($_GET["search"]) ? $_GET["search"] : "";
		if (!empty($search)) {
			$students = $studentRepository->getByPattern($search);
		}
		else {
			$students = $studentRepository->fetch();
		}
		require "view/student/list.php";
	}

	function add() {
		require "view/student/add.php";
	}

	function save() {
		$studentRepository = new StudentRepository();
		$data = [];
		$data["name"] = $_POST["name"];
		$data["birthday"] = $_POST["birthday"];
		$data["gender"] = $_POST["gender"];
		if($studentRepository->save($data)) { 
			$_SESSION["success"] = "Đã tạo sinh viên thành công";
		}
		else {
			$_SESSION["error"] = $studentRepository->getError();
		}
		header("location: index.php");
	}

	function edit() {
		$id = $_GET["id"];
		$studentRepository = new StudentRepository();
		$student = $studentRepository->find($id);
		require "view/student/edit.php";
	}

	function update() {
		$id = $_POST["id"];
		$name = $_POST["name"];
		$birthday = $_POST["birthday"];
		$gender = $_POST["gender"];
		$studentRepository = new StudentRepository();
		$student = $studentRepository->find($id);
		$student->name = $name;
		$student->birthday = $birthday;
		$student->gender = $gender;
		if($studentRepository->update($student)) {
			$_SESSION["success"] = "Đã cập nhật sinh viên $name thành công";
		}
		else {
			$_SESSION["error"] = $studentRepository->getError();
		}
		header("location: index.php");
	}

	function delete() {
		$id = $_GET["id"];
		$studentRepository = new StudentRepository();
		if($studentRepository->delete($id)) {
			$_SESSION["success"] = "Đã xóa sinh viên thành công";
		}
		else {
			$_SESSION["error"] = $studentRepository->getError();
		}
		header("location: index.php");
	}
}

 ?>
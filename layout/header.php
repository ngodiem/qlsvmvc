<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Quản lý sinh viên</title>
		<link rel="stylesheet" href="public/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="public/vendor/fontawesome-free-5.15.1-web/css/all.min.css">
		<link rel="stylesheet" href="public/css/style.css">
	</head>
	<body>
		<div class="container" style="margin-top:20px;">
			<?php global $c; ?>
			<a href="index.php" class="<?=$c=="student" ? "active": ""?> btn btn-info">Students</a>
			<a href="index.php?c=subject" class="<?=$c=="subject" ? "active": ""?> btn btn-info">Subject</a>
			<a href="index.php?c=register" class="<?=$c=="register" ? "active": ""?> btn btn-info">Register</a>
			<div style="height:40px; margin-top:20px">
				<?php 
				$message = "";
				$classMessage = "";
				if (!empty($_SESSION["error"])) {
					$message = $_SESSION["error"];
					unset($_SESSION["error"]);
					$classMessage = "alert-danger";
				
				}
				elseif(!empty($_SESSION["success"])) {
				 	$message = $_SESSION["success"];
				 	unset($_SESSION["success"]);
				 	$classMessage = "alert-success";
				}

				?>
				<div class="alert <?=$classMessage?> container-fluid text-center">
					<?=$message?>
				</div>
			</div>
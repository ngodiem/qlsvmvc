<?php 
session_start();
$c = !empty($_GET["c"]) ? $_GET["c"]: "student";
$a = !empty($_GET["a"]) ? $_GET["a"]: "list";
require "config.php";
require "connectDb.php";
require "model/StudentRepository.php";
require "model/Student.php";

require "model/SubjectRepository.php";
require "model/Subject.php";

require "model/RegisterRepository.php";
require "model/Register.php";

require "service/Helper.php";

require "vendor/autoload.php";

$controller = ucfirst($c) . "Controller";//StudentController
require "controller/$controller" . ".php";
$controller = new $controller();//new StudentController()
$controller->$a();

 ?>
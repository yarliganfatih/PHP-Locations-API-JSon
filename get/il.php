<?php
//Display Error
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
header('Content-Type: text/html; charset=utf-8');
include "../db.php";
include "../function.php";

$jsonArray = array();
$jsonArray["Error"] = FALSE;

$_code = 200;

$q = $db->query("SET NAMES UTF8");

if($_SERVER['REQUEST_METHOD'] == "GET") {
    $sentdata = json_decode(file_get_contents("php://input"));

    if(isset($_GET["id"])){
		$query = "select * from il where id='".$_GET["id"]."'";
	}else if(isset($_GET["il"])){
		$query = "select * from il where IL_ADI_BUYUK='".strtoupper($_GET["il"])."'";
	}else if(isset($_GET["plaka"])) {
		$query = "select * from il where PLAKA='".$_GET["plaka"]."'";
	}else{
		$query = "select * from il";
	}
	
	if($_code!=404){
		$isThere = $db->query($query)->num_rows;
		if($isThere) {
			$bilgiler = $db->query($query)->fetch_assoc();
			$jsonArray["Data"] = $bilgiler;
			$_code = 200;
			
		}else {
			$_code = 400;
			$jsonArray["Error"] = TRUE;
    		$jsonArray["ErrorMsg"] = "Veri bulunamadı.";
		}
	}
}else {
	$_code = 406;
	$jsonArray["Error"] = TRUE;
 	$jsonArray["ErrorMsg"] = "Geçersiz method!";
}


SetHeader($_code);
$jsonArray[$_code] = HttpStatus($_code);
echo json_encode($jsonArray);
?>
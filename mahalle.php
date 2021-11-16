<?php
//Display Error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
include "db.php";
include "function.php";

$jsonArray = array();
$jsonArray["Error"] = FALSE;

$_code = 200;

$q = $db->query("SET NAMES UTF8");

if($_SERVER['REQUEST_METHOD'] == "GET") {
    $sentdata = json_decode(file_get_contents("php://input"));

    if(isset($_GET["id"])){
		$query = "select * from mahalle_koy where id='".$_GET["id"]."'";
	}else if(isset($_GET["semt"])){
		$query = "select * from mahalle_koy where SEMT_ADI_BUYUK='".strtoupper($_GET["semt"])."'";
	}else if(isset($_GET["semt"])){
		$bilgiler = $db->query("select * from semt where SEMT_ADI_BUYUK='".strtoupper($_GET["semt"])."'")->fetch_assoc();
		$query = "select * from mahalle_koy where SEMT_ID='".$bilgiler["SEMT_ID"]."'";
	}else if(isset($_GET["ilce"])){
		$bilgiler = $db->query("select * from ilce where ILCE_ADI_BUYUK='".strtoupper($_GET["ilce"])."'")->fetch_assoc();
		$query = "select * from mahalle_koy where ILCE_ID='".$bilgiler["ILCE_ID"]."'";
	}else if(isset($_GET["il"])){
		$bilgiler = $db->query("select * from il where IL_ADI_BUYUK='".strtoupper($_GET["il"])."'")->fetch_assoc();
		$query = "select * from mahalle_koy where IL_ID='".$bilgiler["IL_ID"]."'";
	}else if(isset($_GET["plaka"])) {
		$query = "select * from mahalle_koy where IL_ID='".$_GET["plaka"]."'";
	}else{
		$query = "select * from mahalle_koy";
	}
	
	if($_code!=404){
		$isThere = $db->query($query)->num_rows;
		if($isThere) {
			$Arr = array();
			$bilgiler = $db->query($query);
			while ($row = mysqli_fetch_object($bilgiler)){
				array_push($Arr, $row);
			}
			$jsonArray["Data"] = $Arr;
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
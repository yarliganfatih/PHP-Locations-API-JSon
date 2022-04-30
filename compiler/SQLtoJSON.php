<?php
    //Display Error
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: text/html; charset=utf-8');
    include "../db.php";
    include "../function.php";
    
    $get = array();
    $get2 = array();
    $get3 = array();

    $q = $db->query("SET NAMES UTF8");

    $query1 = "SELECT IL_ID, IL_ADI FROM locations_city";
    $data1 = $db->query($query1);
    $Arr1 = array();
    while ($row1 = mysqli_fetch_object($data1)){
        $query2 = "SELECT ILCE_ID, ILCE_ADI FROM locations_town WHERE IL_ID = ".$row1->IL_ID;
        $data2 = $db->query($query2);
        $Arr2 = array();
        while ($row2 = mysqli_fetch_object($data2)){
            $query3 = "SELECT SEMT_ID, SEMT_ADI FROM locations_district WHERE ILCE_ID = ".$row2->ILCE_ID;
            $data3 = $db->query($query3);
            $Arr3 = array();
            while ($row3 = mysqli_fetch_object($data3)){
                // Mahalleleri Ekle
                /* 
                    $query4 = "SELECT MAH_ID, MAHALLE_ADI FROM locations_neighbourhood WHERE SEMT_ID = ".$row3->SEMT_ID;
                    $data4 = $db->query($query4);
                    $Arr4 = array();
                    while ($row4 = mysqli_fetch_object($data4)){
                        array_push($Arr4, $row4);
                    }
                    $row3->MAHALLE = $Arr4;
                */
                array_push($Arr3, $row3);
            }
            $row2->SEMT = $Arr3;
            array_push($Arr2, $row2);
        }
        $row1->ILCE = $Arr2;
        array_push($Arr1, $row1);
    }
    
    echo json_encode($Arr1, \JSON_UNESCAPED_UNICODE);
?>
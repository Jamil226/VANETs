<?php
include("lib/DatabaseHelper.php");
 if ($_SERVER['REQUEST_METHOD'] == 'GET')
 {
    $RegisterationNumber = mysqli_real_escape_string($conn,$_GET['number']);
    $NC = (int) filter_var($RegisterationNumber, FILTER_SANITIZE_NUMBER_INT);  
    $OnBoardEmail = mysqli_real_escape_string($conn,$_GET['email']);
    $OnBoardPassword = mysqli_real_escape_string($conn,$_GET['password']);
    $OnBoardSecuredPassword = md5($OnBoardPassword);
    $SessionKey = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!*()$";
    $SessionKey = str_shuffle($SessionKey);
    $SessionKey = substr($SessionKey, 0, 10);
    $SqlCommand = "SELECT MAX(vehicle_id) FROM account_vehicles";
	$Result = mysqli_query($conn,$SqlCommand);
	$MaxID = mysqli_fetch_array($Result);
	$VehicleID = $MaxID['0'];
	$VehicleID = $VehicleID + 1;
	$TodayDate = date("Ymd");
	$Reference =  $TodayDate."_".str_pad($VehicleID,6,"0",STR_PAD_LEFT);
	$UpdatedCodeVehicle = $VehicleID . $NC;
	$UpdatedCodeServer = $UpdatedCodeVehicle . rand();
	$ShuffledCodeServer = str_shuffle($UpdatedCodeServer);
	$VehicleAuthCode = substr($ShuffledCodeServer, 0, 6);
	$DateTime = date("d-m-Y h:i:s");
	$LoginMethod = 1;
    $Query = "INSERT INTO account_vehicles (vehicle_id , reference_code, vehicle_registeration_number, ". 
    "vehicle_nc, onboard_email, onboard_password, update_code_i , updated_code_s , svc_s, vca_s, ".
    "vehicle_token, vehicle_registered_on) VALUES ($VehicleID, '$Reference', '$RegisterationNumber', ".
    "'$NC', '$OnBoardEmail', '$OnBoardSecuredPassword', '$UpdatedCodeVehicle','$UpdatedCodeServer', ".
    "'$ShuffledCodeServer', '$VehicleAuthCode', '$SessionKey', '$DateTime')";
 	if (mysqli_query($conn, $Query)) {
        $Query2 = "INSERT INTO vehicle_logs (vehicle_id, reference, login_date, login_method)
        VALUES ($VehicleID, '$Reference','$DateTime', $LoginMethod)";
		mysqli_query($conn,$Query2);
        $result["status"] = "1";
        $result["message"] = "success";
        echo json_encode($result);
    } else {
        $result["status"] = "0";
        $result["message"] = "error";
        echo json_encode($result);
    }
 }
?>
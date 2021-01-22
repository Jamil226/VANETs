<?php
    include("lib/DatabaseHelper.php");
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $VCA = mysqli_real_escape_string($conn,$_GET['vca']);
        $Query = "SELECT * FROM account_vehicles WHERE vca_s = '$VCA'";
        $Result = mysqli_query($conn, $Query);
    if ( mysqli_num_rows($Result) > 0 ) 
        {
            $mem = mysqli_fetch_object($Result);
            $_SESSION['VehicleID'] = $mem->vehicle_id;
            $_SESSION['Reference'] = $mem->reference_code;
            $DateTime = date("d-m-Y h:i:s");
            $LoginMethod = 0;
            $Query2 = "INSERT INTO vehicle_logs (vehicle_id, reference, login_date, login_method)
            VALUES (". $mem->vehicle_id.", '". $mem->reference_code."','$DateTime', $LoginMethod)";
            mysqli_query($conn,$Query2);
            $result["status"] = "1";
            $result["message"] = "success";
            echo json_encode($result);
        }
    else 
        {
            $result['status'] = "0";
            $result['message'] = "error";
            echo json_encode($result);
        }
    }
?>
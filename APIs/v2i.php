<?php
    include("lib/DatabaseHelper.php");
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $SenderID = mysqli_real_escape_string($conn,$_GET['sender_id']);
        $MessageContent = mysqli_real_escape_string($conn,$_GET['content']);
        $MessagePriority = mysqli_real_escape_string($conn,$_GET['message_priority']);
        $MessageStatus = mysqli_real_escape_string($conn,$_GET['message_status']);
        $Latitude = mysqli_real_escape_string($conn,$_GET['latitude']);
        $Longitude = mysqli_real_escape_string($conn,$_GET['longitude']);
        $Location = mysqli_real_escape_string($conn,$_GET['location']);
        $SqlCommand = "SELECT MAX(message_id) FROM v2i_messages";
        $Result = mysqli_query($conn,$SqlCommand);
        $MaxMessageID = mysqli_fetch_array($Result);
        $MaxMessageID = $MaxMessageID['0'];
        $MessageID = $MaxMessageID + 1;
        $TodayDate = date("Ymd");
        $Reference =  $TodayDate."_".str_pad($MessageID,6,"0",STR_PAD_LEFT);
        $DateTime = date("d-m-Y h:i:s");
        $Query = "INSERT INTO v2i_messages (message_id , reference, ". 
        "sender_id, content, message_priority, message_date_time , message_status, ".
        "latitude, longitude, location) ".
        "VALUES ($MessageID, '$Reference', ".
        "'$SenderID', '$MessageContent', '$MessagePriority',".
        "'$DateTime','$MessageStatus', '$Latitude', ".
        "'$Longitude', '$Location')";
        if (mysqli_query($conn, $Query)) 
        {
            $result["status"] = "1";
            $result["message"] = "success";
            echo json_encode($result);
        } else
        {
            $result["status"] = "0";
            $result["message"] = "error";
            echo json_encode($result);
        }
    }
?>
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-Type:application/json");

include 'database.php';
include 'chatbot.php';

//global
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'shu_chatbot';
// 
// $dbhost = 'localhost';
// $dbuser = 'kodevg';
// $dbpass = "hihpxqhUMxS.";
// $dbname = 'kodevg_new_chat_bot';

$db = new Database($dbhost, $dbuser, $dbpass, $dbname);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$chatbot = new ChatbotHelper();


if(isset($_POST["sendmsg"])!="" && $_POST["table"]=="sendmsg"){
    $r_id = $_POST["ra_id"];
    $u_id = $_SESSION['u_id'];
    $request_data = $db->query("SELECT * FROM `req_to_agent` where `ra_id` = '{$r_id}'")->fetchArray();
    $sender = $request_data["phone_no"];
    $reply = $_POST["sendmsg"];

    if($request_data["mode"] == 1){
        // Direct message logic yahan likhiye
        // Example: Send email, SMS, or another type of direct message
        send_direct_message($sender, $reply);

        $insert_d = "INSERT INTO d_agent set `ra_id`='{$r_id}', `u_id`='{$u_id}', `msgs`='{$reply}'";
        $result_accinfo_sql = mysqli_query($conn, $insert_d);
    } else {
        unset($_SESSION['request_id']); 
    }
}

// Custom function to send direct message
function send_direct_message($recipient, $message) {
    // Yahan apna custom direct message logic implement karen
    // Example: Email sending
    mail($recipient, "New Message", $message);

}


if(isset($_POST['cra_id']) && $_POST['table'] == "close_chat"){
    $r_id = $_POST['cra_id'];
    $update1 = "UPDATE `req_to_agent` SET `mode`='2' WHERE `ra_id`='{$r_id}'";
    $result = mysqli_query($conn, $update1);

    $query = "SELECT * FROM req_to_agent WHERE `ra_id`='{$r_id}'";
    $result = mysqli_query($conn, $query);
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $sender = $row["phone_no"];
        $update2 = "UPDATE `testtbl` SET `agent_mod`='0' WHERE `id`='{$row['t_id']}'";
        $result = mysqli_query($conn, $update2);

        $reply = "Agent has closed the chat!";
        // Direct message logic yahan likhiye
        close_direct_message($sender, $reply);
    }

    unset($_SESSION['request_id']);
    echo json_encode(array('status' => 200, 'message' => "Close successfully"));

    // echo "Close successfully";
}

// Custom function to send direct message
function close_direct_message($recipient, $message) {
    // Yahan apna custom direct message logic implement karen
    // Example: Email sending
    mail($recipient, "Chat Closed", $message);

    // Example: SMS sending (Twilio ya kisi aur service ka use kar sakte hain)
    // send_sms($recipient, $message);

    // Example: Push notification
    // send_push_notification($recipient, $message);
}
echo json_encode(array('status' => 200, 'info' => 'OK'));


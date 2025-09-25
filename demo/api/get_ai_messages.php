<?php
// include("db_connection.php");
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type, Authorization');
session_start();
// include('../config/db.php'); // Make sure your database connection is included
// Database connection details
// $servername = "localhost";
// $username = "zbhqiadh_saudipak_chat";
// $password = "!@#$chatbot1234";
// $dbname = "zbhqiadh_saudipak_chatbot";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shu_chatbot";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    fetchAIMessages();
}

function fetchAIMessages() {
    global $conn;
    $rai_id = $_SESSION['rai_id'];
    $sql = "SELECT * FROM ai_agent WHERE rai_id ='{$rai_id}' ORDER BY datetime";
    
    $result = $conn->query($sql);
    $messages = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["mode"] > 0) {
            $messages[] = [
                'message' => $row['msgs'],
                'sender' => 'agent', // Assuming these are agent messages
                'timestamp' => $row['datetime']
            ];
        }
    }
    
    echo json_encode(['messages' => $messages]);
}
?>

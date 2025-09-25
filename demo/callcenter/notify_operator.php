<?php
include_once 'bad_word.php';

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

// $log_file = '/path_to_your_log_file/log.txt';
// file_put_contents($log_file, date('Y-m-d H:i:s') . " - Notify Operator Reached\n", FILE_APPEND);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shu_chatbot";

$conn=mysqli_connect($servername,$username,$password,$dbname);

// Check connection
if (!$conn) {
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Connection failed: " . mysqli_connect_error() . "\n", FILE_APPEND);
    die(json_encode(array("status" => "error", "message" => "Connection failed: " . mysqli_connect_error())));
}
// file_put_contents($log_file, date('Y-m-d H:i:s') . " - Connected successfully\n", FILE_APPEND);

// Test response
// echo json_encode(array("status" => "success", "message" => "Connected successfully"));


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: application/json');

// Get the user input
$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'];

// Initialize session for conversation
// session_start();
session_start([
    'cookie_samesite' => 'None',
    'cookie_secure' => true,  // Make sure you're using HTTPS
]);
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// if (isset($input['auto_start']) && $input['auto_start'] === true) {
//     $_SESSION['stage'] = 'welcome'; // force welcome
// }
// if (isset($input['auto_start']) && $input['auto_start'] === true) {
//     $_SESSION['stage'] = 'awaiting_email_phone';
// }
// Check if the stage is set in the session
if (!isset($_SESSION['stage'])) {
    $_SESSION['stage'] = 'awaiting_email_phone';
}

// if (isset($_POST['conversation_id'])) {
//     $conversation_id = $_POST['conversation_id'];
//     $agentResponse = fetchAgentResponse($conversation_id, $conn);
//     if ($agentResponse) {
//         echo json_encode([$agentResponse]);
//     } else {
//         echo json_encode([]); 
//     }
//     exit;
// }


$stage = $_SESSION['stage'];
$conversation_id = isset($_SESSION['conversation_id']) ? $_SESSION['conversation_id'] : null;

$response = []; // Initialize an empty response array to handle multiple messages



switch ($stage) {
    case 'welcome':
        $response = ["Welcome to Salim Habib University!","Please provide your cell number so I can look up your account."];
        $_SESSION['stage'] = 'awaiting_email_phone';
        break;

    case 'awaiting_email_phone':
        $identifier = $message;

        if (isValidEmail($identifier) || isValidPhone($identifier)) {
            $customer = getCustomerByIdentifier($identifier, $conn);

            if ($customer) {
                $response = ["Welcome back, " . $customer['name'] . "! How can I assist you today?"];
                $conversation_id = startConversation($customer['name'], $identifier, $conn);
                $_SESSION['conversation_id'] = $conversation_id;
                 $faqResponse = getResponseFromFAQ('#', $conn);
            if (!empty($faqResponse)) {
                $response[] = $faqResponse[0];  // Add the fetched response to the welcome message
            }
                $_SESSION['stage'] = 'faq_query';
            } else {
                $_SESSION['identifier'] = $identifier;
                if (isValidEmail($identifier)) {
                    $response = ["We don't have your record. Please provide your phone number."];
                    $_SESSION['stage'] = 'awaiting_phone';
                } else {
                    $response = ["I'm sorry, I couldn't find any records with that number.","Could you please provide your Name, Address, and Email so I can assist you better?","Please provide your Email address."];
                    $_SESSION['stage'] = 'awaiting_email';
                }
            }
        } else {
            $response = ["Invalid phone number. Please provide a valid phone number."];
        }
        break;

    case 'awaiting_phone':
        $phone = $message;
        if (isValidPhone($phone)) {
            $_SESSION['phone'] = $phone;
            $response = ["Thank you! "," Please provide your Email"];
            $_SESSION['stage'] = 'awaiting_email';
        } else {
            $response = ["Invalid phone number. Please provide a valid phone number."];
        }
        break;

    case 'awaiting_email':
        $email = $message;
        if (isValidEmail($email)) {
            $_SESSION['email'] = $email;
            $response = ["Thank you! "," Please provide your address."];
            $_SESSION['stage'] = 'awaiting_address';
        } else {
            $response = ["Invalid email address. Please provide a valid email address."];
        }
        break;

    case 'awaiting_address':
        $address = $message;
        $_SESSION['address'] = $address;
        $response = ["Thank you! "," Please provide your name."];
        $_SESSION['stage'] = 'awaiting_name';
        break;

    case 'awaiting_name':
        $name = $message;
        $identifier = $_SESSION['identifier'];
        if (isValidEmail($identifier)) {
            $email = $identifier;
            $phone = $_SESSION['phone'];
            $address = $_SESSION['address'];
        } else {
            $phone = $identifier;
            $email = $_SESSION['email'];
            $address = $_SESSION['address'];
        }
        addCustomer($phone, $email, $address, $name, $conn);
        $conversation_id = startConversation($name, $identifier, $conn);
        $_SESSION['conversation_id'] = $conversation_id;
        $response = ["Thank you for providing your information. How can I assist you today?"];
         $faqResponse = getResponseFromFAQ('#', $conn);
            if (!empty($faqResponse)) {
                $response[] = $faqResponse[0];  // Add the fetched response to the welcome message
            }
        $_SESSION['stage'] = 'faq_query';
        break;

    case 'faq_query':
        saveMessage($conversation_id, $message, 'user', $conn);
        $response = getResponseFromFAQ($message, $conn);
        
        
            if(strtolower($message) == '9') {
                Requesttoai($conversation_id, $message, $conn);
                $response = ["your are now connected with AI Agent Press * to exit AI Agent mode"];
                $_SESSION['stage'] = 'AIAgent_connected';
                saveMessage($conversation_id, $response[0], 'bot', $conn);
            }
            elseif (strtolower($message) == '0') {
                notifyCallCenter($conversation_id, $message, $conn);
                $response = ["you are now connected to agent please waiting for agent reply","Press @ to exit agent mode"];
                $_SESSION['stage'] = 'agent_connected';
                saveMessage($conversation_id, $response[0], 'bot', $conn);
            }   
            else {
                if(strtolower($message) != '#')
                {
                    // $response = ["Press any key to continue."];
                    $response = !empty($response) 
                    ? [$response[0], "Press # for the menu or choose another number to continue."] 
                    : ["No suitable answer found. Please select a valid option","Press # to return to the menu"];
                }
                elseif(!empty($response)) {
                 // Add the fetched response to the welcome message
                 saveMessage($conversation_id, $response[0], 'bot', $conn);
                //  $_SESSION['stage'] = 'complain';
                }
                else {
                    $response = ["No suitable answer found. Please select a valid option","Press # to return to the menu"];
                }
                saveMessage($conversation_id, $response[0], 'bot', $conn);
                // saveMessage($conversation_id, $response[0], 'bot', $conn);
                foreach ($response as $msg) {
                    saveMessage($conversation_id, $msg, 'bot', $conn);
                }
            }
        break;

    // case 'confirm_agent':
    //     if (strtolower($message) == 'yes' || strtolower($message) == 'y') {
    //         $response = ["you are now connected to agent please waiting for agent reply","Press @ to exit agent mode"];
    //         $_SESSION['stage'] = 'agent_connected';
    //     } elseif (strtolower($message) == 'no' || strtolower($message) == 'n') {
    //         $response = ["Okay. If you need further assistance, please let me know."];
    //         $_SESSION['stage'] = 'faq_query';
    //     } else {
    //         $response = ["Please reply with 'yes' or 'no'."];
    //     }
    //     break;

    case 'agent_connected':
        if ($message == '@') {
            $response = ["You have exited agent mode. You are now back in chatbot mode."];
            $_SESSION['stage'] = 'faq_query';
        } else {
            forwardToAgent($conversation_id, $message, $conn);
            $response = checkForAgentResponse($conversation_id, $conn);
        }
        break;
        case 'AIAgent_connected':
                if ($message == '*') {
                    $response = ["You have exited AI Agent mode. You are now back in chatbot mode."];
                    $_SESSION['stage'] = 'faq_query';
                } else {
                    forwardToAIAgent($conversation_id, $message, $conn);
                    $response = checkForAIAgentResponse($conversation_id, $conn);
                }
            break;
}

// if ($_SESSION['stage'] === 'awaiting_name' && isset($name)) {
//     $response = ["Thank you for providing your information, $name."];
//     $_SESSION['stage'] = 'completed';
// }
// }
// Return response
// Debugging output
error_log("Current stage: " . $_SESSION['stage']);
error_log("Response: " . print_r($response, true));


echo json_encode(['answer' => $response]);

// Functions

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidPhone($phone) {
    return preg_match('/^\d{10,15}$/', $phone);
}
function isValidYesNoResponse($agent_c) {
    $validResponses = ["yes", "no"];
    return in_array(strtolower($agent_c), $validResponses);
}

if ($_SESSION['stage'] === 'awaiting_name' && isset($name)) {
    $response = ["Thank you for providing your information, $name."];
    $_SESSION['stage'] = 'completed';
}


function forwardToAgent($conversation_id, $message, $conn) {
    $ra_id = $_SESSION['ra_id'];
    
    $sql = "INSERT INTO d_agent (ra_id, datetime, msgs, reply_id, u_id) 
            VALUES ('{$ra_id}', NOW(), '{$message}', '0', NULL)";
    if (!$conn->query($sql)) {
        die("Error forwarding message to agent: " . $conn->error);
    }
    // $sql = "INSERT INTO d_agent (conversation_id, user_msg, sender, created_at)
    //         VALUES ('$conversation_id', '$message', 'user', NOW())";
    // if (!$conn->query($sql)) {
    //     die("Error forwarding message to agent: " . $conn->error);
    // }
}


function checkForAgentResponse($conversation_id, $conn) {
    $ra_id = $_SESSION['ra_id'];
    $sql = "SELECT msgs FROM d_agent WHERE ra_id= '{$ra_id}' AND u_id IS NOT NULL ORDER BY datetime DESC LIMIT 1";
    $result = $conn->query($sql);
    if (!empty($row['msgs']) && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return [$row['msg']];
    } else {
        // return ["Waiting for agent response..."];
    }
}


// function forwardToAIAgent($conversation_id, $message, $conn) {
//     $rai_id = $_SESSION['rai_id'];
    
//     // Check if the message already exists
//     $sql_check = "SELECT * FROM ai_agent WHERE rai_id = '{$rai_id}' AND msgs = '{$message}'";
//     $result_check = $conn->query($sql_check);

//     if ($result_check->num_rows == 0) {
//         $sql = "INSERT INTO ai_agent (rai_id, datetime, msgs, status, mode) 
//                 VALUES ('{$rai_id}', NOW(), '{$message}', '0', '0')";
//         if (!$conn->query($sql)) {
//             die("Error forwarding message to agent: " . $conn->error);
//         }
//     }
// }

function forwardToAIAgent($conversation_id, $message, $conn) {
    $rai_id = $_SESSION['rai_id'];

    // Check if the message already exists
    $sql_check = "SELECT * FROM ai_agent WHERE rai_id = '{$rai_id}' AND msgs = '{$message}'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        // Insert user message
        $sql_user = "INSERT INTO ai_agent (rai_id, datetime, msgs, status, mode) 
                     VALUES ('{$rai_id}', NOW(), '{$message}', '0', '0')";
        if (!$conn->query($sql_user)) {
            die("Error inserting user message: " . $conn->error);
        }

        // Call Gemini from external file
        require_once("gemini_api.php");  // includes the function
        $ai_reply = getGeminiResponse($message);  // call the API

        // Insert AI reply
        $ai_reply_safe = $conn->real_escape_string($ai_reply);
        $sql_ai = "INSERT INTO ai_agent (rai_id, datetime, msgs, status, mode) 
                   VALUES ('{$rai_id}', NOW(), '{$ai_reply_safe}', '2', '2')";
        if (!$conn->query($sql_ai)) {
            die("Error inserting AI reply: " . $conn->error);
        }
    }
}
// function forwardToAIAgent($conversation_id, $message, $conn) {
//     $rai_id = $_SESSION['rai_id'];
    
//     $sql = "INSERT INTO ai_agent (rai_id, datetime, msgs, status, mode) 
//             VALUES ('{$rai_id}', NOW(), '{$message}', '0', '0')";
//     if (!$conn->query($sql)) {
//         die("Error forwarding message to agent: " . $conn->error);
//     }
    
// }


function checkForAIAgentResponse($conversation_id, $conn) {
    $rai_id = $_SESSION['rai_id'];
    $sql = "SELECT msgs FROM ai_agent WHERE rai_id= '{$rai_id}' AND status = 1  ORDER BY datetime DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return [$row['msg']];
    } else {
        // return ["Waiting for agent response..."];
    }
}

function getCustomerByIdentifier($identifier, $conn) {
    // Prepare SQL query to fetch customer by phone or CNIC
    $sql = "SELECT * FROM customer WHERE phone = '$identifier' OR email = '$identifier'";
    $result = $conn->query($sql);

    // Check if a row is returned
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function addCustomer($phone, $email, $address, $name, $conn) {
    $phone = $conn->real_escape_string($phone);
    $name = $conn->real_escape_string($name);
    $address = $conn->real_escape_string($address);
    $email = $conn->real_escape_string($email);

    $sql = "INSERT INTO customer (phone, email, name, address) VALUES ('$phone', '$email', '$name', '$address')";
    if (!$conn->query($sql)) {
        die("Error inserting customer: " . $conn->error);
    }
}

function startConversation($name, $identifier, $conn) {
    $sql = "INSERT INTO conversations (sender, name) VALUES ('$identifier', '$name')";
    if ($conn->query($sql) === TRUE) {
        return $conn->insert_id;
    } else {
        die("Error creating conversation: " . $conn->error);
    }
}



function saveMessage($conversation_id, $message, $sender, $conn) {
    $message = strip_tags($message);
    if ($sender == 'user') {
        // Insert user's question into msgs table
        $sql = "INSERT INTO msgs (conversation_id, question, answer, created_at)
                VALUES ('$conversation_id', '$message', '', NOW())";
        if (!$conn->query($sql)) {
            die("Error saving user message: " . $conn->error);
        }

        // Get the question id from the questions table
        $question_id = 0;
        $sql_question_id = "SELECT q.id AS question_id
                            FROM search s
                            JOIN questions q ON s.q_id = q.id
                            WHERE s.Kewords = '$message' LIMIT 1";
        $result_question_id = $conn->query($sql_question_id);
        if ($result_question_id->num_rows > 0) {
            $row_question_id = $result_question_id->fetch_assoc();
            $question_id = $row_question_id['question_id'];
        }

        // Get the chat_no for the current conversation
        if (!isset($_SESSION['chat_no'])) {
            $sql_max_chat_no = "SELECT MAX(chat_no) AS max_chat_no FROM testtbl";
            $result_max_chat_no = $conn->query($sql_max_chat_no);
            $max_chat_no = 0;
            if ($result_max_chat_no->num_rows > 0) {
                $row_max_chat_no = $result_max_chat_no->fetch_assoc();
                $max_chat_no = $row_max_chat_no['max_chat_no'];
            }
            $_SESSION['chat_no'] = $max_chat_no + 1;
        }

        $chat_no = $_SESSION['chat_no'];

        // Insert user question into testtbl
        $phone_no = ''; // Default value if not set
        $sql_user = "SELECT sender FROM conversations WHERE id = '$conversation_id'";
        $result_user = $conn->query($sql_user);
        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $phone_no = $row_user['sender'];
        }

        $sql_testtbl = "INSERT INTO testtbl (chat_no, parent, message, sender, created, agent_mod)
                        VALUES ('$chat_no', '$question_id', '$message', '$phone_no', NOW(), 0)";
        // if (!$conn->query($sql_testtbl)) {
        //     die("Error saving user message in testtbl: " . $conn->error);
        // }
    } else {
        // Update the user's question with the bot's answer
        $sql = "UPDATE msgs SET answer = '$message' 
                WHERE conversation_id = '$conversation_id' AND answer = '' ORDER BY id DESC LIMIT 1";
        if (!$conn->query($sql)) {
            die("Error saving bot message: " . $conn->error);
        }
    }
}


function getResponseFromFAQ($message, $conn) {
    // Prepare SQL query to fetch response from FAQ table
    // $sql = "SELECT q2.questions AS answer, q2.input_type, q2.pdf_file, q2.image FROM search s
    //         JOIN questions q1 ON s.q_id = q1.id
    //         LEFT JOIN questions q2 ON q1.id = q2.parent
    //         WHERE s.Kewords = '$message'";

    if (containsBadWord($message)) {
    return ["⚠️ Your message contains inappropriate language. Please rephrase it."];
}
//     $sql ="SELECT q2.questions AS answer, q2.input_type, q2.pdf_file, q2.image
// FROM search s
// JOIN questions q1 ON s.q_id = q1.id
// LEFT JOIN questions q2 ON q1.id = q2.parent
// WHERE s.Kewords = '$message'

// UNION

// SELECT q.questions AS answer, q.input_type, q.pdf_file, q.image
// FROM questions q
// WHERE q.questions LIKE CONCAT('%', '$message', '%')
//   AND q.title != 'MENU'
//   AND NOT EXISTS (
//       SELECT 1
//       FROM search s2
//       WHERE s2.Kewords = '$message'
//   )
// ";
$message = strtolower(trim($message));
$words = explode(" ", $message);
$likeConditions = [];

foreach ($words as $word) {
    $word = trim($word);
    if (strlen($word) > 2) { // skip very small words
        $likeConditions[] = "q.questions LIKE '%$word%'";
    }
}
if (!empty($likeConditions)) {
    $likeSql = implode(" AND ", $likeConditions);

    $sql = "SELECT q2.questions AS answer, q2.input_type, q2.pdf_file, q2.image
    FROM search s
    JOIN questions q1 ON s.q_id = q1.id
    LEFT JOIN questions q2 ON q1.id = q2.parent
    WHERE INSTR(LOWER('$message'), LOWER(s.kewords)) > 0

    UNION

    SELECT q.questions AS answer, q.input_type, q.pdf_file, q.image
    FROM questions q
    WHERE ($likeSql)
      AND q.title != 'MENU'
      AND NOT EXISTS (
          SELECT 1
          FROM search s2
          WHERE INSTR(LOWER('$message'), LOWER(s2.kewords)) > 0
      )
    ";
} else {
    // agar koi like word nahi bana, to fallback query karo sirf keyword matching wali
    $sql = "
    SELECT q2.questions AS answer, q2.input_type, q2.pdf_file, q2.image
    FROM search s
    JOIN questions q1 ON s.q_id = q1.id
    LEFT JOIN questions q2 ON q1.id = q2.parent
    WHERE INSTR(LOWER('$message'), LOWER(s.kewords)) > 0
    ";
}


    $result = $conn->query($sql);

    // Check if a row is returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Extract the answer and type
        $answer = $row["answer"];
        $input_type = $row["input_type"];
        $pdf_file = $row["pdf_file"];
        $image = $row["image"];
        $response = [$answer];
        // If the input type is pdf, add the PDF file link to the response
        if ($input_type === 'pdf' && !empty($pdf_file)) {
            $pdf_message = "Here is the PDF you requested: <a href='" . $pdf_file . "' target='_blank'>Download PDF</a>";
            $response[] = $pdf_message;
        }
        if ($input_type === 'image' && !empty($image)) {
            $pdf_message = "Here is the Image you requested: <a href='" . $image . "' target='_blank'>Download Image</a>";
            $response[] = $image;
        }
        // Return the response, converting new lines to <br>
        return str_replace("\n", "<br>", $response);
    } else {
        return null;
    }
}

function notifyCallCenter($conversation_id, $message, $conn) {
    // Check if ra_id is already set in session
    if (!isset($_SESSION['ra_id'])) {
        // Fetch user details from conversation
        $sql = "SELECT sender, name FROM conversations WHERE id = '$conversation_id'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $phone_no = $user['sender'];
        $name_callcenter = $user['name'];

        $sql_t_id = "SELECT id FROM testtbl WHERE message = '$message' ORDER BY id DESC LIMIT 1";
        $result_t_id = $conn->query($sql_t_id);
        if ($result_t_id->num_rows > 0) {
            $row_t_id = $result_t_id->fetch_assoc();
            $t_id = $row_t_id['id'];
        } else {
            $t_id = 0; // default value if t_id is not found
        }

        // error_log("Debug: Inserting into req_to_agent with phone_no: $phone_no, name: $name_callcenter, t_id: $t_id");

        // Insert into req_to_agent
        $sql = "INSERT INTO req_to_agent (u_id, datetime, status, mode, phone_no, name, t_id) 
                VALUES ('0', NOW(), '0', '0', '{$phone_no}', '{$name_callcenter}', '{$t_id}')";
        if (!$conn->query($sql)) {
            die("Error inserting into req_to_agent: " . $conn->error);
        }

        // Store ra_id in session
        $_SESSION['ra_id'] = $conn->insert_id;
    }

    error_log("Debug: Inserting into d_agent with ra_id: " . $_SESSION['ra_id']);

    // Insert into d_agent using the stored ra_id
    $ra_id = $_SESSION['ra_id'];
    $sql = "INSERT INTO d_agent (ra_id, datetime, msgs, reply_id) 
            VALUES ('{$ra_id}',  NOW(), '{$message}', '0')";
    if (!$conn->query($sql)) {
        die("Error inserting into d_agent: " . $conn->error);
    }
}



function Requesttoai($conversation_id, $message, $conn) {
    // Check if ra_id is already set in session
    if (!isset($_SESSION['rai_id'])) {
        // Fetch user details from conversation
        $sql = "SELECT sender, name FROM conversations WHERE id = '$conversation_id'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $phone_no = $user['sender'];
        $name_callcenter = $user['name'];

        $sql_t_id = "SELECT id FROM testtbl WHERE message = '$message' ORDER BY id DESC LIMIT 1";
        $result_t_id = $conn->query($sql_t_id);
        if ($result_t_id->num_rows > 0) {
            $row_t_id = $result_t_id->fetch_assoc();
            $t_id = $row_t_id['id'];
        } else {
            $t_id = 0; // default value if t_id is not found
        }

        error_log("Debug: Inserting into req_to_agent with phone_no: $phone_no, name: $name_callcenter, t_id: $t_id");

        // Insert into req_to_agent
        $sql = "INSERT INTO req_to_ai ( datetime, status, mode, phone_no, name, t_id) 
                VALUES ( NOW(), '0','0', '{$phone_no}', '{$name_callcenter}', '{$t_id}')";
        if (!$conn->query($sql)) {
            die("Error inserting into req_to_agent: " . $conn->error);
        }

        // Store ra_id in session
        $_SESSION['rai_id'] = $conn->insert_id;
    }

    error_log("Debug: Inserting into d_agent with ra_id: " . $_SESSION['rai_id']);

    // Insert into d_agent using the stored ra_id
    // $ra_id = $_SESSION['rai_id'];
    // $sql = "INSERT INTO ai_agent (rai_id, datetime, msgs, status, mode) 
    //         VALUES ('{$ra_id}',  NOW(), 'hi', '0', '1')";
    // if (!$conn->query($sql)) {
    //     die("Error inserting into d_agent: " . $conn->error);
    // }
}


error_log("forwardToAIAgent function called", 3, "debug.log");

$conn->close();
?>

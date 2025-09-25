<?php

include("db_connection.php");
include("function.php");

if (isset($_POST['question_submit'])) {
    handleQuestionSubmit($conn);
}

if (isset($_POST['update_question'])) {
    handleQuestionUpdate($conn);
}

if (isset($_POST['memid']) && $_POST['memid'] > 0) {
    deleteQuestion($conn, $_POST['memid']);
}

function handleQuestionSubmit($conn) {
    $question = $_POST['question'];
    $input_type = $_POST['input_type'];
    $intro_message = $_POST['intro_message'];

    if (isset($_FILES['image']) || isset($_FILES['pdf_file'])) {
        foreach ($_FILES['pdf_file']['name'] as $keys => $preq) {
            $title = sanitizeInput($_POST['title'][$keys]);
            $conv_id = sanitizeInput($_POST['conv_id'][$keys]);
            $pdf_file = $_FILES['pdf_file']['name'][$keys];
            $pdf_temp_name = $_FILES['pdf_file']['tmp_name'][$keys];
            $image = $_FILES['image']['name'][$keys];
            $img_temp_name = $_FILES['image']['tmp_name'][$keys];
            $status = isset($_POST['status'][$keys]) ? sanitizeInput($_POST['status'][$keys]) : 'A';

            $pdf_full_url = handleFileUpload($pdf_file, $pdf_temp_name, 'pdf_files/', ['pdf']);
            $image_full_url = handleFileUpload($image, $img_temp_name, 'image/', ['gif', 'png', 'jpg']);

            $parent = sanitizeInput($_POST['parent']);
            $questions = sanitizeInput($question[$keys]);
            $input_type_key = sanitizeInput($input_type[$keys]);

            if ($questions) {
                $sql_pro = "INSERT INTO `questions` (`parent`, `questions`, `title`, `conv_id`, `pdf_file`, `image`, `input_type`, `status`, `intro_message`) VALUES ('$parent', '$questions', '$title', '$conv_id', '$pdf_full_url', '$image_full_url', '$input_type_key', '$status', '$intro_message')";
                mysqli_query($conn, $sql_pro) ;
            }
        }

        echo "<script>window.location='view_questions.php';</script>";
    }
}


function handleQuestionUpdate($conn) {
    $ep_ques = $_POST['ep_ques'];
    $ep_intro_message = $_POST['ep_intro_message'];
    $p_ques = $_POST['p_ques'];
    $p_title = $_POST['p_title'];
    $p_conv_id = $_POST['p_conv_id'];
    $ep_title = $_POST['ep_title'];
    $ep_conv_id = $_POST['ep_conv_id'];
    $p_input_type = $_POST['p_input_type'];
    $ep_input_type = $_POST['ep_input_type'];
    $sno = sanitizeInput($_POST['sno']);
    $p_parent = sanitizeInput($_POST['p_parent']);
    $ep_parent = sanitizeInput($_POST['edit_parent']);
    $edit_image = $_POST['edit_image'];
    $edit_pdf = $_POST['edit_pdf'];
    $parent_title = sanitizeInput($_POST['parent_title']);
    $edit_id = sanitizeInput($_POST['edit_id']);

    if (isset($_FILES['ep_image']) || isset($_FILES['ep_pdf_file'])) {
        foreach ($_FILES['ep_image']['name'] as $ekey => $preq) {
            $ep_image = $_FILES['ep_image']['name'][$ekey];
            $img_temp_name = $_FILES['ep_image']['tmp_name'][$ekey];
            $ep_pdf_file = $_FILES['ep_pdf_file']['name'][$ekey];
            $ep_pdf_temp_name = $_FILES['ep_pdf_file']['tmp_name'][$ekey];
            $ep_status = isset($_POST['ep_status'][$ekey]) ? sanitizeInput($_POST['ep_status'][$ekey]) : 'A';

            $image_full_url = handleFileUpload($ep_image, $img_temp_name, 'image/', ['gif', 'png', 'jpg'], $edit_image[$ekey]);
            $pdf_full_url = handleFileUpload($ep_pdf_file, $ep_pdf_temp_name, 'pdf_files/', ['pdf'], $edit_pdf[$ekey]);

            if ($ep_ques) {
                $ep_quess = sanitizeInput($ep_ques[$ekey]);
                $sql_epro = "UPDATE `questions` SET
                    `input_type`='{$ep_input_type[$ekey]}',
                    `title`='{$ep_title[$ekey]}',
                    `conv_id`='{$ep_conv_id[$ekey]}',
                    `intro_message`='$ep_intro_message',
                    `questions`='$ep_quess',
                    `image`=" . ($image_full_url ? "'$image_full_url'" : "NULL") . ",
                    `pdf_file`=" . ($pdf_full_url ? "'$pdf_full_url'" : "NULL") . ",
                    `status`='$ep_status',
                    `parent`='$ep_parent'
                    WHERE `id`='$ekey'";
                mysqli_query($conn, $sql_epro) or die(mysqli_error($conn));
            }
        }

        $sql_epro2 = "UPDATE questions SET title='$parent_title' WHERE id='$edit_id'";
        mysqli_query($conn, $sql_epro2) or die(mysqli_error($conn));
    }

    handleNewQuestions($conn, $p_parent, $p_ques, $p_title, $p_conv_id, $p_input_type, $sno, $ep_intro_message);
}

function handleNewQuestions($conn, $p_parent, $p_ques, $p_title, $p_conv_id, $p_input_type, $sno, $ep_intro_message) {
    if (isset($_FILES['p_image']) || isset($_FILES['p_pdf_file'])) {
        foreach ($_FILES['p_pdf_file']['name'] as $keys => $preq) {
            $p_pdf_file = $_FILES['p_pdf_file']['name'][$keys];
            $p_pdf_temp_name = $_FILES['p_pdf_file']['tmp_name'][$keys];
            $p_image = $_FILES['p_image']['name'][$keys];
            $p_img_temp_name = $_FILES['p_image']['tmp_name'][$keys];
            $p_status = isset($_POST['p_status'][$keys]) ? sanitizeInput($_POST['p_status'][$keys]) : 'A';

            $pdf_full_url = handleFileUpload($p_pdf_file, $p_pdf_temp_name, 'pdf_files/', ['pdf']);
            $image_full_url = handleFileUpload($p_image, $p_img_temp_name, 'image/', ['gif', 'png', 'jpg']);

            if ($p_ques[$keys]) {
                $sql_pro = "INSERT INTO `questions` (title, questions, parent, conv_id, input_type, image, pdf_file, status, intro_message) VALUES (
                    '{$p_title[$keys]}', '{$p_ques[$keys]}', '$p_parent', '{$p_conv_id[$keys]}', '{$p_input_type[$keys]}', '$image_full_url', '$pdf_full_url', '$p_status', '$ep_intro_message')";
                mysqli_query($conn, $sql_pro) or die(mysqli_error($conn));
            }
        }

        echo "<script>window.location='view_questions.php?edit_id=$sno'</script>";
    }
}

function deleteQuestion($conn, $del) {
    $sql_del = "DELETE FROM `questions` WHERE id=$del";
    mysqli_query($conn, $sql_del) or die(mysqli_error($conn));
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function handleFileUpload($file, $temp_name, $path, $allowed_types, $old_file = null) {
    if (!in_array(pathinfo($file, PATHINFO_EXTENSION), $allowed_types)) {
        return null;
    }

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    $file_url = $path . basename($file);

    if (move_uploaded_file($temp_name, $file_url)) {
        if ($old_file) {
            $old_file_path = explode('questions/', $old_file);
            if (isset($old_file_path[1])) {
                unlink($old_file_path[1]);
            }
        }
        return "https://$_SERVER[HTTP_HOST]/$file_url";
    }
    return null;
}

?>
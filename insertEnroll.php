<?php
require_once "connect.php";
session_start();
if (empty($_SESSION["user_status"])) {
    header("location: index.php");
}
$student_id = $_POST["student_id"];
$prefix_name = $_POST["prefix_name"];
$people_id = $_POST["people_id"];
$stu_fname = $_POST["stu_fname"];
$stu_lname = $_POST["stu_lname"];
$group_id = $_POST["group_id"];
$major_name = $_POST["major_name"];
$minor_name = $_POST["minor_name"];
$grade_name = $_POST["grade_name"];
$student_group_no = $_POST["student_group_no"];
$recipient_prefix = $_POST["recipient_prefix"];
$recipient_fname = $_POST["recipient_fname"];
$recipient_lname = $_POST["recipient_lname"];
$student_group_short_name = $_POST["student_group_short_name"];
$phone = $_POST["phone"];

date_default_timezone_set("Asia/Bangkok");
$nameDate = date("YmdHis");
$target_dir = "../refund/uploads/";
$id_card_pic_std =  "id_card_pic_std" . $student_id . "_" . $nameDate . ".jpg";
$target_file_id_card_pic_std = $target_dir . $id_card_pic_std;
$id_card_pic = "id_card_pic_" . $student_id . "_" . $nameDate . ".jpg";
$target_file_id_card_pic = $target_dir . $id_card_pic;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file_id_card_pic, PATHINFO_EXTENSION));


$check = getimagesize($_FILES["id_card_pic_std"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    $uploadOk = 0;
}
$check = getimagesize($_FILES["id_card_pic"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    // if (move_uploaded_file($_FILES["id_card_pic_std"]["tmp_name"], $target_file_id_card_pic_std)) {
    // } else {
    //     echo "Sorry, there was an error uploading your file.";
    // }
    // if (move_uploaded_file($_FILES["id_card_pic"]["tmp_name"], $target_file_id_card_pic)) {
    // } else {
    //     echo "Sorry, there was an error uploading your file.";
    // }

    //base64
    $id_card_pic_std = $_POST["id_card_pic_std_h"];
    $id_card_pic = $_POST["id_card_pic_h"];
    $account_book_pic = $_POST["account_book_pic_h"];


    $folderPath = "../refund/uploads/";
    $image_parts = explode(";base64,", $_POST["id_card_pic_std_h"]);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . $student_id . "std_" . $nameDate . '.' . $image_type;
    $id_card_pic_std = $student_id . "std_" . $nameDate . '.' . $image_type;
    file_put_contents($file, $image_base64);

    $folderPath = "../refund/uploads/";
    $image_parts = explode(";base64,", $_POST["id_card_pic_h"]);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . $student_id . "p_" . $nameDate . '.' . $image_type;
    $id_card_pic = $student_id . "p_" . $nameDate . '.' . $image_type;
    file_put_contents($file, $image_base64);

    $sql = "replace into enroll 
    (
        people_id,
        student_id,
        prefix_name,
        stu_fname,
        stu_lname,
        group_id,
        student_group_no,
        major_name,
        minor_name,
        grade_name,
        student_group_short_name,
        stu_signature,
        parent_signature,
        id_card_pic_std,
        id_card_pic,
        account_book_pic,
        status,
        recipient,
        recipient_prefix,
        recipient_fname,
        recipient_lname,
        recipient_bank,
        recipient_bank_number,
        pay_id,
        phone

    ) values(
        '$people_id',
        '$student_id',
        '$prefix_name',
        '$stu_fname',
        '$stu_lname',
        '$group_id',
        '$student_group_no',
        '$major_name',
        '$minor_name',
        '$grade_name',
        '$student_group_short_name',
        '',
        '',
        '$id_card_pic_std',
        '$id_card_pic',
        '',
        'พิมพ์แล้ว',
        '$recipient',
        '$recipient_prefix',
        '$recipient_fname',
        '$recipient_lname',
        '',
        '',
        '',
        '$phone'
    );
    ";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header("location: insertCard.php");
    } else {
        echo $sql;
    }
}

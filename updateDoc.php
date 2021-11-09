<?php
require_once "connect.php";
if (!empty($_POST["student_id"])) {
    $student_id = $_POST["student_id"];
    $status = $_POST["update"];

    // $sql = "update documents set status='$status' where student_id='$student_id'";
    $sql = "replace into documents (student_id,status) value('$student_id','$status')";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo "ok";
        // header("location: listEnroll.php");
    } else {
        echo $sql;
        // header("location: pageError.php?text_err=อัพเดทไม่สำเร็จ");
    }
}

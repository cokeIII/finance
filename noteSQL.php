<?php
require_once "connect.php";
header('Content-Type: text/html; charset=UTF-8');
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (!empty($_POST)) {
    if ($_POST["act"] == "insertNote") {
        $id = $_POST["enrollId"];
        $note = json_encode($_POST["note"], JSON_UNESCAPED_UNICODE);
        $sql = "update enroll set  note = '$note' where student_id = '$id'";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            echo json_encode("ok");
        }
    } else if ($_POST["act"] == "getNote") {
        $id = $_POST["enrollId"];
        $sql = "select note from enroll where student_id='$id'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $data = array();
        $data["note"] =  $row["note"];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

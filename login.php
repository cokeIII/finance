<?php
require_once "connect.php";
require_once "function.php";
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
header('Content-Type: text/html; charset=UTF-8');
// checkStd($username);
if ($password == "ctcfinance") {
    $sql = "select * from people where people_id = '$username'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_array($res);
        $_SESSION['people_id'] = $row["people_id"];
        $_SESSION["user_status"] = "finance";
        header("location: listDoc.php");
    } else {
        header("location: errPage.php?textErr=ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง กรุณาเข้าสู่ระบบใหม่อีกครั้ง <a href='index.php'>เข้าสู่ระบบ<a/>");
    }
} else {
    header("location: errPage.php?textErr=ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง กรุณาเข้าสู่ระบบใหม่อีกครั้ง <a href='index.php'>เข้าสู่ระบบ<a/>");
}

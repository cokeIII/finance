<?php
require_once("connect.php");
$student_id = $_POST["student_id"];
$sql = "select * from enroll where student_id = '$student_id'";
$res = mysqli_query($conn, $sql);
$numRow = mysqli_num_rows($res);
if ($numRow > 0) {
    echo "g";
} else {
    echo $sql;
}

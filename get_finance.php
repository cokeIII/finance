<?php
header('Content-Type: text/html; charset=UTF-8');
require_once "connect.php";
if (!empty($_POST["room_name"])) {
    $room_name = $_POST["room_name"];
    $sql = "select e.*,d.status as dStatus,d.time_stamp as dTimeStamp from enroll e
    left join  documents d on d.student_id = e.student_id 
    where 
    e.group_id = '$room_name'  and 
    e.status = 'พิมพ์แล้ว' order by e.student_id";
} else {
    $sql = "select e.*,d.status as dStatus,d.time_stamp as dTimeStamp from enroll e 
    left join  documents d on d.student_id = e.student_id
    where e.status = 'พิมพ์แล้ว'
    order by e.student_id
    ";
}
$i = 0;

$techlist["data"][$i]["no"] = "ไม่มีข้อมูล";
$techlist["data"][$i]["student_id"] = "";
$techlist["data"][$i]["stu_name"] = "";
$techlist["data"][$i]["student_group_short_name"] = "";
$techlist["data"][$i]["status"] = "";
$techlist["data"][$i]["time_stamp"] = "";
$techlist["data"][$i]["select_status"] = "";
$techlist["data"][$i]["btn_print"] = "";

$res = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($res)) {
    $techlist["data"][$i]["no"] = $i + 1;
    $techlist["data"][$i]["student_id"] = $row["student_id"];
    $techlist["data"][$i]["stu_name"] = $row["stu_fname"] . " " . $row["stu_lname"];
    $techlist["data"][$i]["student_group_short_name"] = $row["student_group_short_name"];
    $techlist["data"][$i]["status"] = '<div class="col-status-'.$row["id"].' '.($row["dStatus"] == "ยกเลิก" || $row["dStatus"] == "เอกสารไม่ถูกต้องสมบูรณ์"?'text-danger':'text-success').'">'.$row["dStatus"]."</div>";
    $techlist["data"][$i]["time_stamp"] = $row["dTimeStamp"];
    $techlist["data"][$i]["select_status"] = ' <select enrollId="' . $row["id"] . '" std_id="' . $row["student_id"] . '" name="status" id="status" class="form-control status">
    <option value=""' . ($row["dStatus"] == "" ? "selected" : "") . '></option>
    <option value="พิมพ์แล้ว"' . ($row["dStatus"] == "พิมพ์แล้ว" ? "selected" : "") . '>พิมพ์แล้ว</option>
    <option value="เอกสารไม่ถูกต้องสมบูรณ์"' . ($row["dStatus"] == "เอกสารไม่ถูกต้องสมบูรณ์" ? "selected" : "") . '>เอกสารไม่ถูกต้องสมบูรณ์</option>
    <option value="ส่งเอกสารแล้ว"' . ($row["dStatus"] == "ส่งเอกสารแล้ว" ? "selected" : "") . '>ส่งเอกสารแล้ว</option>
    <option value="ยกเลิก"' . ($row["dStatus"] == "ยกเลิก" ? "selected" : "") . '>ยกเลิก</option>
</select>';
    $techlist["data"][$i]["btn_print"] = '<button enrollId="' . $row["id"] . '" class="btn btn-info btnPrint"><i class="fas fa-print"></i> พิมพ์</button>';
    $i++;
}
echo json_encode($techlist, JSON_UNESCAPED_UNICODE);

<?php
// Require composer autoload
date_default_timezone_set("Asia/Bangkok");
$dates = date("d/m/") . (date("Y") + 543);
$m = date("m");
$Y = date("Y") + 543;
if ($m >= 11) {
    $Y = (date("Y") + 543) - 1;
    $term = 2;
} else if ($m >= 5) {
    $term = 1;
} else {
    $term = 3;
}
$schoolYear = $term . " ปีการศึกษา " . $Y;
$dateD = date("Y-m-d");
session_start();

// if (empty($_SESSION["status"])) {
//     header("location: index.php");
// }

require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once 'connect.php';
error_reporting(error_reporting() & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);


header('Content-Type: text/html; charset=utf-8');
// เพิ่ม Font ให้กับ mPDF
$mpdf = new mPDF();
date_default_timezone_set("asia/bangkok");
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    // return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    return "$strDay $strMonthThai $strYear";
}
ob_start(); // Start get HTML code
$group_id = $_GET["group_id"];
$sql = "select * from student s
left join student_group sg on s.group_id = sg.student_group_id
where sg.student_group_id = '$group_id'
and s.status = 0
";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
$level = explode(".", $row["grade_name"]);
?>


<!DOCTYPE html>
<html>

<head>
    <title>CTC Refund</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/ovec-removebg.ico" />
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "thsarabun";
            font-size: 21px;
        }

        .border-table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table.border-table tr td {
            border: 1px solid black;
            font-size: 22px;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 30%;
        }

        .img-center {
            margin-left: 328px;
        }

        .text-justify {
            text-align: justify;
        }

        .bg-red {
            background-color: red;
        }

        .text-22 {
            font-size: 22px;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td colspan="2" class="text-center">เอกสารหมายเลข 2 </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><strong>หลักฐานการจ่ายเงิน</strong></td>
        </tr>
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td class="text-center" width="50%"><input type="checkbox" checked="true"> ค่าเครื่องแบบนักเรียน</td>
                        <td class="text-center" width="50%"><input type="checkbox"> ค่าอุปกรณ์การเรียน</td>
                    </tr>
                    <tr>
                        <td class="text-center">(900.-บาท)</td>
                        <td class="text-center">(230.-บาท)</td>
                    </tr>
                </table>
            </td>
            <td class="text-center">
                ภาคเรียนที่ 1 ปีการศึกษา 2564
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">***************************</td>
        </tr>
        <tr>
            <td colspan="2" class="text-left">ระดับประกาศนียบัตรวิชาชีพ (ปวช.) ชั้นปีที่ <?php echo $level[1]; ?> กลุ่ม <?php echo ltrim($row["student_group_no"], '0'); ?> แผนกวิชา <?php echo $row["major_name"]; ?></td>
        </tr>
        <tr>
            <td colspan="2">ได้รับเงินจากสถานศึกษา...........<strong>วิทยาลัยเทคนิคชลบุรี</strong>...........</td>
        </tr>
        <tr>
            <td colspan="2">สังกัดสำนักงานคณะกรรมการการอาชีวศึกษา และขอรับรองว่าข้าพเจ้าจะนำเงินที่ได้รับไปดำเนินการตาม</td>
        </tr>
    </table>
    <table width="100%" class="border-table">
        <tr>
            <td>ที่</td>
        </tr>
        <tr>
            <td>รหัสประจำตัว<div>นักเรียน</div>
            </td>
        </tr>
        <tr>
            <td>ชื่อ - สกุล นักเรียน</td>
        </tr>
        <tr>
            <td>
                <div>หมายเลขบัตร</div>
                <div>ประจำตัวประชาชน</div>
                <div>นักเรียน</div>
            </td>
        </tr>
        <tr>
            <td>จำนวนเงิน</td>
        </tr>
        <tr>
            <td>วันที่รับเงิน</td>
        </tr>
        <tr>
            <td>ลายมือชื่อ</td>
            <td>ผู้รับเงิน</td>
        </tr>
        <?php
            $res2 = mysqli_q 
            while()
        ?>
    </table>
</body>

</html>
<?php
$html = ob_get_contents();
// $mpdf->AddPage('L');
$mpdf->WriteHTML($html);
$taget = "pdf/report2.pdf";
$mpdf->Output($taget);
ob_end_flush();
echo "<script>window.location.href='$taget';</script>";
exit;
?>
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
$id = $_GET["id"];
$student_group_no = $_POST["student_group_no"];
// $sql = "select * from enroll
// left join student s on enroll.student_id = s.student_id
// left join student_group sg on enroll.group_id = sg.student_group_id
// left join tumbol t on t.tumbol_id = s.tumbol_id
// left join amphure a on a.amphure_id = t.amphure_id
// left join province p on p.province_id = a.province_id
// where enroll.id = '$id'
// and enroll.status = 'พิมพ์แล้ว'
// ";
$sql = "
select * from student
left join student_group sg on student.group_id = sg.student_group_id
left join prefix pe on pe.prefix_id = student.perfix_id
left join tumbol t on t.tumbol_id = student.tumbol_id
left join amphure a on a.amphure_id = t.amphure_id
left join province p on p.province_id = a.province_id
where student.student_id = '$id'
";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
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
            margin-left: 295px;
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

        /* ////////////////////////////////////////////css idcard */
        .txt-h {
            text-align: center;
        }

        .text-size {
            font-size: 23px;
        }

        .text-right {
            text-align: right;
        }

        .content {
            padding: 24px;

        }

        .txt-right {
            text-align: right;
        }

        .txt-bold {
            font-weight: bold;
        }

        .pic-h {
            height: 3in;
        }

        .center {
            text-align: center;
        }

        .red {
            background-color: red;
        }

        .mr {
            margin-right: 20px;
        }

        .width-sig {
            margin-left: 40%;
        }

        .tab {
            margin-left: 10%;
        }

        .m-r {
            margin-right: 15%;
        }

        .m-r-n {
            margin-right: 12%;
        }

        .sig-size {
            width: 75px;
            height: 30px;
        }

        .dott {
            text-decoration: none;
            border-bottom: 2px dotted black !important;
        }

        u {
            text-decoration: none;
            border-bottom: 2px dotted black !important;
            width: 100%;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td class="text-right" colspan="2">
                <div>ลำดับที่.....................................................</div>
                <div>กรณีที่ได้รับสิทธิ์ (ค่าเครื่องแบบนักเรียน)</div>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="2">
                <div>เอกสารหมายเลข 1</div>
                <strong>
                    <div>ใบสำคัญรับเงิน</div>
                </strong>
            </td>
        </tr>
        <tr>
            <td width="60%">
                <img class="img-center" src="img/doc-logo.gif" alt="" width="80" height="80">
            </td>
            <td class="text-right">
                <div>ชื่อสถานศึกษา วิทยาลัยเทคนิคชลบุรี</div>
                <div>วัน............เดือน........................พ.ศ.................</div>
            </td>
        </tr>
    </table>
    <!-- pull data -->
    <table width="100%">
        <tr>
            <td width="40%" class="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า (ผู้ปกครอง) (นาย/นาง/นางสาว)</td>
            <td class="dott">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["par_fname"] ." ". $row["par_lname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>อยู่บ้านเลขที่</td>
            <td class="dott"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["home_id"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>หมู่ที่ </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["moo"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td>ถนน </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["street"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td>ตำบล </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["tumbol_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="12%">อำเภอ/เขต</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["amphure_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="8%">จังหวัด</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["province_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="12%">รหัสไปรษณีย์</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["post"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%">เป็นผู้ปกครองของนักเรียนชื่อ (นาย/นาง/นางสาว/ด.ช./ด.ญ.)</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="43%">หมายเลขประจำตัวประชาชนของนักเรียน(13 หลัก)</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["people_id"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="9%">ระดับชั้น</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["grade_name"] . "/" . ltrim($row["student_group_no"], '0'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="5%">ช่าง</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["major_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="19%">รหัสประจำตัวนักเรียน</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["student_id"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="10%">ภาคเรียนที่</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="11%">ปีการศึกษา</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2565&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <!-- pull data -->

    <table width="100%">
        <tr>
            <td colspan="2">
                <div>ขอรับสิทธิ์ค่าเครื่องแบบนักเรียนและค่าอุปกรณ์การเรียนตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษา</div>ตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน ดังนี้
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>1. ค่าเครื่องแบบนักเรียน ระดับชั้น <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["grade_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> จำนวนเงิน <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;900.-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>บาท</strong></div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. ค่าอุปกรณ์การเรียน ระดับชั้น <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> จำนวนเงิน <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>บาท</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">รวมเป็นจำนวนเงินทั้งสิ้น 900.- บาท (-เก้าร้อยบาทถ้วน-)</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้รับเงิน</div>
                <div>(..........................................<?php //echo $row["par_fname"] ." ". $row["par_lname"]; ?>)</div>
                <div>ผู้ปกครอง/ผู้มอบอำนาจ</div>
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้รับเงิน</div>
                <div>(<?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>)</div>
                <div>นักเรียน/ผู้รับมอบอำนาจ</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>จ่ายเงินแล้ว</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้จ่ายเงิน</div>
                <div>(นางสาวราตรี ศรีเมือง)</div>
                <div>เจ้าหน้าที่การเงิน</div>
                <div>วันที่..........................................................</div>
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ.......................................................</div>
                <div>(นางกรรณิการ์ บำรุงญาติ)</div>
                <div>หัวหน้าการเงิน</div>
                <div>วันที่........................................................</div>
            </td>
        </tr>
    </table>

    <div><strong>หมายเหตุ</strong> : - สำเนาบัตรประจำตัวประชาชนผู้ปกครอง ลงชื่อรับรองเอกสาร</div>
    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- สำเนาบัตรประจำตัวประชาชนนักเรียน ลงชื่อรับรองเอกสาร</div>

    <pagebreak></pagebreak>

    <h2 class="center">วิทยาลัยเทคนิคชลบุรี</h2>
    <div class="center text-size">หลักฐานการรับค่าเครื่องแบบนักเรียน ระดับชั้น <?php echo $row["grade_name"]; ?> ปีการศึกษา 2565</div>
    <div class="text-size">1.สำเนาบัตรประชาชนของนักเรียน/นักศึกษา หมายเลขโทรศัพท์ <?php echo $row["phone"]; ?></div>
    <div class="text-size txt-right">ชั้น/ช่าง <?php echo $row["student_group_short_name"]; ?> รหัส <?php echo $row["student_id"]; ?></div>
    <div class="center"><img src="../refund/uploads/<?php echo $row["id_card_pic_std"]; ?>" alt="" height="150" width="290"></div>
    <div class="text-size center">สำเนาถูกต้อง</div>
    <br>
    <div class="text-size width-sig">ลงชื่อ</div>
    <div class="text-size center">(<?php echo $row["prefix_name"] . $row["stu_fname"] . " " . $row["stu_lname"]; ?>)</div>
    <div class="text-size">2.สำเนาบัตรประชาชน<?php echo $row["recipient"]; ?></div>
    <div class="center"><img src="../refund/uploads/<?php echo $row["id_card_pic"]; ?>" alt="" height="150" width="290"></div>
    <div class="text-size center">สำเนาถูกต้อง</div>
    <br>
    <div class="text-size width-sig">ลงชื่อ </div>
    <div class="text-size center">(<?php echo trim($row["recipient_prefix"]) . $row["recipient_fname"] . " " . $row["recipient_lname"]; ?>)</div>
    <pagebreak></pagebreak>
    <table width="100%">
        <tr>
            <td class="text-right" colspan="2">
                <div>ลำดับที่.....................................................</div>
                <div>กรณีที่ได้รับสิทธิ์ (ค่าอุปกรณ์การเรียน)</div>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="2">
                <div>เอกสารหมายเลข 1</div>
                <strong>
                    <div>ใบสำคัญรับเงิน</div>
                </strong>
            </td>
        </tr>
        <tr>
            <td width="60%">
                <img class="img-center" src="img/doc-logo.gif" alt="" width="80" height="80">
            </td>
            <td class="text-right">
                <div>ชื่อสถานศึกษา วิทยาลัยเทคนิคชลบุรี</div>
                <div>วัน............เดือน........................พ.ศ.................</div>
            </td>
        </tr>
    </table>
    <!-- pull data -->
    <table width="100%">
        <tr>
            <td width="40%" class="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า (ผู้ปกครอง) (นาย/นาง/นางสาว)</td>
            <td class="dott">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["par_fname"] ." ". $row["par_lname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>อยู่บ้านเลขที่</td>
            <td class="dott"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["home_id"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>หมู่ที่ </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["moo"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td>ถนน </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["street"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td>ตำบล </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["tumbol_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="12%">อำเภอ/เขต</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["amphure_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="8%">จังหวัด</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["province_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="12%">รหัสไปรษณีย์</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["post"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%">เป็นผู้ปกครองของนักเรียนชื่อ (นาย/นาง/นางสาว/ด.ช./ด.ญ.)</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="43%">หมายเลขประจำตัวประชาชนของนักเรียน(13 หลัก)</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["people_id"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="9%">ระดับชั้น</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["grade_name"] . "/" . ltrim($row["student_group_no"], '0'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="5%">ช่าง</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["major_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="19%">รหัสประจำตัวนักเรียน</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["student_id"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="10%">ภาคเรียนที่</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="11%">ปีการศึกษา</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2565&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td colspan="2">
                <div>ขอรับสิทธิ์ค่าเครื่องแบบนักเรียนและค่าอุปกรณ์การเรียนตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษา</div>ตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน ดังนี้
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. ค่าเครื่องแบบนักเรียน ระดับชั้น <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> จำนวนเงิน <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>บาท</div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>2. ค่าอุปกรณ์การเรียน ระดับชั้น <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["grade_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> จำนวนเงิน <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;230.-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>บาท</strong></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">รวมเป็นจำนวนเงินทั้งสิ้น 230.- บาท (-สองร้อยสามสิบบาทถ้วน-)</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้รับเงิน</div>
                <div>(..........................................<?php //echo $row["par_fname"] ." ".$row["par_lname"];?>)</div>
                <div>ผู้ปกครอง/ผู้มอบอำนาจ</div>
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้รับเงิน</div>
                <div>(<?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>)</div>
                <div>นักเรียน/ผู้รับมอบอำนาจ</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>จ่ายเงินแล้ว</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้จ่ายเงิน</div>
                <div>(นางสาวราตรี ศรีเมือง)</div>
                <div>เจ้าหน้าที่การเงิน</div>
                <div>วันที่..........................................................</div>
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ.......................................................</div>
                <div>(นางกรรณิการ์ บำรุงญาติ)</div>
                <div>หัวหน้าการเงิน</div>
                <div>วันที่........................................................</div>
            </td>
        </tr>
    </table>

    <div><strong>หมายเหตุ</strong> : - สำเนาบัตรประจำตัวประชาชนผู้ปกครอง ลงชื่อรับรองเอกสาร</div>
    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- สำเนาบัตรประจำตัวประชาชนนักเรียน ลงชื่อรับรองเอกสาร</div>
    <pagebreak></pagebreak>
    <table width="100%">
        <tr>
            <td class="text-right">
                แบบ บก.111
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <div>ใบรับรองแทนใบเสร็จรับเงิน</div>
                <div>วิทยาลัยเทคนิคชลบุรี</div>
            </td>
        </tr>
    </table>
    <table width="100%" class="border-table">
        <tr>
            <td class="text-center">วัน เดือน ปี</td>
            <td class="text-center">รายละเอียดรายจ่าย</td>
            <td class="text-center">จำนวนเงิน</td>
            <td class="text-center">หมายเหตุ</td>
        </tr>
        <tr>
            <td></td>
            <td>ข้าพเจ้าได้ซื้ออุปกรณ์การเรียนประจำภาคเรียนที่ 1/2565 ดังนี้</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)ปากกาลูกลื่น................ด้าม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)ไม้บรรทัด................อัน ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)สมุดปกอ่อน................เล่ม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)สมุดปกแข็ง................เล่ม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)น้ำยาลบคำผิด................ด้าม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)ดินสอ................ด้าม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">รวมทั้งสิ้น</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">ขอเบิกเพียง</td>
            <td class="text-center">230.-</td>
            <td></td>
        </tr>
    </table>
    <br>
    <table width="100%" class="text-22">
        <tr>
            <td colspan="4">
                <div>รวมทั้งสิ้น (ตัวอักษร)...............................................-สองร้อยสามสิบบาทถ้วน-................................................................</div>
            </td>
        </tr>
        <tr>
            <td class="text-left" width="14%">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า
            </td>
            <td class="dott">
                <?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>
            </td>
            </td>
            <td width="10%">ตำแหน่ง</td>
            <td class="dott">
                นักเรียน
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div>สังกัดวิทยาลัยเทคนิคชลบุรี กองวิทยาลัยเทคนิคชลบุรี กรมอาชีวศึกษา กระทรวงศึกษาธิการ ขอรับรองว่า</div>
                <div>รายจ่ายข้างต้น ไม่อาจเรียกใบเสร็จรับเงินจากผู้รับเงินได้ และข้าพเจ้าได้จ่ายเงินไปในงานของราชการโดยแท้</div>
            </td>
        </tr>
        <tr>
            <td class="text-right" colspan="4"><br>ลงชื่อ.................................................นักเรียน</td>
        </tr>
        <tr>
            <td class="text-right" colspan="4"><br>ลงชื่อ..............................................ผู้ปกครอง</td>
        </tr>
    </table>
    <!-- <pagebreak></pagebreak>
    <h2 class="center">วิทยาลัยเทคนิคชลบุรี</h2>
    <div class="center text-size">หลักฐานการรับค่าอุปกรณ์การเรียนของนักเรียนระดับชั้น <?php //echo $row["grade_name"]; ?> ภาคเรียนที่ 1 ปีการศึกษา 2565</div>
    <div class="text-size">1.สำเนาบัตรประชาชนของนักเรียน/นักศึกษา หมายเลขโทรศัพท์ <?php //echo $row["phone"]; ?></div>
    <div class="text-size txt-right">ชั้น/ช่าง <?php //echo $row["student_group_short_name"]; ?> รหัส <?php //echo $row["student_id"]; ?></div>
    <div class="center"><img src="../refund/uploads/<?php //echo $row["id_card_pic_std"]; ?>" alt="" height="150" width="290"></div>
    <div class="text-size center">สำเนาถูกต้อง</div>
    <br>
    <div class="text-size width-sig">ลงชื่อ</div>
    <div class="text-size center">(<?php //echo $row["prefix_name"] . $row["stu_fname"] . " " . $row["stu_lname"]; ?>)</div>
    <div class="text-size">2.สำเนาบัตรประชาชน<?php //echo $row["recipient"]; ?></div>
    <div class="center"><img src="../refund/uploads/<?php //echo $row["id_card_pic"]; ?>" alt="" height="150" width="290"></div>
    <div class="text-size center">สำเนาถูกต้อง</div>
    <br>
    <div class="text-size width-sig">ลงชื่อ </div>
    <div class="text-size center">(<?php //echo trim($row["recipient_prefix"]) . $row["recipient_fname"] . " " . $row["recipient_lname"]; ?>)</div> -->
    <pagebreak></pagebreak>
    <table width="100%">
        <tr>
            <td class="text-right" colspan="2">
                <div>ลำดับที่.....................................................</div>
                <div>กรณีที่ได้รับสิทธิ์ (ค่าอุปกรณ์การเรียน)</div>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="2">
                <div>เอกสารหมายเลข 1</div>
                <strong>
                    <div>ใบสำคัญรับเงิน</div>
                </strong>
            </td>
        </tr>
        <tr>
            <td width="60%">
                <img class="img-center" src="img/doc-logo.gif" alt="" width="80" height="80">
            </td>
            <td class="text-right">
                <div>ชื่อสถานศึกษา วิทยาลัยเทคนิคชลบุรี</div>
                <div>วัน............เดือน........................พ.ศ.................</div>
            </td>
        </tr>
    </table>
    <!-- pull data -->
    <table width="100%">
        <tr>
            <td width="40%" class="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า (ผู้ปกครอง) (นาย/นาง/นางสาว)</td>
            <td class="dott">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["par_fname"] ." ". $row["par_lname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>อยู่บ้านเลขที่</td>
            <td class="dott"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["home_id"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>หมู่ที่ </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["moo"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td>ถนน </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["street"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td>ตำบล </td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["tumbol_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="12%">อำเภอ/เขต</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["amphure_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="8%">จังหวัด</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["province_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="12%">รหัสไปรษณีย์</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $row["post"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%">เป็นผู้ปกครองของนักเรียนชื่อ (นาย/นาง/นางสาว/ด.ช./ด.ญ.)</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="43%">หมายเลขประจำตัวประชาชนของนักเรียน(13 หลัก)</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["people_id"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="9%">ระดับชั้น</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["grade_name"] . "/" . ltrim($row["student_group_no"], '0'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="5%">ช่าง</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["major_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="19%">รหัสประจำตัวนักเรียน</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["student_id"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="10%">ภาคเรียนที่</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="11%">ปีการศึกษา</td>
            <td class="dott">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2565&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td colspan="2">
                <div>ขอรับสิทธิ์ค่าเครื่องแบบนักเรียนและค่าอุปกรณ์การเรียนตามโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษา</div>ตั้งแต่ระดับอนุบาลจนจบการศึกษาขั้นพื้นฐาน ดังนี้
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. ค่าเครื่องแบบนักเรียน ระดับชั้น <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> จำนวนเงิน <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>บาท</div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>2. ค่าอุปกรณ์การเรียน ระดับชั้น <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["grade_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> จำนวนเงิน <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;230.-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>บาท</strong></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">รวมเป็นจำนวนเงินทั้งสิ้น 230.- บาท (-สองร้อยสามสิบบาทถ้วน-)</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้รับเงิน</div>
                <div>(..........................................<?php //echo $row["par_fname"] ." ". $row["par_lname"]; ?>)</div>
                <div>ผู้ปกครอง/ผู้มอบอำนาจ</div>
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้รับเงิน</div>
                <div>(<?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>)</div>
                <div>นักเรียน/ผู้รับมอบอำนาจ</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>จ่ายเงินแล้ว</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ..........................................ผู้จ่ายเงิน</div>
                <div>(นางสาวราตรี ศรีเมือง)</div>
                <div>เจ้าหน้าที่การเงิน</div>
                <div>วันที่..........................................................</div>
            </td>
            <td width="50%" class="text-center">
                <div>&nbsp;</div>
                <div>ลงชื่อ.......................................................</div>
                <div>(นางกรรณิการ์ บำรุงญาติ)</div>
                <div>หัวหน้าการเงิน</div>
                <div>วันที่........................................................</div>
            </td>
        </tr>
    </table>

    <div><strong>หมายเหตุ</strong> : - สำเนาบัตรประจำตัวประชาชนผู้ปกครอง ลงชื่อรับรองเอกสาร</div>
    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- สำเนาบัตรประจำตัวประชาชนนักเรียน ลงชื่อรับรองเอกสาร</div>
    <pagebreak></pagebreak>
    <table width="100%">
        <tr>
            <td class="text-right">
                แบบ บก.111
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <div>ใบรับรองแทนใบเสร็จรับเงิน</div>
                <div>วิทยาลัยเทคนิคชลบุรี</div>
            </td>
        </tr>
    </table>
    <table width="100%" class="border-table">
        <tr>
            <td class="text-center">วัน เดือน ปี</td>
            <td class="text-center">รายละเอียดรายจ่าย</td>
            <td class="text-center">จำนวนเงิน</td>
            <td class="text-center">หมายเหตุ</td>
        </tr>
        <tr>
            <td></td>
            <td>ข้าพเจ้าได้ซื้ออุปกรณ์การเรียนประจำภาคเรียนที่ 2/2565 ดังนี้</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)ปากกาลูกลื่น................ด้าม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)ไม้บรรทัด................อัน ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)สมุดปกอ่อน................เล่ม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)สมุดปกแข็ง................เล่ม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)น้ำยาลบคำผิด................ด้าม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)ดินสอ................ด้าม ๆ ละ .............................บาท เป็นเงิน</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>(&nbsp;&nbsp;&nbsp;&nbsp;)อื่นๆ.............................................................................................</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">รวมทั้งสิ้น</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">ขอเบิกเพียง</td>
            <td class="text-center">230.-</td>
            <td></td>
        </tr>
    </table>
    <br>
    <table width="100%" class="text-22">
        <tr>
            <td colspan="4">
                <div>รวมทั้งสิ้น (ตัวอักษร)...............................................-สองร้อยสามสิบบาทถ้วน-................................................................</div>
            </td>
        </tr>
        <tr>
            <td class="text-left" width="14%">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า
            </td>
            <td class="dott">
                <?php echo $row["prefix_name"] . $row["stu_fname"] . "  " . $row["stu_lname"]; ?>
            </td>
            </td>
            <td width="10%">ตำแหน่ง</td>
            <td class="dott">
                นักเรียน
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div>สังกัดวิทยาลัยเทคนิคชลบุรี กองวิทยาลัยเทคนิคชลบุรี กรมอาชีวศึกษา กระทรวงศึกษาธิการ ขอรับรองว่า</div>
                <div>รายจ่ายข้างต้น ไม่อาจเรียกใบเสร็จรับเงินจากผู้รับเงินได้ และข้าพเจ้าได้จ่ายเงินไปในงานของราชการโดยแท้</div>
            </td>
        </tr>
        <tr>
            <td class="text-right" colspan="4"><br>ลงชื่อ.................................................นักเรียน</td>
        </tr>
        <tr>
            <td class="text-right" colspan="4"><br>ลงชื่อ..............................................ผู้ปกครอง</td>
        </tr>
    </table>
    <!-- <pagebreak></pagebreak>
    <h2 class="center">วิทยาลัยเทคนิคชลบุรี</h2>
    <div class="center text-size">หลักฐานการรับค่าอุปกรณ์การเรียนของนักเรียนระดับชั้น <?php echo $row["grade_name"]; ?> ภาคเรียนที่ 2 ปีการศึกษา 2565</div>
    <div class="text-size">1.สำเนาบัตรประชาชนของนักเรียน/นักศึกษา หมายเลขโทรศัพท์ <?php echo $row["phone"]; ?></div>
    <div class="text-size txt-right">ชั้น/ช่าง <?php echo $row["student_group_short_name"]; ?> รหัส <?php echo $row["student_id"]; ?></div>
    <div class="center"><img src="../refund/uploads/<?php echo $row["id_card_pic_std"]; ?>" alt="" height="150" width="290"></div>
    <div class="text-size center">สำเนาถูกต้อง</div>
    <br>
    <div class="text-size width-sig">ลงชื่อ</div>
    <div class="text-size center">(<?php echo $row["prefix_name"] . $row["stu_fname"] . " " . $row["stu_lname"]; ?>)</div>
    <div class="text-size">2.สำเนาบัตรประชาชน<?php echo $row["recipient"]; ?></div>
    <div class="center"><img src="../refund/uploads/<?php echo $row["id_card_pic"]; ?>" alt="" height="150" width="290"></div>
    <div class="text-size center">สำเนาถูกต้อง</div>
    <br>
    <div class="text-size width-sig">ลงชื่อ </div>
    <div class="text-size center">(<?php echo trim($row["recipient_prefix"]) . $row["recipient_fname"] . " " . $row["recipient_lname"]; ?>)</div> -->
</body>

</html>
<?php
$html = ob_get_contents();
// $mpdf->AddPage('L');
$mpdf->WriteHTML($html);
$taget = "pdf/report1.pdf";
$mpdf->Output($taget);
ob_end_flush();
echo "<script>window.location.href='$taget';</script>";
exit;
?>
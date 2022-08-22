<!DOCTYPE html>
<html lang="en">
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสรุปจำนวนนักเรียน ปวช.1 ในการกรอกข้อมูลบัตรประชาชน</title>
</head>

<body>
    <h5>รายงานสรุปจำนวนนักเรียน ปวช.1 ในการกรอกข้อมูลบัตรประชาชน</h5>
    <?php
    require_once "connect.php";
    $sql = "select * from student_group g 
    inner join enroll e on e.group_id = g.student_group_id
    where g.grade_name='ปวช.1'";
    $res = mysqli_query($conn, $sql);
    ?>
    <table>
        <thead>
            <tr>
                <td>ลำดับ</td>
                <td>ชื่อครูที่ปรึกษา</td>
                <td>จำนวนนักเรียนทั้งหมด</td>
                <td>ยังไม่ได้กรอกข้อมูล</td>
                <td>กรอกข้อมูลแล้วแต่ไม่สมบูรณ์</td>
                <td>กรอกข้อมูลเรียบร้อย</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?php echo countAll($g_id);?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>
<?php
function countAll($g_id)
{
    global $conn;
    $sql = "
        select *,count(student_id) as std_all from enroll 
        where group_id = '$g_id'
        ";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($res);
    return $row["std_all"];
}
?>
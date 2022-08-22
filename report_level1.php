<!DOCTYPE html>
<html lang="en">
<?php
require_once "setHead.php";
header('Content-Type: text/html; charset=UTF-8');

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสรุปจำนวนนักเรียน ปวช.1 ในการกรอกข้อมูลบัตรประชาชน</title>
</head>
<style>
    .bg-g{
        background-color: #a7a8a8;
    }
</style>
<body>
    <?php
    require_once "connect.php";
    $sql = "select * from student_group g
    inner join people p on p.people_id = g.teacher_id1
    where g.grade_name='ปวช.1' and g.student_group_year = '2565'";

    $res = mysqli_query($conn, $sql);
    ?>
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <h4>รายงานสรุปจำนวนนักเรียน ปวช.1 ในการกรอกข้อมูลบัตรประชาชน</h4>
                <table class="table bg-g" id="r_level1">
                    <thead>
                        <tr>
                            <td>ลำดับ</td>
                            <td>ชื่อครูที่ปรึกษา</td>
                            <td>ช่าง</td>
                            <td>จำนวนนักเรียนทั้งหมด</td>
                            <td class="text-warning">กรอกข้อมูลแล้วแต่ไม่สมบูรณ์</td>
                            <td class="text-success">กรอกข้อมูลเรียบร้อย</td>
                            <td class="text-danger">ยังไม่ได้กรอกข้อมูล</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            if (countAll($row["student_group_id"]) > 0) {
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row["people_name"] . " " . $row["people_surname"]; ?></td>
                                    <td><?php echo $row["student_group_short_name"]; ?></td>
                                    <td><?php echo $all = countAll($row["student_group_id"]); ?></td>
                                    <td class="text-warning"><?php echo $yn = countYes_nopass($row["student_group_id"]); ?></td>
                                    <td class="text-success"><?php echo $yp = countYes_pass($row["student_group_id"]); ?></td>
                                    <td class="text-danger"><?php echo $all-($yn+$yp); ?></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</body>

</html>
<?php
require_once "setFood.php";
function countAll($g_id)
{
    global $conn;
    $sql = "
        select count(student_id) as std_all from student 
        where group_id = '$g_id' and status = '0'
        ";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["std_all"];
}
function countNot($g_id)
{
    global $conn;
    $sql = "
        select count(e.student_id) as std_all from enroll e
        inner join documents d on d.student_id = e.student_id 
        where group_id = '$g_id' and d.status = '' 
        ";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["std_all"];
}
function countYes_nopass($g_id)
{
    global $conn;
    $sql = "
        select count(e.student_id) as std_all from enroll e
        inner join documents d on d.student_id = e.student_id  
        where group_id = '$g_id' and d.status = 'เอกสารไม่ถูกต้องสมบูรณ์' 
        ";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["std_all"];
}

function countYes_pass($g_id)
{
    global $conn;
    $sql = "
        select count(e.student_id) as std_all from enroll e
        inner join documents d on d.student_id = e.student_id  
        where group_id = '$g_id' and d.status = 'ส่งเอกสารแล้ว' 
        ";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    return $row["std_all"];
}
?>
<script>
    $(document).ready(function(){
        $("#r_level1").DataTable()
    })
</script>
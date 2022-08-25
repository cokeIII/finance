<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php";
require_once "connect.php";
error_reporting(0);
if (empty($_SESSION['people_id'])) {
    header("location: index.php");
}
$group_id = $_GET["group_id"];
$mode = $_GET["mode"];
$term = $_GET["term"];
?>
<style>

</style>

<body id="page-top" class="d-flex flex-column min-vh-100">
    <!-- Navigation-->
    <?php require_once "menu.php"; ?>
    <div class="masthead">
        <div class="container px-5">

            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h3>ตรวจสอบรายชื่อก่อนพิมพ์</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-primary"> *** หากไม่ต้องการรายชื่อใดให้ทำครื่องหมาย ✓ หลังรายชื่อ</pack>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary float-right"><a class="text-light" href="report.php">กลับไปเลือกห้องเรียน</a></button>
                            </div>
                        </div>
                        <table class="table" id="listName">
                            <thead>
                                <tr>
                                    <!-- <td>ลำดับที่</td> -->
                                    <td>รหัสนักเรียน</td>
                                    <td>ชื่อ - สกุล</td>
                                    <td>ทำเครื่องหมาย ✓ </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $sql = "select * from student s
                                inner join prefix p on s.perfix_id = p.prefix_id
                                left join student_group sg on s.group_id = sg.student_group_id
                                where sg.student_group_id = '$group_id'
                                and s.status = 0
                                ";
                                $res = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($res)) {
                                ?>
                                    <tr>
                                        <!-- <td><?php //echo ++$i; ?></td> -->
                                        <td><?php echo $row["student_id"]; ?></td>
                                        <td><?php echo $row["prefix_name"] . $row["stu_fname"] . " " . $row["stu_lname"]; ?></td>
                                        <td><input type="checkbox" name="listNot" class="listNot" value="<?php echo $row["student_id"]; ?>"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-md-4">
                            <button class="btn btn-primary printReport">พิมพ์</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
<?php require_once "setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#room").select2();
        $('#listName').DataTable()
        $(document).on('click', '.printReport', function() {
            let listNot = ""
            $("input:checkbox[name=listNot]:checked").each(function() {
                listNot+=("'"+$(this).val()+"',");
            });
            console.log(listNot.slice(0,-1))
            $.redirect("doc2.php", {
                group_id: '<?php echo $group_id; ?>',
                mode: '<?php echo $mode; ?>',
                term: '<?php echo $term; ?>',
                listNot: listNot.slice(0,-1),
            }, "GET", "_blank");
        })
    })
</script>
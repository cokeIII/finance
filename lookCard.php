<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php"; ?>
<style>

</style>

<body id="page-top">
    <!-- Navigation-->
    <?php require_once "menu.php"; ?>
    <div class="masthead">
        <div class="container px-5">
            <?php
            require_once "connect.php";
            $student_id = $_SESSION["student_id"];
            $sql = "select * from enroll where student_id = '$student_id'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($res);
            $numRow = mysqli_num_rows($res);
            ?>
            <div class="container">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>รายการที่เพิ่มข้อมูลล่าสุด</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($numRow > 0) { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>รหัสนักเรียน/นักศึกษา </strong><?php echo $row["student_id"]; ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>ชื่อนักเรียน/นักศึกษา </strong><?php echo $row["prefix_name"] . $row["stu_fname"] . " " . $row["stu_lname"]; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>ชื่อผู้ปกครอง </strong><?php echo $row["recipient_prefix"] . $row["recipient_fname"] . " " . $row["recipient_lname"]; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div><strong>รูปบัตรประชาชนนักเรียน</strong></div>
                                    <img src="../refund/uploads/<?php echo $row["id_card_pic_std"]; ?>" class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <div><strong>รูปบัตรประชาชนผู้ปกครอง</strong></div>
                                    <img src="../refund/uploads/<?php echo $row["id_card_pic"]; ?>" class="img-fluid">
                                </div>
                            </div>
                        <?php } else { ?>
                            <h3 class="text-center">ไม่พบข้อมูล</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
</body>
<?php require_once "setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {

    })
</script>
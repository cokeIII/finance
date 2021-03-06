<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php";
require_once "connect.php";
if (empty($_SESSION['people_id'])) {
    header("location: index.php");
} ?>
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
                        <h3>พิมพ์ใบสรุปรายห้อง</h3>
                        <div class="row">
                            <div class="col-md-5">
                                <input type="radio" name="mode" value="1" checked> : ค่าเครื่องแบบนักเรียน
                            </div>
                            <div>
                                <input type="radio" name="mode" value="2"> : ค่าอุปกรณ์การเรียน
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5">
                                <input type="radio" name="term" value="1" checked> : ภาคเรียนที่ 1
                            </div>
                            <div>
                                <input type="radio" name="term" value="2"> : ภาคเรียนที่ 2
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5">
                                <select class="form-control" id="room">
                                    <option value="">-- เลือกห้องเรียน --</option>
                                    <?php
                                    $sqlRoom = "select * from student_group where SUBSTR(student_group_id, 3, 1) = 2";
                                    $resRoom  = mysqli_query($conn, $sqlRoom);
                                    while ($rowRoom = mysqli_fetch_array($resRoom)) {
                                    ?>
                                        <option value="<?php echo $rowRoom["student_group_id"]; ?>"><?php echo "(" . $rowRoom["student_group_id"] . ") " . $rowRoom["student_group_short_name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary NextStep">ถัดไป</button>
                            </div>
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
        $(document).on('click', '.NextStep', function() {
            $.redirect("checkName.php", {
                group_id: $("#room").val(),
                mode: $("input[name=mode]:checked").val(),
                term: $("input[name=term]:checked").val(),
            }, "GET");
        })
    })
</script>
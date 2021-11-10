<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php";
require_once "connect.php";
if (empty($_SESSION['people_id'])) {
    header("location: index.php");
} ?>
<style>

</style>

<body id="page-top">
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
                                <select class="form-control" id="room">
                                    <option value="">-- เลือกห้องเรียน --</option>
                                    <?php
                                    $sqlRoom = "select * from student_group where level_name = 'ปวช.' group by student_group_short_name";
                                    $resRoom  = mysqli_query($conn, $sqlRoom);
                                    while ($rowRoom = mysqli_fetch_array($resRoom)) {
                                    ?>
                                        <option value="<?php echo $rowRoom["student_group_id"]; ?>"><?php echo $rowRoom["student_group_short_name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary printReport">พิมพ์</button>
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
        $(document).on('click', '.printReport', function() {
            $.redirect("doc2.php", {
                group_id: $("#room").val(),
            }, "GET", "_blank");
        })
    })
</script>
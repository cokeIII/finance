<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php"; ?>
<?php require_once "connect.php";
if (empty($_SESSION['people_id'])) {
    header("location: index.php");
} ?>

<body id="page-top" class="d-flex flex-column min-vh-100">
    <!-- Navigation-->
    <?php require_once "menu.php"; ?>
    <div class="masthead">
        <div class="container px-5">

            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <h4>เลือกห้องเรียน</h4>
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
                                <!-- <div class="col-md-4">
                                    <div class="row justify-content-end">
                                        <div class="col-md-12">
                                            <a href="form_stutus_std.php"><button class="btn btn-info mt-5" id="stdStatus"><i class="fas fa-user-edit"></i>พิมพ์ทั้งห้องที่เลือก</button></a>
                                        </div>
                                    </div>
                                </div> -->
                            </div>

                            <table class="table" id="enrollTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>ที่</th>
                                        <th>รหัสนักศึกษา</th>
                                        <th>ชื่อ - สกุล</th>
                                        <th>ช่าง</th>
                                        <th>สถานะ</th>
                                        <th>วันเวลา</th>
                                        <th></th>
                                        <th width="40"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <th>ที่</th>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ - สกุล</th>
                                    <th>ช่าง</th>
                                    <th>สถานะ</th>
                                    <th>วันเวลา</th>
                                    <th></th>
                                    <th></th>
                                </tfoot>
                            </table>

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
        loadTable("")
        $("#room").change(function() {
            loadTable($(this).val())
        })
        $(document).on('click', '.btnPrint', function() {
            let pages = "doc.php";
            $.ajax({
                type: "POST",
                url: "checkEnroll.php",
                data: {
                    check:true
                },
                success: function(result) {
                    console.log(result)
                    if (result > 0) {
                        pages = "doc3.php";
                    }
                    $.redirect(pages, {
                        id: $(this).attr("enrollId"),
                    }, "GET", "_blank");
                }
            });
            // let strStd = $(this).attr("enrollId").substring(0, 2);

        })
        $(document).on('change', '.status', function() {
            let std_id = $(this).attr("std_id")
            let val = $(this).val()
            $.ajax({
                type: "POST",
                url: "updateDoc.php",
                data: {
                    student_id: std_id,
                    update: val,
                },
                success: function(result) {
                    console.log(result)
                    if (result == "ok") {
                        loadTable($("#room").val())
                    } else if (result == "fail") {
                        alert("แก้ไขไม่สำเร็จ")
                    }
                }
            });
        })

        function loadTable(room_name) {
            $('#enrollTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "bDestroy": true,
                "responsive": true,
                "autoWidth": false,
                "pageLength": 30,
                "scrollX": true,
                "ajax": {
                    "url": "get_finance.php",
                    "type": "POST",
                    "data": function(d) {
                        d.room_name = room_name
                    }
                },
                'processing': true,
                "columns": [{
                        "data": "no"
                    },
                    {
                        "data": "student_id"
                    },
                    {
                        "data": "stu_name"
                    },
                    {
                        "data": "student_group_short_name"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "time_stamp"
                    },
                    {
                        "data": "select_status"
                    },
                    {
                        "data": "btn_print"
                    },
                ],
                "language": {
                    'processing': '<img src="img/tenor.gif" width="80">',
                    "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                    "zeroRecords": "ไม่มีข้อมูล",
                    "info": "กำลังแสดงข้อมูล _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "search": "ค้นหา:",
                    "infoEmpty": "ไม่มีข้อมูลแสดง",
                    "infoFiltered": "(ค้นหาจาก _MAX_ total records)",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "หน้าต่อไป",
                        "previous": "หน้าก่อน"
                    }
                }
            });
        }
    })
</script>
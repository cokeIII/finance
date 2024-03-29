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
                                        <th>note</th>
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
                                    <th>note</th>
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
<!-- Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteModalLabel">หมายเหตุ</h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="checkbox" name="note[]" id="noteCardStd" value="รูปภาพบัตรประชาชนนักเรียน"> : รูปภาพบัตรประชาชนนักเรียน นักศึกษาไม่สมบูรณ์
                </div>
                <hr>
                <div>
                    <input type="checkbox" name="note[]" id="noteCardPar" value="รูปภาพบัตรประชาชนผู้ปกครองไม่สมบูรณ์"> : รูปภาพบัตรประชาชนผู้ปกครองไม่สมบูรณ์
                </div>
                <hr>
                <div>
                    อื่นๆ :<textarea class="form-control" name="note[]" id="noteOther" rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-primary mt-3 btnAddNote">บันทึก</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.closeModal', function() {
            $('.modal').modal('hide');
        })
        $(document).on('click', '.btnAddNote', function() {
            let noteData = []
            $('input[name="note[]"]:checked').each(function() {
                noteData.push(this.value)
            });
            noteData.push($("#noteOther").val())
            $.ajax({
                type: 'POST',
                url: 'noteSQL.php',
                data: {
                    enrollId: $(this).attr("enrollId"),
                    note: noteData,
                    act: "insertNote",
                },
                dataType: 'json',
                success: function(data) {
                    if (data == "ok") {
                        $('.modal').modal('hide');
                    }
                }
            });
        })

        $(document).on('click', '.btnNote', function() {
            $(".btnAddNote").attr("enrollId", $(this).attr("enrollId"))
            $("#noteCardStd").attr('checked', false)
            $("#noteCardPar").attr('checked', false)
            $("#noteOther").html("")
            $.ajax({
                type: 'POST',
                url: 'noteSQL.php',
                data: {
                    enrollId: $(this).attr("enrollId"),
                    act: "getNote",
                },
                dataType: 'json',
                success: function(data) {
                    if (data.note) {
                        if (JSON.parse(data.note).length > 0) {
                            $.each(JSON.parse(data.note), function(index, element) {
                                console.log(element)
                                if (element == "รูปภาพบัตรประชาชนนักเรียน") {
                                    $("#noteCardStd").attr('checked', true)
                                }
                                if (element == "รูปภาพบัตรประชาชนผู้ปกครองไม่สมบูรณ์") {
                                    $("#noteCardPar").attr('checked', true)
                                } else {
                                    $("#noteOther").html(element)
                                }
                            });
                        }
                    } else {
                        $("#noteCardStd").attr('checked', false)
                        $("#noteCardPar").attr('checked', false)
                        $("#noteOther").html("")
                    }
                    $("#noteModal").modal('show')
                }
            });

        })
        $("#room").select2();
        loadTable("")
        $("#room").change(function() {
            loadTable($(this).val())
        })
        $(document).on('click', '.btnPrint', function() {
            let std_id = $(this).attr("enrollId")
            let pages = "doc.php";
            $.ajax({
                type: "POST",
                url: "checkEnroll.php",
                data: {
                    student_id: std_id
                },
                success: function(result) {
                    console.log(result)
                    if (result == "g") {
                        pages = "doc3.php";
                    }
                    $.redirect(pages, {
                        id: std_id,
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
                        "data": "note"
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
<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php"; ?>
<?php
if (empty($_SESSION['student_id'])) {
    header("location: index.php");
} ?>
<style>
    .kbw-signature {
        width: 400px;
        height: 200px;
    }

    #sig canvas {
        width: 100% !important;
        height: auto;
    }

    .image-previewer {
        height: 250px;
        width: 400px;
        display: flex;
        border-radius: 10px;
        border: 1px solid lightgrey;
    }

    .alert_pic {
        font-size: 16px;
        color: red;
    }
</style>

<body id="page-top">
    <!-- Navigation-->
    <?php require_once "menu.php"; ?>
    <div class="masthead">
        <div class="container px-5">
            <div class="card shadow">
                <div class="card-header">
                    <h3>เพิ่มข้อมูลบัตรประชาชน</h3>
                </div>
                <div class="card-body">
                    <form id="enrollData" action="insertEnroll.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $_SESSION["student_id"]; ?>">
                        <input type="hidden" name="prefix_name" value="<?php echo $_SESSION["prefix_name"]; ?>">
                        <input type="hidden" name="people_id" value="<?php echo $_SESSION["people_id"]; ?>">
                        <input type="hidden" name="stu_fname" value="<?php echo $_SESSION["stu_fname"]; ?>">
                        <input type="hidden" name="stu_lname" value="<?php echo $_SESSION["stu_lname"]; ?>">
                        <input type="hidden" name="group_id" value="<?php echo $_SESSION["group_id"]; ?>">
                        <input type="hidden" name="minor_name" value="<?php echo $_SESSION["minor_name"]; ?>">
                        <input type="hidden" name="grade_name" value="<?php echo $_SESSION["grade_name"]; ?>">
                        <input type="hidden" name="student_group_short_name" value="<?php echo $_SESSION["student_group_short_name"]; ?>">
                        <input type="hidden" id="id_card_pic_std_h" name="id_card_pic_std_h" value="">
                        <input type="hidden" id="id_card_pic_h" name="id_card_pic_h" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group p-1">
                                    <label>ชื่อ-สกุล</label>
                                    <input value="<?php echo $_SESSION["prefix_name"] . $_SESSION["stu_fname"] . " " . $_SESSION["stu_lname"]; ?>" type="text" name="stu_name" id="stu_name" class="form-control" required readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group p-1">
                                    <label>กลุ่ม</label>
                                    <input value="<?php echo $_SESSION["student_group_no"] ?>" type="text" name="student_group_no" id="student_group_no" class="form-control" required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group p-1">
                                    <label>แผนก</label>
                                    <input value="<?php echo $_SESSION["major_name"] ?>" type="text" name="major_name" id="major_name" class="form-control" required readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- <strong>ข้อมูลผู้รับเงิน</strong> -->
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-1">
                                    <label>เกี่ยวข้องเป็น</label>
                                    <div><input type="radio" id="recipient" name="recipient" value="ผู้ปกครอง" checked> ผู้ปกครอง </div>
                                    <div><input type="radio" name="recipient" value="บิดา"> บิดา</div>
                                    <div><input type="radio" name="recipient" value="มารดา"> มารดา</div>
                                </div>
                            </div>
                        </div> -->
                        <!-- <input type="hidden" name="recipient_prefix" id="recipient_prefix" required>
                        <input type="hidden" name="recipient_fname" id="recipient_fname" required>
                        <input type="hidden" name="recipient_lname" id="recipient_lname" required> -->
                        <div><strong>ชื่อ-สกุล ผู้ปกครอง</strong></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group p-1">
                                    <label>คำนำหน้า</label>
                                    <select name="recipient_prefix" class="form-control">
                                        <option value="นาย">นาย</option>
                                        <option value="นางสาว">นางสาว</option>
                                        <option value="นาง">นาง</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group p-1">
                                    <label>ชื่อ</label>
                                    <input type="text" name="recipient_fname" id="recipient_fname" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group p-1">
                                    <label>สกุล</label>
                                    <input type="text" name="recipient_lname" id="recipient_lname" class="form-control" required>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="form-group p-1">
                                    <label>แก้ไขข้อความที่พิมพ์ชื่อ<span class="re_status"></span>ผิด</label>
                                    <div><button type="button" id="btnChangeName" data-toggle="modal" data-target="#exampleModalName" class="btn btn-primary">แก้ไข</button></div>
                                </div>
                            </div> -->
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group p-1">
                                    <label>หมายเลขโทรศัพท์ (ผู้ปกครอง)</label>
                                    <input class="form-control" id="phone" name="phone" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="10" value="<?php echo (empty($_SESSION["par_tell"]) ? "" : $_SESSION["par_tell"]) ?>">
                                </div>
                            </div>
                        </div>
                        <!-- <strong>ข้อมูลการโอนเงิน</strong>
                        <?php
                        // require_once "connect.php";
                        // $sqlBank = "select * from bank";
                        // $resBank = mysqli_query($conn, $sqlBank);
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-1">
                                    <label>ธนาคาร</label>
                                    <select name="recipient_bank" id="recipient_bank" class="form-control" required>
                                        <option value="">---เลือกธนาคาร---</option>
                                        <?php //while ($rowBank = mysqli_fetch_array($resBank)) { 
                                        ?>
                                            <option value="<?php //echo $rowBank["bank_name"]; 
                                                            ?>"><?php //echo $rowBank["bank_name"]; 
                                                                ?></option>
                                        <?php //} 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-1">
                                    <label>เลขบัญชี<span class="re_status"></span></label>
                                    <input type="number" name="recipient_bank_number" id="recipient_bank_number" class="form-control" required>
                                </div>
                            </div>
                        </div> -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-1">
                                    <label><strong>รูปบัตรประชาชนนักเรียน/นักศึกษา</strong><a href="#" data-toggle="modal" data-target="#exampleModalCard"> ตัวอย่าง</a></label>
                                    <input type="file" name="id_card_pic_std" id="id_card_pic_std" class="form-control" accept="image/*" required>
                                </div>
                                <label for="id_card_pic_std" class="image-previewer" data-cropzee="id_card_pic_std"></label>
                                <button id="btn_id_card_pic_std" type="button" class="btn btn-secondary" onclick="set_id_card_pic_std(cropzeeGetImage('id_card_pic_std'))">ยืนยันรูปภาพ</button>
                                <div class="alert_pic" id="btn_id_card_pic_std_alert">กรุณากดปุ่มยืนยันรูปภาพ</div>
                                <label class="mt-2">วันหมดอายุที่ระบุในบัตรประชาชนนักเรียน/นักศึกษา</label>
                                <input type="date" name="exp_date_id_card_pic_std" id="exp_date_id_card_pic_std" class="form-control col-md-5" required>
                                <hr>
                                <div class="form-group p-1">
                                    <label><strong>รูปบัตรประชาชนผู้ปกครอง</strong><a href="#" data-toggle="modal" data-target="#exampleModalCard"> ตัวอย่าง</a></label>
                                    <input type="file" name="id_card_pic" id="id_card_pic" class="form-control" accept="image/*" required>
                                </div>
                                <label for="id_card_pic" class="image-previewer" data-cropzee="id_card_pic"></label>
                                <button id="btn_id_card_pic" type="button" class="btn btn-secondary" onclick="set_id_card_pic(cropzeeGetImage('id_card_pic'))">ยืนยันรูปภาพ</button>
                                <div class="alert_pic" id="btn_id_card_pic_alert">กรุณากดปุ่มยืนยันรูปภาพ</div>
                                <label class="mt-2">วันหมดอายุที่ระบุในบัตรประชาชนผู้ปกครอง</label>
                                <input type="date" name="exp_date_id_card_pic" id="exp_date_id_card_pic" class="form-control col-md-5" required>

                                <!-- <hr> -->
                                <!-- <div class="form-group p-1">
                                    <label><strong>รูปหน้าสมุดบัญชี</strong><a href="#" data-toggle="modal" data-target="#exampleModalAcc"> ตัวอย่าง</a></label>
                                    <input type="file" name="account_book_pic" id="account_book_pic" class="form-control" accept="image/*" required>
                                </div> -->
                                <!-- <label for="account_book_pic" class="image-previewer" data-cropzee="account_book_pic"></label>
                                <button id="btn_account_book_pic" type="button" class="btn btn-secondary" onclick="set_account_book_pic(cropzeeGetImage('account_book_pic'))">ยืนยันรูปภาพ</button>
                                <div class="alert_pic" id="btn_account_book_pic_alert">กรุณากดปุ่มยืนยันรูปภาพ</div> -->
                                <hr>
                            </div>
                        </div>

                        <!-- <div class="row mt-3">
                            <div class="d-flex justify-content-center text-center">
                                <div class="row">
                                    <div class="col-md-12">

                                        <label>ลายเซ็นนักเรียนนักศึกษา</label>
                                        <div id="signatureparent">
                                            <div id="signature"></div>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-secondary" id="clear" type="button">ลบลายเซ็น</button>
                                        </div>

                                        <div class="wrapper">
                                            <div id="sig"></div>
                                            <textarea id="signature64" name="signed" style="display: none" required></textarea>
                                        </div>
                                        <div class="mt-2">
                                            <button id="clear" type="button">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex justify-content-center text-center">
                                <div class="row">
                                    <div class="col-md-12">

                                        <label>ลายเซ็น<span class="re_status"></span></label>
                                        <div id="signatureparent2">
                                            <div id="signature2"></div>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-secondary" id="clear2" type="button">ลบลายเซ็น</button>
                                        </div>
                                        <div class="wrapper">
                                            <div id="sig2"></div>
                                            <textarea id="signature65" name="signed2" style="display: none" required></textarea>
                                        </div>
                                        <div class="mt-2">
                                            <button id="clear2" type="button">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="row mt-3">
                            <div class="d-flex justify-content-center text-center">
                                <button id="btnEnroll" class="btn btn-primary"><i class="fas fa-clipboard-list"></i> ลงทะเบียนรับเงิน</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require_once "setFoot.php"; ?>

</html>
<!-- Modal -->
<div class="modal fade" id="exampleModalCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ตัวอย่าง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="img/card.jpg" alt="" calss="img-ex" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // $("#signatureparent").jSignature({

    //     // line color
    //     color: "black",

    //     // line width
    //     lineWidth: 5,

    //     // width/height of signature pad
    //     width: 300,
    //     height: 200,

    //     // background color
    //     "background-color": "##AEB4B2"
    // });
    $("#btnEnroll").attr('disabled', true)
    // let signed = false
    // let signed2 = false
    // let signed2Load = false

    let btn_id_card_pic_std = true;
    let btn_id_card_pic = true;
    // let btn_account_book_pic = true;
    $("#btnEnroll").attr('disabled', true)

    // $(document).on('change', "#signatureparent", function() {
    //     signed = true
    //     if (signed && signed2 && !btn_id_card_pic_std && !btn_id_card_pic && !btn_account_book_pic) {
    //         $("#btnEnroll").attr('disabled', false)
    //     }
    //     $("#signed").val("image/svg+xml;base64," + $("#signatureparent").jSignature('getData', "image/svg+xml;base64")[1])
    //     $("#signed2").val("image/svg+xml;base64," + $("#signatureparent2").jSignature('getData', "image/svg+xml;base64")[1])

    // })

    // $(document).on('change', "#signatureparent2", function() {

    //     if (signed2Load) {
    //         signed2 = true
    //         if (signed && signed2 && !btn_id_card_pic_std && !btn_id_card_pic && !btn_account_book_pic) {
    //             $("#btnEnroll").attr('disabled', false)
    //         }
    //         $("#signed").val("image/svg+xml;base64," + $("#signatureparent").jSignature('getData', "image/svg+xml;base64")[1])
    //         $("#signed2").val("image/svg+xml;base64," + $("#signatureparent2").jSignature('getData', "image/svg+xml;base64")[1])

    //     }
    //     signed2Load = true
    // })
    // $("#clear").click(function() {
    //     $("#signatureparent").jSignature('reset')
    //     signed2 = false
    //     if (!signed || !signed2) {
    //         $("#btnEnroll").attr('disabled', true)
    //     }
    // })
    // $("#clear2").click(function() {
    //     $("#signatureparent2").jSignature('reset')
    //     signed2 = false
    //     if (!signed || !signed2) {
    //         $("#btnEnroll").attr('disabled', true)
    //     }
    // })
    // $("#signatureparent2").jSignature({
    //     // line color
    //     color: "black",

    //     // line width
    //     lineWidth: 5,

    //     // width/height of signature pad
    //     width: 300,
    //     height: 200,

    //     // background color
    //     "background-color": "##AEB4B2"


    // });

    // $(".re_status").html($("#recipient").val())

    $("#btn_id_card_pic_std_alert").show()
    $("#btn_id_card_pic_alert").show()
    // $("#btn_account_book_pic_alert").show()

    function set_id_card_pic_std(val) {

        btn_id_card_pic_std = !btn_id_card_pic_std;
        if (btn_id_card_pic_std) {
            $("#btn_id_card_pic_std").removeClass("btn-success");
            $("#btn_id_card_pic_std").addClass("btn-secondary");
            $("#btn_id_card_pic_std_alert").show()

        } else {
            $("#btn_id_card_pic_std").removeClass("btn-secondary");
            $("#btn_id_card_pic_std").addClass("btn-success");
            $("#btn_id_card_pic_std_alert").hide()
        }
        if (!btn_id_card_pic_std && !btn_id_card_pic) {
            $("#btnEnroll").attr('disabled', false)
        }
        if (val == "") {
            alert("เกิดข้อผิดพลาดในการตัดรูป กรุณาเลือกรูปใหม่")
        } else {
            $("#id_card_pic_std_h").val(val)
        }
    }

    function set_id_card_pic(val) {

        btn_id_card_pic = !btn_id_card_pic;
        if (btn_id_card_pic) {
            $("#btn_id_card_pic").removeClass("btn-success");
            $("#btn_id_card_pic").addClass("btn-secondary");
            $("#btn_id_card_pic_alert").show()
        } else {
            $("#btn_id_card_pic").removeClass("btn-secondary");
            $("#btn_id_card_pic").addClass("btn-success");
            $("#btn_id_card_pic_alert").hide()
        }
        if (!btn_id_card_pic_std && !btn_id_card_pic) {
            $("#btnEnroll").attr('disabled', false)
        }
        if (val == "") {
            alert("เกิดข้อผิดพลาดในการตัดรูป กรุณาเลือกรูปใหม่")
        } else {
            $("#id_card_pic_h").val(val)
        }
    }

    // function set_account_book_pic(val) {

    //     btn_account_book_pic = !btn_account_book_pic;
    //     if (btn_account_book_pic) {
    //         $("#btn_account_book_pic").removeClass("btn-success");
    //         $("#btn_account_book_pic").addClass("btn-secondary");
    //         $("#btn_account_book_pic_alert").show()
    //     } else {
    //         $("#btn_account_book_pic").removeClass("btn-secondary");
    //         $("#btn_account_book_pic").addClass("btn-success");
    //         $("#btn_account_book_pic_alert").hide()
    //     }
    //     if (signed && signed2 && !btn_id_card_pic_std && !btn_id_card_pic && !btn_account_book_pic) {
    //         $("#btnEnroll").attr('disabled', false)
    //     }
    //     if (val == "") {
    //         alert("เกิดข้อผิดพลาดในการตัดรูป กรุณาเลือกรูปใหม่")
    //     } else {
    //         $("#account_book_pic_h").val(val)
    //     }

    // }
    $(document).ready(function() {

        // $("#id_card_pic").click(function(e) {
        //     if (btn_id_card_pic_std) {
        //         // e.preventDefault();
        //         $("#btn_id_card_pic_std").focus()
        //         alert("กรุณากดยืนยันรูปบัตรประชาชนนักเรียน/นักศึกษา")
        //         return false
        //     } else {

        //     }
        // })
        // $("#account_book_pic").click(function(e) {
        //     if (btn_id_card_pic_std) {
        //         // e.preventDefault();
        //         $("#btn_id_card_pic_std").focus()
        //         alert("กรุณากดยืนยันรูปบัตรประชาชนนักเรียน/นักศึกษา")
        //         return false
        //     }

        //     if (btn_id_card_pic) {
        //         // e.preventDefault();
        //         $("#btn_id_card_pic").focus()
        //         alert("กรุณากดยืนยันรูปบัตรประชาชนผู้ปกครอง")
        //         return false
        //     } else {
        //         return true
        //     }
        // })
        let statusRecipient = "ผู้ปกครอง"

        // $("#submitChangeName").click(function() {
        //     if ($("#NewPrefixName").val() == "") {
        //         return alert("กรุณากรอกคำนำหน้าชื่อ")
        //     }
        //     if ($("#NewFName").val() == "") {
        //         return alert("กรุณากรอกชื่อ")
        //     }
        //     if ($("#tel").val() == "") {
        //         return alert("กรุณากรอกนามสกุล")
        //     }
        //     if ($("#tel").val() == "") {
        //         return alert("กรุณากรอกเบอร์โทรศัพท์")
        //     }
        //     if (confirm("ยืนยัน คำนำหน้า ชื่อ สกุล ถูกต้อง")) {
        //         $.ajax({
        //             type: "POST",
        //             url: "change_name.php",
        //             data: {
        //                 student_id: $("#student_id").val(),
        //                 th_prefix_old: $("#recipient_prefix").val(),
        //                 th_name_old: $("#recipient_fname").val(),
        //                 th_lname_old: $("#recipient_lname").val(),
        //                 th_prefix_new: $("#NewPrefixName").val(),
        //                 th_name_new: $("#NewFName").val(),
        //                 th_lname_new: $("#NewLName").val(),
        //                 status: statusRecipient,
        //                 tel: $("#tel").val(),
        //             },
        //             success: function(result) {
        //                 console.log(result)
        //                 if (result == "true") {
        //                     alert("ส่งข้อมูลเรียบร้อย กรุณารอ 1 วันเพื่อตรวจสอบ");
        //                 } else {
        //                     alert("ส่งข้อมูลซ้ำไม่ได้");
        //                 }
        //             }
        //         });
        //     }
        // })

        // $("#btnChangeName").click(function() {
        //     $("#OldName").val($("#recipient_name").val())
        //     // $("#NewPrefixName").val($("#recipient_prefix").val())
        //     // $("#NewFName").val($("#recipient_fname").val())
        //     // $("#NewLName").val($("#recipient_lname").val())
        // })

        // $('input[type=radio][name=recipient]').change(function() {
        //     let status = $(this).val()
        //     statusRecipient = $(this).val()
        //     get_recipient(status)
        //     $(".re_status").html(status)
        // })

        $("#id_card_pic_std").cropzee({
            returnImageMode: 'data-url',
            startSize: [60, 60, '%']
        })
        $("#id_card_pic").cropzee({
            returnImageMode: 'data-url',
            startSize: [60, 60, '%']
        })
        // $("#account_book_pic").cropzee({
        //     returnImageMode: 'data-url',
        //     startSize: [60, 60, '%']
        // })

        // get_recipient("ผู้ปกครอง")

        // $("#recipient").change(function() {
        //     let status = $("#recipient").val()
        //     get_recipient(status)
        //     $(".re_status").html(status)
        // })
    })

    // function get_recipient(status) {
    //     $.ajax({
    //         type: "POST",
    //         url: "get_recipient.php",
    //         data: {
    //             student_id: "<?php //echo $_SESSION["student_id"]; 
                                ?>",
    //             get_status: status,
    //         },
    //         success: function(result) {
    //             if (result) {
    //                 console.log(result)
    //                 let obj = JSON.parse(result)
    //                 $("#recipient_prefix").val(obj.prefix_name)
    //                 $("#recipient_fname").val(obj.recipient_fname)
    //                 $("#recipient_lname").val(obj.recipient_lname)
    //                 if (obj.recipient_fname != "") {
    //                     $("#recipient_name").val(obj.prefix_name + obj.recipient_fname + " " + obj.recipient_lname)
    //                 } else {
    //                     $("#recipient_name").val("")
    //                 }
    //             }
    //         }
    //     });
    // }
</script>
<?php
require_once "connect.php";

function calAge($birthday)
{
    $birthDate = explode("/", $birthday);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2] - 543))) > date("md")
        ? ((date("Y") - ($birthDate[2] - 543)) - 1)
        : (date("Y") - ($birthDate[2] - 543)));
    $groupAge = "";
    if ($age >= 12 && $age <= 17) {
        $groupAge = "12-18";
    } else if ($age >= 18) {
        $groupAge = "18";
    } else if ($age < 12) {
        $groupAge = "<12";
    }
    return  $groupAge;
}

function calAgeNumber($birthday)
{
    $birthDate = explode("/", $birthday);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2] - 543))) > date("md")
        ? ((date("Y") - ($birthDate[2] - 543)) - 1)
        : (date("Y") - ($birthDate[2] - 543)));
    return  $age;
}

function calAgeV2($birthday)
{
    $birthDate = explode("/", $birthday);
    $bDate = $birthDate[0] . "-" . $birthDate[1] . "-" . ($birthDate[2] - 543);
    $today = date("Y-m-d");
    // Calculate the time difference between the two dates
    $diff = date_diff(date_create($bDate), date_create($today));
    // Get the age in years, months and days
    return [$diff->format('%y'), $diff->format('%m'), $diff->format('%d')];
}
function calAgeV3($birthday)
{
    $birthDate = explode("/", $birthday);
    $bDate = $birthDate[0] . "-" . $birthDate[1] . "-" . ($birthDate[2] - 543);
    $today = date("Y-m-d");
    // Calculate the time difference between the two dates
    $diff = date_diff(date_create($bDate), date_create($today));
    // Get the age in years, months and days
    if ($diff->format('%y') >= 18) {
        return  "18";
    } else {
        return "12-18";
    }
}
function checkStd($student_id)
{
    global $conn;
    $sqlCheck = "select count(student_id) as cStd from students where student_id = '$student_id'";
    $resCheck = mysqli_query($conn, $sqlCheck);
    $rowCheck = mysqli_fetch_array($resCheck);
    if ($rowCheck["cStd"] <= 0) {
        $sql = "select 
        student_id,
        perfix_id,
        stu_fname,
        stu_lname,
        birthday,
        gender_id,
        major_id,
        group_id,
        home_id,
        moo,
        street,
        tumbol_id,
        people_id
        from student 
        where status = 0 and group_id != '632090103' and group_id !='632090104'
        and group_id not LIKE '62202%' and student_id = '$student_id'
        ";
        $res = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_array($res)) {
            $student_id = $row["student_id"];
            $perfix_id = $row["perfix_id"];
            $stu_fname = $row["stu_fname"];
            $stu_lname = $row["stu_lname"];
            $gender_id = $row["gender_id"];
            $birthday = $row["birthday"];
            $major_id = $row["major_id"];
            $group_id = $row["group_id"];
            $group_age = calAgeV3($row["birthday"]);
            $home_id = $row["home_id"];
            $moo = $row["moo"];
            $street = $row["street"];
            $tumbol_id = $row["tumbol_id"];
            // $id_card_pic = $row["id_card_pic"];
            $people_id = $row["people_id"];
            // $phone = $row["phone"];
            // $sqlGetStd = "select cout(student_id) as stdCount from students where student_id = '$student_id'";
            // $resGetStd = mysqli_query($conn,$sqlStd);
            // $rowGetStd = mysqli_fetch_array($resGetStd);
            // if($rowGetStd[""]){
            $sqlStd = "replace into students (
                student_id,
                prefix_id,
                stu_fname,
                stu_lname,
                birthday,
                gender_id,
                major_id,
                group_id,
                group_age,
                home_id,
                moo,
                street,
                tumbol_id,
                people_id
                ) value (
                    '$student_id',
                    '$perfix_id',
                    '$stu_fname',
                    '$stu_lname',
                    '$birthday',
                    '$gender_id',
                    '$major_id',
                    '$group_id',
                    '$group_age',
                    '$home_id',
                    '$moo',
                    '$street',
                    '$tumbol_id',
                    '$people_id'
                )";

            $resStd = mysqli_query($conn, $sqlStd);
            if ($resStd) {
                return true;
            } else {
                return false;
            }
        }
    }
    return true;
}
function cVideo($student_id)
{
    global $conn;
    $sql = "select * from video where student_id = '$student_id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    if ($row["video_1"] == 1 && $row["video_2"] == 1 && $row["video_3"] == 1 && $row["video_4"] == 1) {
        return 1;
    }
    return 0;
}

function insertVideo($student_id)
{
    global $conn;
    $sqlCount = "select count(student_id) as stdCount from video where student_id = '$student_id'";
    $resCount = mysqli_query($conn, $sqlCount);
    $rowCount = mysqli_fetch_array($resCount);
    if ($rowCount["stdCount"] <= 0) {
        $sql = "insert into video (
        student_id,
        video_1,
        video_2,
        video_3,
        video_4) values(
            '$student_id',
            '0',
            '0',
            '0',
            '0'
        )";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }
    return false;
}

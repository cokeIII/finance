<!DOCTYPE html>
<html lang="en">
<?php require_once "setHead.php"; ?>
<?php
$textErr = "";
require_once "setHead.php";
if (!empty($_REQUEST["textErr"])) {
    $textErr = $_REQUEST["textErr"];
}
?>
<style>
    .text-err{
        color:red;
    }
</style>

<body id="page-top">
    <!-- Navigation-->
    <?php require_once "menu.php"; ?>
    <div class="masthead">
        <div class="container px-5">

            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-err h3"><?php echo $textErr; ?></div>
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

    })
</script>
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
    <div class="container px-5">
        <a class="navbar-brand fw-bold" href="#">
            <div>ระบบพิมพ์เอกสารโครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษา</div>ตั้งแต่ระดับอนุบาลจนจบการศึกษา
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            เมนู
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                <?php if (!empty($_SESSION["user_status"])) { ?>
                    <?php if ($_SESSION["user_status"] == "finance") { ?>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="listDoc.php"><i class="fas fa-list-alt"></i> พิมพ์ใบสำคัญรับเงิน</a></li>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="report.php"><i class="fas fa-list"></i> พิมพ์ใบสรุป</a></li>
                    <?php } else if ($_SESSION["user_status"] == "student") { ?>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="insertCard.php"><i class="fas fa-address-card"></i> เพิ่มข้อมูล</a></li>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="lookCard.php"><i class="fas fa-list-alt"></i> รายการที่เพิ่ม</a></li>
                    <?php } ?>
                    <li class="nav-item"><a href="logout.php"><button class="btn btn-primary rounded-pill">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="">ออกจากระบบ</span>
                            </button></a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="index.php"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
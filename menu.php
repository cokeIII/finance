<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
    <div class="container px-5">
        <a class="navbar-brand fw-bold" href="#">
            <div>ระบบขอรับสิทธิ์โครงการสนับสนุนค่าใช้จ่ายในการจัดการศึกษา</div>ตั้งแต่ระดับอนุบาลจนจบการศึกษา
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            เมนู
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                <?php if (!empty($_SESSION["user_status"])) { ?>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="form_report.php"><i class="fas fa-list-alt"></i> พิมพ์รายงาน</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="sum_everyday.php"><i class="fas fa-list"></i> รายงานสรุป</a></li>
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
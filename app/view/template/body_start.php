    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar sidebar.php -->
            <?php

use function TPPA\CORE\basic\pr;

 include 'sidebar.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content" <?= (strpos(__DIR__, 'PRODUCAO') === false) ? 'style="background-color:#070a474d;"' : '' ?>>
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top shadow">
                        <button id="backLink" class="btn-sm btn-primary btn-circle"><i class="fas fa-arrow-left"></i></button>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= empty($this->title) ? "TPPA" : $this->title ?></span>

                        <div class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['login'])) : ?>
                        <?php if(isset($_SESSION['user'])) : ?>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['user']['nome']; ?></span>
                        <?php endif; ?>    
                        <a class="btn btn-success" href="<?= $this->action("Session", "logout"); ?>" title=<?=key($_SESSION['login']);?> >
                            <i class="fas fa-user-lock"></i>
                        </a>   
                    <?php else : ?>
                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?= $this->action("Session", "login"); ?>" method="post">
                            <div class="input-group">
                                <input type="text" name="login" required="required" class="form-control bg-light border-0 small" placeholder="LOGIN CRCEA-SE" aria-label="Search" aria-describedby="basic-addon2">
                                <input type="password" name="password" required="required" class="form-control bg-light border-0 small" placeholder="SENHA" aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-user-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </form>                        
                    <?php endif; ?>
                        </div>
                    </nav>
                    <!-- End of Topbar -->
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
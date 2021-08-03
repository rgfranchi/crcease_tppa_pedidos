    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar sidebar.php -->
            <?php include 'sidebar.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top shadow">
                        <button id="backLink" class="btn-sm btn-primary btn-circle"><i class="fas fa-arrow-left"></i></button>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= empty($this->title) ? "TPPA" : $this->title ?></span>
                    </nav>
                    <!-- End of Topbar -->
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
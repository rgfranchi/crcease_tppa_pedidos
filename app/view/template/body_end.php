                    </div>
                    <!-- End of Page Content /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; CRCEA-SE TPPA</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                    </div>
                    <!-- End of Content Wrapper -->

                    </div>
                    <!-- End of Page Wrapper -->

                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>

                    <!-- Bootstrap core JavaScript-->
                    <script src="app/view/template/vendor/jquery/jquery.min.js"></script>
                    <script src="app/view/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                    <!-- Core plugin JavaScript-->
                    <script src="app/view/template/vendor/jquery-easing/jquery.easing.min.js"></script>

                    <!-- Custom scripts for all pages-->
                    <script src="app/view/template/js/sb-admin-2.min.js"></script>
                    <!-- Script para a aplicação -->
                    <script src="app/view/template/js/tppa.js"></script>

                    <!-- Page level plugins -->
                    <script src="app/view/template/vendor/chart.js/Chart.min.js"></script>

                    <!-- Mascara -->
                    <script src="app/view/template/vendor/jquery-inputmask/jquery.inputmask.min.js"></script>
                    <!-- <script src="view/template/vendor/jquery-inputmask/bindings/inputmask.binding.js"></script> -->

                    <!-- Page level custom scripts -->
                    <!-- <script src="view/template/js/demo/chart-area-demo.js"></script>
                            <script src="view/template/js/demo/chart-pie-demo.js"></script> -->

                    <?php
                    if (!empty($this->template_js)) {
                        $arr = array();
                        $arr = is_array($this->template_js) ? $this->template_js : array($this->template_js);
                        
                        foreach ($arr as $value) {
                            printf('<script src="app/view/template/js/%s.js"></script>', $value);
                        }
                    }
                    ?>

                    </body>

                    </html>
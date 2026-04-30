    <?php
    include __DIR__ . '/../../config.php';
    ?>
    <!doctype html>

    <html lang="en" class="layout-wide customizer-hide" data-assets-path="../../assets/"
        data-template="vertical-menu-template-free">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="robots" content="noindex, nofollow" />

        <title>Demo: Login Basic - Pages | Materio - Bootstrap Dashboard FREE</title>

        <meta name="description" content="" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="../../assets/vendor/fonts/iconify-icons.css" />

        <!-- Core CSS -->
        <!-- build:css assets/vendor/css/theme.css -->

        <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

        <link rel="stylesheet" href="../../assets/vendor/css/core.css" />
        <link rel="stylesheet" href="../../assets/css/demo.css" />

        <!-- Vendors CSS -->

        <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <!-- endbuild -->

        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

        <!-- Helpers -->
        <script src="../../assets/vendor/js/helpers.js"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

        <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

        <script src="../../assets/js/config.js"></script>
    </head>

    <body>
        <!-- Content -->
        <div class="position-relative">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-6 mx-4">
                    <!-- Login -->
                    <div class="card p-sm-7 p-2">
                        <div class="card-body mt-1">
                            <h4 class="mb-1">Welcome to Library Management System! 👋🏻</h4>
                            <p class="mb-5">Please sign-up your account and start the adventure</p>

                            <form id="formAuthentication" class="mb-5" action="<?= url('services/auth_create.php') ?>"
                                method="POST">
                                <div class="form-floating form-floating-outline mb-5 form-control-validation">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter your username" autofocus />
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating form-floating-outline mb-5 form-control-validation">
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter your email" autofocus />
                                    <label for="email">Email</label>
                                </div>
                                    <div class="mb-5">
                                        <div class="form-password-toggle form-control-validation">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="password" class="form-control" name="password"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="password" />
                                                    <label for="password">Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <button class="btn btn-primary d-grid w-100" type="submit">Sign-up</button>
                                    </div>
                                </form>

                                            <p class="text-center mb-5">
                                <span>Already have an account?</span>
                                <a href="login.php">
                                <span>Login Now</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Login -->
                </div>
            </div>
        </div>

        <!-- / Content -->


        <!-- Core JS -->

        <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

        <script src="../../assets/vendor/libs/popper/popper.js"></script>
        <script src="../../assets/vendor/js/bootstrap.js"></script>
        <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>

        <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="../../assets/vendor/js/menu.js"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->

        <!-- Main JS -->

        <script src="../../assets/js/main.js"></script>

        <!-- Page JS -->

        <!-- Place this tag before closing body tag for github widget button. -->
        <script async="async" defer="defer" src="https://buttons.github.io/buttons.js"></script>
    </body>
    <footer>
        include
    </footer>

    </html>
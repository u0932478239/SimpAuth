<?php
//
//    include '../includes/settings.php';
//    error_reporting(0);
//    
//    $isConnected = 0;
//    if (!isset($_SESSION))
//    {
//        session_start();
//    }
//    
//    if (isset($_SESSION['username']))
//    {
//        $isConnected = 1;
//    }
//    
//
//
?>

<html lang="en">
    <style>
        html {
          scroll-behavior: smooth;
        }
        </style>
    <head>
        <title>SimpAuth - A Free .NET Licensing Solution</title>        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="SimpAuth - A Free .NET Licensing Solution">
	<meta name="description" content="A Free and Opensource Licensing System for .NET">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://simpauth.xyz">
	<meta property="og:title" content="SimpAuth - A Free .NET Licensing Solution">
	<meta property="og:description" content="A Free and Opensource Licensing System for .NET">
	<meta property="og:image" content="https://cdn.discordapp.com/attachments/725094855185006612/771882879344181268/SimpAuth.png">
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="https://simpauth.xyz">
	<meta property="twitter:title" content="SimpAuth - A Free .NET Licensing Solution">
	<meta property="twitter:description" content="A Free and Opensource Licensing System for .NET">
	<meta property="twitter:image" content="https://cdn.discordapp.com/attachments/725094855185006612/771882879344181268/SimpAuth.png">
    <link rel="icon" type="image/x-icon" href="https://simpauth.xyz/favcon.png"/>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/fontawesome.min.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
        <link rel="stylesheet" href="assets/css/nice-select.css">
        <link rel="stylesheet" href="assets/css/odometer.min.css">
        <link rel="stylesheet" href="assets/css/meanmenu.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/progressbar.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        <script src="https://kit.fontawesome.com/fe49a7dc3e.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    </head>

    <body>

        <div class="navbar-area">
            <div class="labto-mobile-nav">
                <div class="logo">
                    <a href="index.php"><img width="128px"src="https://cdn.discordapp.com/attachments/725094855185006612/771882879344181268/SimpAuth.png" alt="logo"></a>
                </div>
            </div>

            <div class="labto-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="index.php"><img width="128px" src="https://cdn.discordapp.com/attachments/725094855185006612/771882879344181268/SimpAuth.png" alt="logo"></a>

                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav">

                                <li class="nav-item"><a href="#principal" class="nav-link">Home</a></li>
                                <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
                                <li class="nav-item"><a href="https://github.com/YungSamzy/SimpAuth" target="_blank" class="nav-link">GitHub</a></li>
                                <li class="nav-item"><a href="../tos.php" class="nav-link">Terms</a></li>
                        

                                <!-- <li class="nav-item"><a href="#" class="nav-link">Services <i class="fas fa-chevron-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a href="services-1.html" class="nav-link">Services Style 1</a></li>

                                        <li class="nav-item"><a href="services-2.html" class="nav-link">Services Style 2</a></li>

                                        <li class="nav-item"><a href="single-services.html" class="nav-link">Services Details</a></li>
                                    </ul>
                                </li> -->

                              
                            </ul>

                            <div class="others-options">
                                <!-- <div class="languages-list">
                                    <select>
                                        <option value="1">En</option>
                                        <option value="2">Ge</option>
                                        <option value="3">Spa</option>
                                    </select>
                                </div> -->


                                <?php
                                    if ($isConnected)
                                    {
                                        echo '<a href="../account/login.php" class="btn btn-secondary"> Dashboard | <i class="fas fa-sign-in-alt"></i></a>';
                                    }
                                    else
                                    {
                                        echo '<a href="../account/login.php" class="btn btn-secondary"> Sign In | <i class="fas fa-sign-in-alt"></i></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Navbar Area -->

        <!-- Start Main Banner Area -->
        <div class="main-banner" id="principal">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="main-banner-content">
                            <span>Documentation: <a style="color: aquamarine;" href="https://docs.simpauth.xyz" target="_blank">docs.simpauth.xyz</a></span>
                            <h1>A Free .NET Licensing Solution</h1>
                            <p>A Free and Opensource Licensing System for .NET</p>

                            <a href="../account/register.php" class="btn btn-primary">Get started</a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="banner-image">
                            <img src="assets/img/back.png" alt="image">
                            <img src="assets/img/bg-shape2.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="shape-img1 rotateme"><img src="assets/img/shape-image/1.png" alt="image"></div>
            <div class="shape-img2"><img src="assets/img/shape-image/2.png" alt="image"></div>
            <div class="shape-img3 rotateme"><img src="assets/img/shape-image/3.png" alt="image"></div>
            <div class="shape-img4"><img src="assets/img/shape-image/4.png" alt="image"></div>
            <div class="shape-img5"><img src="assets/img/shape-image/5.png" alt="image"></div>
            <div class="shape-img6"><img src="assets/img/shape-image/6.png" alt="image"></div>
            <div class="shape-img7"><img src="assets/img/shape-image/7.png" alt="image"></div>
            <div class="shape-img8"><img src="assets/img/shape-image/8.png" alt="image"></div>
        </div>
        <!-- End Main Banner Area -->

    
        
        <!-- Start Services Area -->
        <section class="services-area ptb-120 pt-0" id="features">
            <div class="container">
                <div class="section-title">
                    <span>Features</span>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-services-box">
                            <h3>Secure</h3>
                            <p>We work hard to make our system as secure as possible and keep your product out of the hands of hackers.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-services-box">
                            <h3>Easy to Use</h3>
                            <p>Although we do everything for you, you still have full control, you can create, delete, edit variables, users and much more in one click from the control panel.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-services-box">
                            <h3>Easy to Integrate</h3>
                            <p>It will take you less than 2 minutes to integrate our system to your program and be able to manage your licenses, easy, don't you think?</p>
                            <a href="https://docs.simpauth.xyz" target="_blank" class="learn-more-btn"> Documentation<i class="flaticon-arrow-pointing-to-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-services-box">
                            <h3>Cloud Based</h3>
                            <p>Your data and your clients data are very well stored in our servers, encrypted and safely stored to keep it away from possible hackers.</p>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-services-box">

                            <h3>Opensourced</h3>
                            <p>SimpAuth is opensourced. Meaning that anyone can take a look at how we work.  <a style="color: aquamarine;" href="https://github.com/YungSamzy/SimpAuth" target="_blank">GitHub</a></p>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-services-box">

                            <h3>API RESTful</h3>
                            <p>We have multiple APIs so you can control your application from outside the panel in a safe and simple way, documentation: <a style="color: aquamarine;" href="https://docs.simpauth.xyz" target="_blank">Documentation</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </br>
    </br>
    </br>
    </br>    
    </br>
    </br>
<?php
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
?>


        <footer class="footer-area">
            <div class="container">
                

                <div class="copyright-area">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <p><a href="https://simpauth.xyz" target="_blank">SimpAuth | <small>© Simp</small></a></p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <ul>
                                <li><a href="https://github.com/YungSamzy" target="_blank"><i class="fab fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.meanmenu.js"></script>
        <script src="assets/js/jquery.appear.js"></script>
        <script src="assets/js/odometer.min.js"></script>
        <script src="assets/js/jquery.magnific-popup.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/jquery.nice-select.min.js"></script>
        <script src="assets/js/progressbar.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.ajaxchimp.min.js"></script>
        <script src="assets/js/form-validator.min.js"></script>
        <script src="assets/js/contact-form-script.js"></script>
        <script src="assets/js/labto-map.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>
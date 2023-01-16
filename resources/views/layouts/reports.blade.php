<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Heinz RMS</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="Marvalinks web and mobile development packages are well designed to grow businesses and startups through the digital world.. Learn more about Marvalinks packages.">
    <meta name="author" content="Marvalinks">
    <meta name="csrf-token" content="uoxdXTzV8LDqwslOFeTbpUH2ufV42MWEN082vhX2">
    <meta name="section" content="business" />
    <meta name="THUMBNAIL_URL" content="" />
    <meta name="keywords" content="Mobile, Website, Enterprise, Developers, Accra, Startup, Hosting, Ghana, Software, Designs, Business" />
    <meta name="description" content="Marvalinks web and mobile development packages are well designed to grow businesses and startups through the digital world.. Learn more about Marvalinks packages." />
    <meta name="author" content="MARVALINKS" />
    <meta name="copyright" content="Marvalinks" />
    <meta name="title" content="Marvalinks" />
    <meta name="headline" content="Get a professional responsive business website that meets your business requirements." />
    <meta property="og:site_name" content="www.marvalinks.com" />
    <meta property="og:image" content="/images/logo/marvalinks-s1.png" />
    <meta property="og:title" content="Marvalinks" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.marvalinks.com" />
    <meta property="og:description" content="Marvalinks web and mobile development packages are well designed to grow businesses and startups through the digital world.. Learn more about Marvalinks packages." />
    <meta name="rating" content="general" />
    <meta name="generator" content="MARVALINKS" />
    <meta name="robots" content="index" />
    <meta http-equiv="content-language" content="en" />
    <meta name="distribution" content="global" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- <meta http-equiv="expires" content="3600"> -->
    <!-- <meta http-equiv="refresh" content="900" /> -->
    <meta http-equiv="cache-control" content="public">
    <meta http-equiv="pragma" content="public">

    <!-- Favicons-->
    <link rel="icon" href="/img/logo/marvalinks-favicon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/logo/marvalinks-favicon.png">

    <!--Summer Note CSS -->
    <link rel="stylesheet" href="/backend/plugins/summernote/summernote-bs4.css">
    <link href="/backend/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    <link href="/backend/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    @yield('styles')

    <!-- App css -->
    <link href="/backend/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/backend/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="/backend/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/backend/css/override.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <div id="marvalinks">

      <div class="header-bg">
          <!-- Navigation Bar-->
          <header id="topnav">
              <div class="topbar-main">
                  <div class="container-fluid">

                      <!-- Logo container-->
                      <div class="logo">
                          <!-- Text Logo -->
                          <a href="{{route('home')}}" class="logo">

                            heinz rms
                          </a>
                      </div>
                      <!-- End Logo container-->

                      <div class="menu-extras topbar-custom">

                          <ul class="list-inline float-right mb-0">
                              <!-- User-->
                              <li class="list-inline-item dropdown notification-list">
                                  <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="email-compose.html#" role="button" aria-haspopup="false" aria-expanded="false">
                                      <img src="/backend/images/users/boy.png" alt="user" class="rounded-circle">
                                      <span class="ml-1">{{auth()->user()->name}} <i class="mdi mdi-chevron-down"></i> </span>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                      <!-- <a class="dropdown-item" href="#"><i class="dripicons-user text-muted"></i> Profile</a> -->
                                      <!-- <a class="dropdown-item" href="#"><i class="dripicons-gear text-muted"></i> Settings</a> -->
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted"></i> Logout</a>
                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                         @csrf
                                     </form>
                                  </div>
                              </li>
                              <li class="menu-item list-inline-item">
                                  <!-- Mobile menu toggle-->
                                  <a class="navbar-toggle nav-link">
                                      <div class="lines">
                                          <span></span>
                                          <span></span>
                                          <span></span>
                                      </div>
                                  </a>
                                  <!-- End mobile menu toggle-->
                              </li>

                          </ul>
                      </div>
                      <!-- end menu-extras -->

                      <div class="clearfix"></div>

                  </div>
                  <!-- end container -->
              </div>
              <!-- end topbar-main -->

              <!-- MENU Start -->



              <!-- end navbar-custom -->
          </header>
          <!-- End Navigation Bar-->
      </div>

      <div class="wrapper">
          <div class="container-fluid pl0">

              <div class="row">
                  <div class="col-12">

                      <!-- Right Sidebar -->
                      <div class="email-rightbar">
                        @yield('content')

                      </div>
                      <!-- end Col-9 -->

                  </div>

              </div>
              <!-- End row -->
          </div>
          <!-- end container -->
      </div>
      <!-- end wrapper -->

      <!-- Footer -->
      <footer class="footer">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-12">
                      © 2018 Blog by Marvalinks.
                  </div>
              </div>
          </div>
      </footer>
      <!-- End Footer -->
    </div>

    <!-- jQuery  -->
    <script src="/backend/js/jquery.min.js"></script>
    <script src="/backend/js/popper.min.js"></script>
    <script src="/backend/js/bootstrap.min.js"></script>
    <script src="/backend/js/modernizr.min.js"></script>
    <script src="/backend/js/waves.js"></script>
    <script src="/backend/js/jquery.slimscroll.js"></script>
    <script src="/backend/js/jquery.nicescroll.js"></script>
    <script src="/backend/js/jquery.scrollTo.min.js"></script>

    <!--Summernote init-->
    <script src="/backend/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/backend/plugins/dropzone/dist/dropzone.js"></script>
    <script src="/backend/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script src="/backend/pages/sweet-alert.init.js"></script>

    <script>
        jQuery(document).ready(function() {

            $('.summernote').summernote({
                height: 250, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        });
    </script>

    @yield('script_tags')

    <!-- App js -->
    <script src="/backend/js/app.js"></script>
    <script src="/js/app.js"></script>
    @yield('scripts')

</body>

</html>

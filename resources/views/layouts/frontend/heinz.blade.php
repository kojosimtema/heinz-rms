
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="f7g70hdvvRFd7eRFcQTKmNWr62sADicFivE7TetQ">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Heinz Management</title>



<link rel="stylesheet" href="/css/dashboard/bootstrap.min.css">
<link rel="stylesheet" href="/css/dashboard/core.css">
<link rel="stylesheet" href="/css/dashboard/components.css">
<link rel="stylesheet" href="/css/dashboard/icons.css">
<link rel="stylesheet" href="/css/dashboard/pages.css">
<link rel="stylesheet" href="/css/dashboard/responsive.css">
<link rel="stylesheet" href="/css/dashboard/dashboard.css">


<link rel="stylesheet" href="/css/dashboard/jquery.dataTables.min.css">
<link rel="stylesheet" href="/css/dashboard/buttons.bootstrap.min.css">
<link rel="stylesheet" href="/css/dashboard/responsive.bootstrap.min.css">
<link rel="stylesheet" href="/css/dashboard/dataTables.bootstrap.min.css">


<link rel="stylesheet" href="/css/dashboard/select2.min.css">

<link rel="stylesheet" href="/css/dashboard/morris.css">


<link rel="stylesheet" href="/css/dashboard/ladda-themeless.min.css">
<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<script src="/js/dashboard/modernizr.min.js"></script>

<link href="/backend/css/override.css" rel="stylesheet" type="text/css" />

</head>
<body class="fixed-left">
<div id="wrapper">

    <!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left" style="display: none;">
        <div class="text-center">
            <a href="#" class="logo">
                <i class="icon-c-logo my-logo">H</i>
                <span class="my-logo">Heinz RMS</span>
            </a>
            <!-- Image Logo here -->




        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation" style="display: none;">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="md md-menu"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li><a href="{{route('login')}}" class="waves-effect waves-light">Login</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->



    <style>
        .btn-orange{
            background-color: orangered!important;
        }
        .text-orange{
            color: orangered!important;
        }
    </style>

<div class="account-pages overlay">
  <div class="dark-acount-pages"></div>
</div>
<div class="clearfix"></div>
@yield('content')




<script>
    var resizefunc = [];
</script>

<!-- <script src="/js/dashboard/pusher.min.js"></script> -->
<script src="/js/dashboard/jquery.min.js"></script>
<script src="/js/dashboard/bootstrap.min.js"></script>
<script src="/js/dashboard/detect.js"></script>
<script src="/js/dashboard/fastclick.js"></script>
<script src="/js/dashboard/jquery.slimscroll.js"></script>
<script src="/js/dashboard/jquery.blockUI.js"></script>
<script src="/js/dashboard/waves.js"></script>
<script src="/js/dashboard/wow.min.js"></script>
<script src="/js/dashboard/jquery.nicescroll.js"></script>
<script src="/js/dashboard/jquery.scrollTo.min.js"></script>



<script src="/js/dashboard/select2.min.js"></script>



<script src="/js/dashboard/notify.js"></script>
<script src="/js/dashboard/notify-metro.js"></script>


<script src="/js/dashboard/jquery.dataTables.min.js"></script>
<script src="/js/dashboard/dataTables.bootstrap.js"></script>
<script src="/js/dashboard/dataTables.buttons.min.js"></script>
<script src="/js/dashboard/buttons.bootstrap.min.js"></script>
<script src="/js/dashboard/dataTables.responsive.min.js"></script>
<script src="/js/dashboard/responsive.bootstrap.min.js"></script>


<script src="/js/dashboard/spin.min.js"></script>
<script src="/js/dashboard/ladda.min.js"></script>
<script src="/js/dashboard/ladda.jquery.min.js"></script>




<script src="/js/dashboard/dashboard.js"></script>
<script src="/js/dashboard/jquery.core.js"></script>
<script src="/js/dashboard/jquery.app.js"></script>
<script src="/js/dashboard/jquery.uploadPreview.js"></script>


<script src="/js/dashboard/parsley.min.js"></script>


<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('5287d7496f9fbbd58d6d', {
        cluster: 'ap2',
        encrypted: 1
    });


</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110183437-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-110183437-1');
</script>


                <script>
    $(document).ready(function () {



             })
</script>

</div>

<footer class="footer" style="font-size: 12px;color: white;background: #36404a;border: none; left: 0px; text-align: center!important;">
    Revenue Management System © <?php echo date('Y'); ?>. All rights reserved
    <a href="" style="color: #d66c0c;font-size: 11px;">Heinz Integrated System</a>
    Powered by <a href="https://www.marvalinks.com" target="_blank" style="color: #d66c0c;font-size: 11px;">Marvalinks Digital Media Agency.</a>
</footer>
</body>
</html>

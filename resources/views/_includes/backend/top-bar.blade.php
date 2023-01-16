<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="{{route('console.dashboard')}}" class="logo">
                <i class="icon-c-logo my-logo" style="font-size: 26px; font-family: monospace;">RMS</i>
                <span class="my-logo"></span>
            </a>
            <!-- Image Logo here -->




        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="md md-menu"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <!-- <ul class="nav navbar-nav hidden-xs">
                    <li><a href="{{route('settings')}}" class="waves-effect waves-light">Settings</a></li>

                </ul> -->
                <ul class="nav navbar-nav hidden-xs">
                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                           role="button" aria-haspopup="true" aria-expanded="false">Fix <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('fix.collectors')}}">Collectors</a></li>
                            <li><a href="{{route('fix.owners.property')}}">P Owners</a></li>
                            <li><a href="{{route('fix.owners.business')}}">B Owners</a></li>
                            <li><a href="{{route('fix.enum')}}">enum</a></li>
                            <li><a href="{{route('fix.payment')}}">payment</a></li>
                            <li><a href="{{route('fix.property.owner')}}">property owner</a></li>
                            <li><a href="{{route('fix.business.owner')}}">business owner</a></li>
                            <li><a href="{{route('fix.business.id')}}">business id</a></li>
                            <li><a href="{{route('fix.property.id')}}">property id</a></li>
                            <li><a href="{{route('fix.feefixing.property')}}">roll over fee fixing property</a></li>
                            <li><a href="{{route('fix.feefixing.business')}}">roll over fee fixing business</a></li>
                        </ul>
                    </li> -->
                    <li><a href="{{route('console.dashboard')}}" class="waves-effect waves-light ass-name">{{env('ASSEMBLY_SMS_NAME')}}</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right pull-right">

                    <li class="dropdown top-menu-item-xs">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown"
                           aria-expanded="true"><img src="/backend/images/users/boy.png" alt="user-img"
                                                     class="img-circle"> </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="ti-user m-r-10 text-custom"></i> {{__('Profile')}}</a>
                            </li>
                            <li><a href="#"><i class="ti-settings m-r-10 text-custom"></i> {{__('Settings')}}</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="ti-power-off m-r-10 text-danger"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
                <ul class="nav navbar-nav hidden-xs nav-right pull-right">
                  <li>
                    <a href="" class="waves-effect waves-light ass-name">
                      <span style="font-size: 12px;letter-spacing: 0px;font-weight: 400;text-transform:initial;color: #cdaa80;">Logged in as:&nbsp;</span>

                      <span style="font-size: 12px;letter-spacing: 1px;font-weight: 400;"><?php echo auth()->user()->name; ?></span>
                    </a>
                  </li>
                    <li><a href="" class="waves-effect waves-light" style="font-size: 10px;">Powered by: <span style="color: #dcb686;font-size: 10px;">Heinz Integrated System</span> </a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->

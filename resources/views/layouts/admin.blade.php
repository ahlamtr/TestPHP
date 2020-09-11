<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{asset('admin/build/css/custom.min.css')}}" rel="stylesheet">
        
        @yield('header')
    </head>
    
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col" style="background: #e30613;">
                    <div class="left_col scroll-view" style="background: #e30613;width: 100%;">


                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="{{asset('images/avatar/profile_admin.jpg')}}" alt="" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>{{Lang::get('messages.menu.admin.welcome')}}</span>
                                <h2>Admin-auto</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>{{Lang::get('messages.menu.admin')}}</h3>
                                <ul class="nav side-menu">

                                    <li id="my-element"><a><i class="fa fa-car"></i> {{Lang::get('messages.menu.admin.car')}} <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" id="cars_ul">
                                            <li id="my-1-element" ><a href="{{url('/admin/brand')}}">{{Lang::get('messages.menu.admin.car.brand')}}</a></li>
                                            <li id="my-2-element"><a href="{{url('/admin/model')}}">{{Lang::get('messages.menu.admin.car.model')}}</a></li>
                                            <li id="my-3-element"><a href="{{url('/admin/car?first=true')}}">{{Lang::get('messages.menu.admin.car')}}</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <nav class="nav navbar-nav">
                            <ul class=" navbar-right" >
                               
                                <li id="my-9-element" role="presentation" class="nav-item dropdown open list-cont">
                                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false"  >
                                        <i class="fa fa-envelope-o"></i>

                                        <span class="badge bg-green nbr_contact"></span>
                                        <input type='hidden' id="status" value="">
                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list msg_list2" role="menu" aria-labelledby="navbarDropdown1">
                                        
                                        <li class="nav-item item-msg" onclick="window.location = '{{url('/admin/contact/reply?cid=')}}'">
                                            <a class="dropdown-item">
                                                <span class="image">
                                                   
                                                    <img src="" alt="Profile Image" />
                                                </span>
                                                <span>
                                                    <span></span>
                                                    <span class="time"></span>
                                                </span>
                                                <span class="message">
                                                   
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <div class="text-center">
                                                <a href="{{url('/admin/contact')}}" class="dropdown-item">
                                                    <strong>{{Lang::get('buttons.more')}}</strong>
                                                    <i class="fa fa-angle-right" style="font-size: 15px !important;"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li id="my-10-element" role="notification" class="nav-item dropdown open list-notif">
                                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown2" data-toggle="dropdown" aria-expanded="false" onclick="myFunction()" >
                                        <i class="fa fa fa-bell"></i>
                                       
                                        <span class="badge bg-green nbr_notif "></span>

                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list msg_notif" role="notification" aria-labelledby="navbarDropdown2">
                                      
                                        <li class="nav-item item-msg" onclick="window.location = '{{url('/admin/notification/reply?not=')}}'">
                                            <a class="dropdown-item">
                                                <span class="image">

                                                    <img src="" alt="Profile Image" />
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <div class="text-center">
                                                <a href="{{url('/admin/notification')}}" class="dropdown-item">
                                                    <strong>{{Lang::get('buttons.more')}}</strong>
                                                    <i class="fa fa-angle-right" style="font-size: 15px !important;"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li> 
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                @yield('content')
                <!-- /page content -->

                <!-- footer content -->
                <footer style="height: 50px;background: #f9f9f9;border-top: 1px solid #ddd;">
                    <div style="text-align: center;color:#666">
                        &copy; 2020 <a href="#" style="color:#666;font-weight: bold" title="{{Lang::get('messages.name')}}" target="_blank">{{Lang::get('messages.name')}}</a>, {{Lang::get("messages.copyright")}}
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
       
        <!-- Bootstrap -->
        <script src="{{asset('admin/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('js/app.js') }}" ></script>

       <!-- Custom Theme Scripts -->
       <script src="{{asset('admin/build/js/custom.min.js')}}"></script>

       <script>
            $(document).ready(function () {
                                                
                                            
            });

        </script>
        @yield('scriptFile')


    </body>
</html>

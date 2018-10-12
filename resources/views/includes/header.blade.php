<!-- Top Navigation -->
<nav class="navbar navbar-default navbar-static-top m-b-0">

    <div class="navbar-header">
        {{--<a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)"--}}
           {{--data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>--}}
        <div class="top-left-part" style="background: transparent">
            <a class="logo" href="{{ url('dashboard') }}">
                <b>
                    <!--This is dark logo icon--><img src="{{ asset('assets/img/logo.png') }}" alt="home" class="dark-logo" style="width: 40px">
                    <!--This is light logo icon--><img src="{{ asset('assets/img/logo.png') }}" alt="home" class="light-logo" style="width: 40px">
                </b>
                <span class="text-white" style="display: inline;">
                    <b>Pazatto</b>
                </span>
            </a>
        </div>
        {{--<ul class="nav navbar-top-links navbar-left hidden-xs">--}}
            {{--<li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i--}}
                            {{--class="ti-menu"></i></a></li>--}}
        {{--</ul>--}}
        <ul class="nav navbar-top-links navbar-right pull-right">
            {{--<li class="dropdown"><a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"--}}
                                    {{--href="#"><i--}}
                            {{--class="icon-envelope"></i>--}}
                    {{--<div class="notify"><span class="heartbit"></span><span class="point"></span></div>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu mailbox animated flipInY">--}}
                    {{--<li>--}}
                        {{--<div class="drop-title">You have 4 new Notifications</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="message-center">--}}
                            {{--<a href="#">--}}
                                {{--<div class="user-img"><img--}}
                                            {{--src="https://wrappixel.com/demos/admin-templates/pixeladmin/plugins/images/users/pawandeep.jpg"--}}
                                            {{--alt="user" class="img-circle"> <span--}}
                                            {{--class="profile-status online pull-right"></span></div>--}}
                                {{--<div class="mail-contnet">--}}
                                    {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span--}}
                                            {{--class="time">9:30 AM</span></div>--}}
                            {{--</a>--}}
                            {{--<a href="#">--}}
                                {{--<div class="user-img"><img--}}
                                            {{--src="https://wrappixel.com/demos/admin-templates/pixeladmin/plugins/images/users/sonu.jpg"--}}
                                            {{--alt="user" class="img-circle"> <span--}}
                                            {{--class="profile-status busy pull-right"></span></div>--}}
                                {{--<div class="mail-contnet">--}}
                                    {{--<h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span>--}}
                                    {{--<span class="time">9:10 AM</span></div>--}}
                            {{--</a>--}}
                            {{--<a href="#">--}}
                                {{--<div class="user-img"><img--}}
                                            {{--src="https://wrappixel.com/demos/admin-templates/pixeladmin/plugins/images/users/arijit.jpg"--}}
                                            {{--alt="user" class="img-circle"> <span--}}
                                            {{--class="profile-status away pull-right"></span></div>--}}
                                {{--<div class="mail-contnet">--}}
                                    {{--<h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span--}}
                                            {{--class="time">9:08 AM</span></div>--}}
                            {{--</a>--}}
                            {{--<a href="#">--}}
                                {{--<div class="user-img"><img--}}
                                            {{--src="https://wrappixel.com/demos/admin-templates/pixeladmin/plugins/images/users/pawandeep.jpg"--}}
                                            {{--alt="user" class="img-circle"> <span--}}
                                            {{--class="profile-status offline pull-right"></span></div>--}}
                                {{--<div class="mail-contnet">--}}
                                    {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span--}}
                                            {{--class="time">9:02 AM</span></div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i--}}
                                    {{--class="fa fa-angle-right"></i> </a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                <!-- /.dropdown-messages -->
            {{--</li>--}}
            <!-- /.dropdown -->
            {{--<li class="dropdown"><a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"--}}
                                    {{--href="#"><i--}}
                            {{--class="icon-note"></i>--}}
                    {{--<div class="notify"><span class="heartbit"></span><span class="point"></span></div>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-tasks animated flipInX">--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p><strong> Quiz 1</strong> <span--}}
                                            {{--class="pull-right text-muted">40% Complete</span></p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-success" role="progressbar"--}}
                                         {{--aria-valuenow="40"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100" style="width: 40%"><span--}}
                                                {{--class="sr-only">40% Complete (success)</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p><strong> Quiz 2</strong> <span--}}
                                            {{--class="pull-right text-muted">20% Complete</span></p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-info" role="progressbar"--}}
                                         {{--aria-valuenow="20"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100" style="width: 20%"><span--}}
                                                {{--class="sr-only">20% Complete</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p><strong> Quiz 3</strong> <span--}}
                                            {{--class="pull-right text-muted">60% Complete</span></p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-warning" role="progressbar"--}}
                                         {{--aria-valuenow="60"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100" style="width: 60%"><span--}}
                                                {{--class="sr-only">60% Complete (warning)</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p><strong> Quiz 4</strong> <span--}}
                                            {{--class="pull-right text-muted">80% Complete</span></p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-danger" role="progressbar"--}}
                                         {{--aria-valuenow="80"--}}
                                         {{--aria-valuemin="0" aria-valuemax="100" style="width: 80%"><span--}}
                                                {{--class="sr-only">80% Complete (danger)</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a class="text-center" href="#"> <strong>See All Quiz</strong> <i--}}
                                    {{--class="fa fa-angle-right"></i> </a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- /.dropdown-tasks -->--}}
            {{--</li>--}}
            <!-- /.dropdown -->
            <li>
                <a href="{{ url('logout') }}" class="waves-effect waves-light no-ajaxy">
                    <i class="fa fa-sign-out"></i>
                    Logout
                </a>
            </li>
                </a>
            </li>
            {{--<li class="right-side-toggle"><a class="waves-effect waves-light" href="javascript:void(0)">--}}
                    {{--<i class="ti-settings"></i></a></li>--}}
            <!-- /.dropdown -->
        </ul>
    </div>
    <div class="container">
        {{--<div class="row">--}}
        {{--<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">--}}
        {{--<div class="sttabs tabs-style-iconbox">--}}
        {{--<nav>--}}
        {{--<ul>--}}
        {{--<li class="tab-current"><a href="#section-iconbox-1" class="sticon ti-home"><span>Home</span></a></li>--}}
        {{--<li><a href="#section-iconbox-2" class="sticon ti-gift"><span>Deals</span></a></li>--}}
        {{--<li><a href="#section-iconbox-3" class="sticon ti-upload"><span>Upload</span></a></li>--}}
        {{--<li><a href="#section-iconbox-4" class="sticon ti-trash"><span>Delete</span></a></li>--}}
        {{--<li><a href="#section-iconbox-5" class="sticon ti-settings"><span>Settings</span></a></li>--}}
        {{--</ul>--}}
        {{--</nav>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>
<!-- End Top Navigation -->

<style>
    .tabs-style-iconbox nav ul li a {
        padding: 15px 0px;
    }

    #page-wrapper {
        /*margin: 0px;*/
    }
    /*.content-wrapper .top-left-part{*/
        /*position: relative;*/
    /*}*/
    /*.navbar-left{*/
        /*margin-left: 220px;*/
    /*}*/
    /*.content-wrapper .navbar-left{*/
        /*margin-left: 0;*/
    /*}*/
    /*.top-left-part{*/
        /*position: absolute;*/
    /*}*/
    /*.user-profile {*/
        /*padding: 5px 0;*/
    /*}*/
    /*.top-left-part a{*/
        /*font-size: inherit;*/
        /*text-transform: none;*/
    /*}*/
    #side-menu{
        border-top: 1px solid #eee;
        /*margin-top: 40px;*/
    }
    .content-wrapper #side-menu{
        margin-top: 0;
    }

    @media (max-width: 767px) {
        /*.top-left-part {*/
            /*display: none;*/
        /*}*/
    }

    .timeline>li>.timeline-badge{
        background-color: transparent;
    }
    .tabs-style-iconbox nav, .timeline-panel {
        background: #ffffff;
    }
    .page-aside{
        min-height: 600px;
    }
</style>
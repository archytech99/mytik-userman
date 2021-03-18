    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="slimscroll-menu" id="remove-scroll">
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">
                    <li>
                        <a href="{{ route('index') }}" class="waves-effect"><i class="dripicons-meter"></i><span> Dashboard </span></a>
                    </li>

                    <li class="menu-title">Hotspot</li>
                    <li>
                        <a href="{{ route('users') }}" class="waves-effect">
                            <i class="dripicons-user-group"></i><span> Voucher </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('packet') }}" class="waves-effect">
                            <i class="dripicons-briefcase"></i><span> Packet </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client') }}" class="waves-effect">
                            <i class="dripicons-graph-bar"></i><span> Hotspot Client </span>
                        </a>
                    </li>

                    <li class="menu-title">Setting</li>
                    <li>
                        <a href="{{ route('session') }}" class="waves-effect">
                            <i class="dripicons-time-reverse"></i><span> Session </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('router') }}" class="waves-effect">
                            <i class="dripicons-information"></i><span> Router </span>
                        </a>
                    </li>

                    {{--<li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-mail"></i><span> Email <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            <li><a href="email-inbox.html">Inbox</a></li>
                            <li><a href="email-read.html">Email Read</a></li>
                            <li><a href="email-compose.html">Email Compose</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-link"></i><span> Multi Level <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            <li><a href="javascript:void(0);"> Menu 1</a></li>
                            <li>
                                <a href="javascript:void(0);">Menu 2  <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="submenu">
                                    <li><a href="javascript:void(0);">Menu 2.1</a></li>
                                    <li><a href="javascript:void(0);">Menu 2.1</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>--}}

                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

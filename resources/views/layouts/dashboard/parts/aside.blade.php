<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="{{route('dashboard.index')}}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-protection"></i><span class="kt-menu__link-text">{{__('Dashboard')}}</span></a></li>
                @canany(['view_roles','create_roles'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-lock"></i><span class="kt-menu__link-text">{{__('Roles')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_roles')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.roles.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Roles')}}</span></a></li>
                            @endcan
                            @can('create_roles')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.roles.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Role')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['view_users','create_users'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-profile-1"></i><span class="kt-menu__link-text">{{__('Customers')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_users')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.customers.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Customers')}}</span></a></li>
                            @endcan
                            @can('create_users')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.customers.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Customer')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view_violations','create_violations'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-open-box"></i><span class="kt-menu__link-text">{{__('Violations')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.violations.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Violations')}}</span></a></li>
                            @endcan
                            @can('create_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.violations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Violation')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view_employees','create_employees'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-group"></i><span class="kt-menu__link-text">{{__('Employees')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_employees')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('All Employees')}}</span></a></li>
                            @endcan
                            @can('create_employees')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Employee')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view_employees_violations','create_employees_violations'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-layers-1"></i><span class="kt-menu__link-text">{{__('Employees Violations')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_employees_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees_violations.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Employees Violations')}}</span></a></li>
                            @endcan
                            @can('create_employees_violations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.employees_violations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Violation')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany
                @canany(['view_reports','create_reports'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon  flaticon2-document"></i><span class="kt-menu__link-text">{{__('Reports')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_reports')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.reports.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Reports')}}</span></a></li>
                            @endcan
                            @can('view_reports')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.reports.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Report')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                @canany(['view_conversations','create_conversations'])
                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon  flaticon-envelope"></i><span class="kt-menu__link-text">{{__('Conversations')}}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Config</span></span></li>
                            @can('view_conversations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.conversations.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('AlL Conversation')}}</span></a></li>
                            @endcan
                            @can('view_conversations')
                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{route('dashboard.conversations.create')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{__('New Conversation')}}</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                <li class="kt-menu__item " aria-haspopup="true"><a onclick="document.getElementById('logout-form').submit();" href="javascript:" class="kt-menu__link "><i class="kt-menu__link-icon  fas fa-sign-out-alt"></i><span class="kt-menu__link-text">{{__('Log Out')}}</span></a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>

    <!-- end:: Aside Menu -->
</div>

<!-- end:: Aside -->

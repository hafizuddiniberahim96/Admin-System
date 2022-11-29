<?php

if(!function_exists('renderDropdown')){
    function renderDropdown($data){
        if(array_key_exists('slug', $data) && $data['slug'] === 'dropdown'){
            echo '<li class="c-sidebar-nav-dropdown">';
            echo '<a class="c-sidebar-nav-dropdown-toggle" href="#">';
            if($data['hasIcon'] === true && $data['iconType'] === 'coreui'){
                echo '<i class="' . $data['icon'] . ' c-sidebar-nav-icon"></i>';    
            }
            echo $data['name'] . '</a>';
            echo '<ul class="c-sidebar-nav-dropdown-items">';
            renderDropdown( $data['elements'] );
            echo '</ul></li>';
        }else{
            for($i = 0; $i < count($data); $i++){
                if( $data[$i]['slug'] === 'link' ){
                    echo '<li class="c-sidebar-nav-item">';
                    echo '<a class="c-sidebar-nav-link" href="' . url($data[$i]['href']) . '">';
                    echo '<span class="c-sidebar-nav-icon"></span>' . $data[$i]['name'] . '</a></li>';
                }elseif( $data[$i]['slug'] === 'dropdown' ){
                    renderDropdown( $data[$i] );
                }
            }
        }
    }
}
?>

<div class="c-sidebar-brand"><img class="c-sidebar-brand-full" src="{{asset('/img/logo-BUIPA-pkink.png')}}" width="250" height="46" alt="BUIPA Logo">
    <img class="c-sidebar-brand-minimized" src="{{asset('/img/logo-pkink.png')}}" width="118" height="46" alt="BUIPA Logo"></div>
    <ul class="c-sidebar-nav ps">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/home">
                <i class=" c-sidebar-nav-icon fa fa-dashboard"></i>
                Dashboard
            </a>
        </li>

        <li class="c-sidebar-nav-title">Events</li>
        @can('isNotAdmin')

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/events">
                    <i class=" c-sidebar-nav-icon fa fa-joomla"></i>
                    Events
            </a>
            </li>
        @endcan
        @can('isAdmin')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" >
            <i class=" c-sidebar-nav-icon fa fa-joomla"></i>
                 Events</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/events">
                        <span class="c-sidebar-nav-icon"></span> All Events</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/events/ongoing-events">
                        <span class="c-sidebar-nav-icon"></span> Ongoing Events</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/events/closed-events">
                        <span class="c-sidebar-nav-icon"></span> Closed Events</a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/events/registrations">
                <i class=" c-sidebar-nav-icon fa fa-registered"></i>
                </svg> Registrations</a>
            </li>
        @endcan
        @can('isNotAdmin')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/events/my-events">
                    <i class=" c-sidebar-nav-icon fa fa-star"></i>
                    My Events
                </a>
            </li>
        @endcan
        @canany(['isAdmin','isTutor'])
        <li class="c-sidebar-nav-title">My E-Usahawan</li>
       
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" >
                <i class=" c-sidebar-nav-icon fa fa-institution"></i>
                Institution</a>
                <ul class="c-sidebar-nav-dropdown-items">
                @can('isTutor')
                    <!-- Teacher/Instructor/Secratariat -->
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/my-institution">
                        <span class="c-sidebar-nav-icon"></span> My Institution</a>
                    </li>
                @endcan
                @can('isAdmin')
                    <!-- Admin -->
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/institutions">
                        <span class="c-sidebar-nav-icon"></span> Active Institution</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/pending-institution">
                        <span class="c-sidebar-nav-icon"></span> Pending Institution</a>
                    </li>
                @endcan
                </ul>
            </li>
            @can('isTutor')
                @if(Auth::user()->institution)
                    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" >
                        <i class=" c-sidebar-nav-icon fa fa-users"></i>
                        Supervisor</a>
                        <ul class="c-sidebar-nav-dropdown-items">
                            <!-- Teacher/Instructor/Secratariat -->
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/supervisor-user/student">
                                <span class="c-sidebar-nav-icon"></span> Student</a>
                            </li>
                            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/supervisor-user/entrepreneur">
                                <span class="c-sidebar-nav-icon"></span> Entrepreneur</a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endcan
           
            @can('isAdmin')
            <!-- Admin -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class=" c-sidebar-nav-icon fa fa-users"></i>
                    User</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/pending-user">
                        <span class="c-sidebar-nav-icon"><i></i></span> Pending User</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/students">
                        <span class="c-sidebar-nav-icon"></span> Student</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/entrepreneurs">
                        <span class="c-sidebar-nav-icon"></span> Entrepreneur</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/teachers">
                        <span class="c-sidebar-nav-icon"></span> Teacher</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/instructors">
                        <span class="c-sidebar-nav-icon"></span> Instructor</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/mye-usahawan/secretariats">
                        <span class="c-sidebar-nav-icon"></span> Secretariat</a>
                    </li>
                </ul>
            </li>
            @endcan

        @endcanany
            <li class="c-sidebar-nav-title">My Reports</li>
            <!-- Student/Entrepreneur -->
            @if( Gate::check('isAdmin') || Gate::check('isUser') ) 
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/reports">
                    <i class=" c-sidebar-nav-icon fa fa-list-alt"></i>
                    Reports
                </a>
            </li>
            @endif

            @can('isNotUser')
            <!-- Teacher/Instructor/Secratariat -->
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/penazirans">
                    <i class=" c-sidebar-nav-icon fa fa-trophy"></i>
                    Penaziran
                </a>
            </li>
            @endcan

        <li class="c-sidebar-nav-title">My Documents</li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/general-document">
                    <i class=" c-sidebar-nav-icon fa fa-folder"></i>
                    Documents
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/">
                    <i class=" c-sidebar-nav-icon fa fa-certificate"></i>
                    Certificates
                </a>
            </li>
        
        <li class="c-sidebar-nav-title">Settings</li>
           @can('isUser')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/company">
                    <i class=" c-sidebar-nav-icon fa fa-industry"></i>
                    Company Profile
                </a>
            </li>
            @endcan
            @can('isAdmin')
            <!-- Admin -->
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class=" c-sidebar-nav-icon fa fa-gamepad"></i> 
                Administrative Tools</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin-tools/list-admin">
                        <span class="c-sidebar-nav-icon"></span> Admin Users</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"  href="/admin-tools/system-settings">
                        <span class="c-sidebar-nav-icon"></span>System Settings</a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin-tools/finance-settings">
                        <span class="c-sidebar-nav-icon"></span> Accounting</a>
                    </li>                  
                </ul>
            </li>
            @endcan
            @if(Auth::user()->role->name == 'admin')
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{Route('admin.view.admin.update',[Auth::id()])}}">
            @else
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{Route('account-setting')}}">
            @endif
                <i class=" c-sidebar-nav-icon fa fa-cogs"></i>
                    Account Setting
                </a>
            </li>
        </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
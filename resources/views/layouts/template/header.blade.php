<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    @if(Auth()->user()->registerComplete && Auth()->user()->isApproved)
    <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <span class="c-header-toggler-icon"></span></button>
        <a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="{{ url('/assets/brand/coreui-base.svg')}}" width="97" height="46" alt="CoreUI Logo"></a>
    <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <span class="c-header-toggler-icon"></span>
    </button>
    @endif
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        @if(!empty(Auth()->user()->details->profileImg))
            <div class="c-avatar"><img class="c-avatar-img" src="{{ asset('storage/'.Auth()->user()->details->profileImg) }}" alt="{{Auth()->user()->nric}}">
        @else
            <div class="c-avatar"><img class="c-avatar-img" src="{{ url('/assets/img/avatars/profile.png') }}" alt="{{Auth()->user()->nric}}">

        @endif
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right pt-0">
            @can('isAdmin')
            <a class="dropdown-item" href="{{route('login.locked')}}">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ url('/icons/sprites/free.svg#cil-lock-locked') }}"></use>
                </svg> Lock Account
            </a>
            @endcan            
            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="c-icon mr-2">
                <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
            </svg>Logout
                 <form id="logout-form" action="{{ route('signout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
        </div>
        </li>
    </ul>
    <div class="c-subheader px-3">
          <ol class="breadcrumb border-0 m-0">
            <!-- <li class="breadcrumb-item"><a href="/">Home</a></li> -->
            <?php $segments = ''; ?>
            @for($i = 1; $i <= count(Request::segments()); $i++)
                <?php $segments .= '/'. Request::segment($i); ?>
                @if($i < count(Request::segments()))
                    @if(Request::segment($i) == 'mye-usahawan')
                        <li class="breadcrumb-item">My E-Usahawan</li>
                    @elseif((Request::segment($i-1) == 'attendance-participants'))
                    @else
                        <li class="breadcrumb-item">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</li>
                    @endif

                @else
                    @if( $i > 1 && (Request::segment($i-1) == 'user'))
                    <li class="breadcrumb-item active">User Details</li>
                    @elseif($i > 1 && in_array(Request::segment($i-1),array('institution','update-institution')))
                    <li class="breadcrumb-item active">Insitution Details</li>
                    @elseif($i > 1 && in_array(Request::segment($i-1),array('admin')))
                    <li class="breadcrumb-item active">Admin Details</li>
                    @elseif($i > 1 && in_array(Request::segment($i-1),array('student','entrepreneur','teacher','instructor','secretariat')))
                    <li class="breadcrumb-item active">{{ ucwords(Request::segment($i-1)) }} Details</li>
                    @elseif($i > 1 && (in_array(Request::segment($i-1),array('update-events','view-events','create-report',
                    'attendance-links','attendance-all-participants','create-penaziran','list-participants','penaziran-details',
                    'admin-setting','supervision-student','supervision-entrepreneur','create-attendance','review-report')) || (Request::segment($i-2) == 'attendance-participants') ))

                    @else
                    <li class="breadcrumb-item active">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</li>
                    @endif
                @endif
            @endfor
          </ol>
        </div>
    </header>

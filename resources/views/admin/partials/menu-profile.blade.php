@php($user = $profile)
<div class="profilebar">
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('assets/images/users/profile.svg') }}"
                 style="visibility: hidden; width: 1px; height: 36px;"
                 class="img-fluid" alt="profile"
            >
            <span class="live-icon"><b>{{ $user->title }}</b></span>
            <span class="feather icon-chevron-down live-icon"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
            <div class="userbox">
                <ul class="list-unstyled mb-0">
                    <li class="media dropdown-item">
                        <a href="{{ route('profile') }}" class="profile-icon"><img src="{{ asset('assets/images/svg-icon/crm.svg') }}" class="img-fluid" alt="user">{{ __('My Profile') }}</a>
                    </li>
                    <li class="media dropdown-item">
                        <a href="{{ route('logout') }}" class="profile-icon" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="{{ asset('assets/images/svg-icon/logout.svg') }}" class="img-fluid" alt="logout">{{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

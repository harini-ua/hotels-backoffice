<div class="profilebar">
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="assets/images/users/profile.svg" class="img-fluid" alt="profile">
            <span class="live-icon">{{ $user->fullname }}</span>
            <span class="feather icon-chevron-down live-icon"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
            <div class="userbox">
                <ul class="list-unstyled mb-0">
                    <li class="media dropdown-item">
                        <a href="#" class="profile-icon"><img src="assets/images/svg-icon/crm.svg" class="img-fluid" alt="user">My Profile</a>
                    </li>
                    <li class="media dropdown-item">
                        <a href="#" class="profile-icon"><img src="assets/images/svg-icon/logout.svg" class="img-fluid" alt="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

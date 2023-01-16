<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link" target="_blank">View Site</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('application_list', ['applicationType' => 'all']) }}" class="nav-link">All Contact Requests</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('logout')}}" role="button">
                <i class="fa fa-sign-out-alt text-danger"></i>
            </a>
        </li>
    </ul>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-white top-navbar border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="/img/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (Auth::user())
                            Ingelogd
                        @else
                            Aanmelden
                        @endif
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if (Auth::user())
                            @if(Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-person-fill me-1"></i> Uitloggen</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-person-fill me-1"></i> Inloggen</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-person-plus-fill me-1"></i> Ik wil mij aanmelden</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

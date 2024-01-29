<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header my-3 mx-auto">
                <img src="{{ asset('assets/images/favicon.svg') }}" style="width: 50px; margin-left: 100" />
            </div>
            <div class="navbar-content">
                <div class="card pc-user-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/user/'.$user->photo) }}" alt=""
                                    class="user-avtar wid-45 rounded-circle" />
                            </div>
                            <div class="flex-grow-1 ms-3 me-2">
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                @foreach ($user->getRoleNames() as $role)
                                <small>{{ $role }}</small>
                                @endforeach
                            </div>
                            <a class="btn btn-icon btn-link-secondary avtar-s" data-bs-toggle="collapse"
                                href="#pc_sidebar_userlink">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-sort-outline"></use>
                                </svg>
                            </a>
                        </div>
                        <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                            <div class="pt-3">
                                <a href="{{ route('logout') }}">
                                    <i class="ti ti-power"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="pc-navbar">
                    @foreach ($menus as $menu)
                    @if (in_array($user->getRoleNames()[0], $menu['can']))
                    {{-- if header == null --}}
                    @if ($menu['header'] != null)
                    <li class="pc-item pc-caption">
                        <label>{{ $menu['header'] }}</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    @endif
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ $menu['url'] }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="{{ $menu['icon'] }}"></i>
                            </span>
                            <span class="pc-mtext">{{ $menu['name'] }}</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        @if (count($menu['sub_menu']) > 0)
                        <ul class="pc-submenu">
                            @foreach ($menu['sub_menu'] as $sub_menu)
                            @if (in_array($user->getRoleNames()[0], $menu['can']))
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ $sub_menu['url'] }}">{{ $sub_menu['name'] }}</a></li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</div>

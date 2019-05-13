<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " data-menu-vertical="true" m-menu-dropdown="0" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('dashboard') }}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-chart-line"></i><span class="m-menu__link-text">Dashboard</span></a></li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('issues.create') }}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-ticket-alt"></i><span class="m-menu__link-text">Open issue</span></a></li>
            @if(auth()->user()->isAdmin || auth()->user()->isSav)
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('issues.index') }}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-list-alt"></i><span class="m-menu__link-text">Liste issues</span></a></li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('modify.client') }}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-user-edit"></i><span class="m-menu__link-text">Update Client</span></a></li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('problems.index') }}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-exclamation"></i><span class="m-menu__link-text">Problems</span></a></li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('solutions.index') }}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-check-double"></i><span class="m-menu__link-text">Solutions</span></a></li>
            @endif
            @if(auth()->user()->isAdmin)
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-users"></i><span
                        class="m-menu__link-text">Agents manager</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__item-here"></span><span class="m-menu__link-text">Agents manager</span></span></li>
                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ route('users.index') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agents</span></a></li>
                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ route('commercials.index') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Commercials</span></a></li>
                    </ul>
                </div>
            </li>
            @endif
            <li class="m-menu__item " aria-haspopup="true"><a href="http://154.70.200.106:8003/public-registration" target="_blank" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon fa fa-file-invoice"></i><span class="m-menu__link-text">P-Registration</span></a></li>
        </ul>
    </div>
</div>
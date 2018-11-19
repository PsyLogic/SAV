<div class="sidebar sidebar-dark bg-dark">
    <ul class="list-unstyled">
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{ route('issues.create') }}"><i class="fas fa-ticket-alt"></i> Open issue</a></li>
        
        @if(auth()->user()->isAdmin || auth()->user()->isSav)
        
        <li><a href="{{ route('issues.index') }}"><i class="far fa-list-alt"></i> Liste issues</a></li>
        <li><a href="{{ route('problems.index') }}"><i class="fas fa-list-ul"></i> Problems</a></li>
        <li><a href="{{ route('solutions.index') }}"><i class="fas fa-list-ul"></i> Solutions</a></li>
        @endif
        @if(auth()->user()->isAdmin)
        <li>
            <a href="#sm_expand_1" data-toggle="collapse">
                <i class="fas fa-users"></i> Agents manager
            </a>
            <ul id="sm_expand_1" class="list-unstyled collapse">
        <li><a href="{{ route('users.index') }}"><i class="fas fa-user-tie"></i> Agents</a></li>
        
        <li><a href="{{ route('commercials.index') }}"><i class="fas fa-user-cog"></i> Commercials</a></li>
            </ul>
        </li>
        @endif
        <li><a href="http://154.70.200.106:8003/public-registration" target="_blank"><i class="fa fa-fw fa-link"></i> P-Registration</a></li>
    </ul>
</div>
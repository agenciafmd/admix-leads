@if (!((admix_cannot('view', '\Agenciafmd\Leads\Lead'))))
    <li class="nav-item">
        <a class="nav-link {{ (admix_is_active(route('admix.leads.index'))) ? 'active' : '' }}"
           href="{{ route('admix.leads.index') }}"
           aria-expanded="{{ (admix_is_active(route('admix.leads.index'))) ? 'true' : 'false' }}">
            <span class="nav-icon">
                <i class="icon {{ config('admix-leads.icon') }}"></i>
            </span>
            <span class="nav-text">
                {{ config('admix-leads.name') }}
            </span>
        </a>
    </li>
@endif

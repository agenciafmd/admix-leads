@can('view', \Agenciafmd\Leads\Models\Lead::class)
    <li class="nav-item">
        <a class="nav-link  {{ (Str::startsWith(request()->route()->getName(), 'admix.leads')) ? 'active' : '' }}"
           href="{{ route('admix.leads.index') }}"
           aria-expanded=" {{ (Str::startsWith(request()->route()->getName(), 'admix.leads')) ? 'true' : 'false' }}">
            <span class="nav-icon">
                <i class="icon {{ config('admix-leads.icon') }}"></i>
            </span>
            <span class="nav-text">
                {{ config('admix-leads.name') }}
            </span>
        </a>
    </li>
@endcan

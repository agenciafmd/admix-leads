<?php

namespace Agenciafmd\Leads\Http\Components\Aside;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;
use Agenciafmd\Leads\Models\Lead as LeadModel;
class Lead extends Component
{
    public function __construct(
        public string $icon = '',
        public string $label = '',
        public string $url = '',
        public bool $active = false,
        public bool $visible = false,
    ) {}

    public function render(): View
    {
        $this->icon = __(config('admix-leads.icon'));
        $this->label = __(config('admix-leads.name'));
        $this->url = route('admix.leads.index');
        $this->active = request()?->currentRouteNameStartsWith('admix.leads');
        $this->visible = Gate::allows('view',LeadModel::class);

        return view('admix::components.aside.item');
    }
}

<?php

use Agenciafmd\Leads\Policies\LeadPolicy;

return [
    [
        'name' => config('admix-leads.name'),
        'policy' => LeadPolicy::class,
        'abilities' => [
            [
                'name' => 'View',
                'method' => 'view',
            ],
            [
                'name' => 'Create',
                'method' => 'create',
            ],
            [
                'name' => 'Update',
                'method' => 'update',
            ],
            [
                'name' => 'Delete',
                'method' => 'delete',
            ],
            [
                'name' => 'Restore',
                'method' => 'restore',
            ],
        ],
        'sort' => 100,
    ],
];

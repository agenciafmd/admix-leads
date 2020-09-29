<?php

return [
    'name' => 'Leads',
    'icon' => 'icon fe-inbox',
    'sort' => 20,
    'default_sort' => [
        '-is_active',
        '-created_at',
        'name',
    ],
    'sources' => [
        //
    ],
];

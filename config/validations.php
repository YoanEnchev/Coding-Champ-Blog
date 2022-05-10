<?php

return [
    'tech_entity' => [
        'url_name' => 'required | string | max:50',
        'pretty_name' => 'required | string | max:50',
        'cm_mode' =>  'required | string | max:50',
        'priority' => 'required | integer | min:0 | max:50'
    ],
    'category' => [
        'url_name' => 'required | string | max:50',
        'pretty_name' => 'required | string | max:50',
        'priority' => 'required | integer | min:0 | max:50'
    ]
];
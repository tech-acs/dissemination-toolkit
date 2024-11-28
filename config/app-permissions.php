<?php

return [
    'groups' => [
        [
            'title' => 'Visualization',
            'permissions' => [
                [
                    'title' => 'Create',
                    'description' => 'Create/edit/delete visualizations',
                    'permission_name' => 'create:visualization',
                ], [
                    'title' => 'Publish',
                    'description' => 'Publish/unpublish visualizations',
                    'permission_name' => 'publish:visualization',
                ], [
                    'title' => 'Approve reviews',
                    'description' => 'Approve visualization reviews',
                    'permission_name' => 'approve_review:visualization',
                ]
            ],
        ],
        [
            'title' => 'Data story',
            'permissions' => [
                [
                    'title' => 'Create',
                    'description' => 'Create/edit/delete data stories',
                    'permission_name' => 'create:story',
                ], [
                    'title' => 'Publish',
                    'description' => 'Publish/unpublish data stories',
                    'permission_name' => 'publish:story',
                ], [
                    'title' => 'Approve reviews',
                    'description' => 'Approve data story reviews',
                    'permission_name' => 'approve_review:story',
                ]
            ],
        ],
        [
            'title' => 'Dataset',
            'permissions' => [
                [
                    'title' => 'Create',
                    'description' => 'Create/edit/delete data stories',
                    'permission_name' => 'create:dataset',
                ], [
                    'title' => 'Publish',
                    'description' => 'Publish/unpublish data stories',
                    'permission_name' => 'publish:publish',
                ],
            ],
        ]
    ]
];

<?php

return [
    'owner' => [
        'name' => env('APP_OWNER_NAME', 'ECA'),
        'url' => env('APP_OWNER_URL', '#'),
    ],
    'secure' => env('SECURE', false),
    'records_per_page' => env('RECORDS_PER_PAGE', 20),
    'emailing_enabled' => env('EMAILING_ENABLED', false),
    'enforce_2fa' => env('ENFORCE_2FA', false),
    'invitation' => [
        'ttl_hours' => (int) env('INVITATION_TTL_HOURS', 72)
    ],
    'require_account_approval' => env('REQUIRE_ACCOUNT_APPROVAL', false),
    'color_theme' => env('COLOR_THEME', 'Chimera'),

    'map' => [
        'center' => [
            'lat' => env('MAP_CENTER_LAT', 9.005401),
            'lon' => env('MAP_CENTER_LON', 38.763611),
        ],
        'starting_zoom' => env('MAP_STARTING_ZOOM', 6),
        'min_zoom' => env('MAP_MIN_ZOOM', 6),
    ],

    'featured_stories' => env('FEATURED_STORIES', 2),
    'fact_tables' => ['census_facts' => 'Census facts' /*'population_facts' => 'Population characteristics', 'housing_facts' => 'Housing characteristics'*/],
    'shapefile' => [
        'import_chunk_size' => (int) env('SHAPEFILE_IMPORT_CHUNK_SIZE', 500),
        'stop_import_if_orphans_found' => env('SHAPEFILE_STOP_IMPORT_IF_ORPHANS_FOUND', true),
    ],
];

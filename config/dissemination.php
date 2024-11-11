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
        'ttl_hours' => env('INVITATION_TTL_HOURS', 72)
    ],
    'require_account_approval' => env('REQUIRE_ACCOUNT_APPROVAL', false),
    'color_theme' => env('COLOR_THEME', 'Chimera'),
    'area' => [
        'map' => [
            'center' => [env('MAP_CENTER_LAT', 9.005401), env('MAP_CENTER_LON', 38.763611)],
            'starting_zoom' => env('MAP_STARTING_ZOOM', 6),
            'min_zoom' => env('MAP_MIN_ZOOM', 6),
            'ignore_orphan_areas' => env('IGNORE_ORPHAN_AREAS', false),
        ],
    ],
    'cache' => [
        //'enabled' => env('CACHE_ENABLED', false),
        'ttl' => env('CACHE_TTL_SECONDS', 60 * 5),
        'tags' => [],
    ],

    'schema' => env('DB_SCHEMA', 'data'),
    'featured_stories' => env('FEATURED_STORIES', 2),
    'fact_tables' => ['population_facts' => 'Population facts', 'housing_facts' => 'Housing facts'],
    'hosting' => strtolower(env('HOSTING') ?? ''),
    'shapefile' => [
        'import_chunk_size' => (int) env('SHAPEFILE_IMPORT_CHUNK_SIZE', 500),
        'stop_import_if_orphans_found' => env('SHAPEFILE_STOP_IMPORT_IF_ORPHANS_FOUND', true),
    ],
];

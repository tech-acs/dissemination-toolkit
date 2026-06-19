<?php

namespace Uneca\DisseminationToolkit\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Filesystem\Filesystem;
use Laravel\Fortify\FortifyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Permission\PermissionServiceProvider;
use Uneca\DisseminationToolkit\DisseminationToolkitServiceProvider;
use Uneca\DisseminationToolkit\Tests\Database\Seeders\TestDatabaseSeeder;

class TestCase extends Orchestra
{
    private static bool $migrationsPrepared = false;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Uneca\\DisseminationToolkit\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->prepareMigrationsOnce();

        $this->artisan('migrate:fresh')->run();
        $this->seed(TestDatabaseSeeder::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            FortifyServiceProvider::class,
            PermissionServiceProvider::class,
            DisseminationToolkitServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('app.env', 'testing');

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'testing'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'postgres'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        $app['config']->set('auth.providers.users.model', \Uneca\DisseminationToolkit\Models\User::class);
        $app['config']->set('auth.passwords.users.provider', 'users');

        $app['config']->set('cache.default', 'array');
        $app['config']->set('queue.default', 'sync');
        $app['config']->set('session.driver', 'array');

        $app['config']->set('view.paths', [
            __DIR__.'/resources/views',
            resource_path('views'),
        ]);

        $app['config']->set('auth.guards.sanctum', [
            'driver' => 'session',
            'provider' => 'users',
        ]);
    }

    private function prepareMigrationsOnce(): void
    {
        if (self::$migrationsPrepared) {
            return;
        }

        $fs = new Filesystem;
        $migrationsPath = database_path('migrations');
        $fs->ensureDirectoryExists($migrationsPath);
        $fs->cleanDirectory($migrationsPath);

        $sources = [
            __DIR__.'/../vendor/laravel/jetstream/database/migrations/0001_01_01_000000_create_users_table.php',
            __DIR__.'/../vendor/laravel/fortify/database/migrations/2014_10_12_200000_add_two_factor_columns_to_users_table.php',
            __DIR__.'/../vendor/laravel/passkeys/database/migrations/2024_01_01_000000_create_passkeys_table.php',
            __DIR__.'/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub',
        ];

        foreach ($sources as $source) {
            if (! file_exists($source)) {
                continue;
            }
            $destination = $migrationsPath.'/'.basename($source, '.stub');
            $fs->copy($source, $destination);
        }

        $this->artisan('vendor:publish', [
            '--tag' => 'dissemination-migrations',
            '--force' => true,
        ])->run();

        self::$migrationsPrepared = true;
    }
}

<?php

use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Topic;

// ---------------------------------------------------------------------------
// Authentication
// ---------------------------------------------------------------------------

it('returns 401 for unauthenticated api requests', function () {
    $this->getJson('/api/datasets')->assertUnauthorized();
    $this->getJson('/api/indicators')->assertUnauthorized();
    $this->getJson('/api/topics')->assertUnauthorized();
    $this->getJson('/api/dimensions')->assertUnauthorized();
});

it('allows authenticated users to access api endpoints', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets')
        ->assertOk();
});

// ---------------------------------------------------------------------------
// Datasets
// ---------------------------------------------------------------------------

it('lists only published datasets', function () {
    Dataset::factory()->count(3)->create(['published' => true]);
    Dataset::factory()->create(['published' => false]);

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets');

    $response->assertOk();
    expect(count($response->json('data')))->toBe(3);
});

it('returns dataset in json:api format', function () {
    $dataset = Dataset::factory()->create(['published' => true]);

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'description',
                    'code',
                    'published',
                ],
                'links' => [
                    'self',
                ],
            ],
            'jsonapi' => [
                'version',
            ],
        ]);

    expect($response->json('data.type'))->toBe('datasets');
    expect($response->json('data.id'))->toBe((string) $dataset->id);
});

it('returns 404 for unpublished dataset', function () {
    $dataset = Dataset::factory()->create(['published' => false]);

    $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id)
        ->assertNotFound();
});

it('supports compound documents for datasets', function () {
    $dataset = Dataset::factory()->create(['published' => true]);
    $topic = Topic::factory()->create();
    $indicator = Indicator::factory()->create();
    $dataset->topics()->attach($topic);
    $dataset->indicators()->attach($indicator);

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id . '?include=topics,indicators');

    $response->assertOk();
    expect($response->json('data.relationships'))->toHaveKeys(['topics', 'indicators']);
    expect($response->json('included'))->not->toBeNull();
});

it('supports sparse fieldsets for datasets', function () {
    $dataset = Dataset::factory()->create(['published' => true]);

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id . '?fields[datasets]=code,published');

    $response->assertOk();
    $attributes = $response->json('data.attributes');
    expect($attributes)->toHaveKeys(['code', 'published']);
    expect($attributes)->not->toHaveKey('name');
});

it('paginates datasets', function () {
    Dataset::factory()->count(5)->create(['published' => true]);

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets?page[size]=2');

    $response->assertOk();
    expect(count($response->json('data')))->toBe(2);
});

it('returns observations endpoint for published dataset', function () {
    $dataset = Dataset::factory()->create(['published' => true]);

    $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id . '/observations')
        ->assertOk();
});

it('returns metadata for published dataset', function () {
    $dataset = Dataset::factory()->create(['published' => true]);

    $showResponse = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id);

    $metaResponse = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id . '/metadata');

    $metaResponse->assertOk()
        ->assertJsonStructure([
            'meta' => [
                'name',
                'provenance',
                'coverage',
                'structure',
            ],
            'jsonapi',
        ]);
});

it('returns 404 for observations of unpublished dataset', function () {
    $dataset = Dataset::factory()->create(['published' => false]);

    $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/datasets/' . $dataset->id . '/observations')
        ->assertNotFound();
});

it('downloads dataset as csv', function () {
    $dataset = Dataset::factory()->create(['published' => true]);

    $this->actingAs(adminUser(), 'sanctum')
        ->get('/api/datasets/' . $dataset->id . '/download')
        ->assertOk()
        ->assertHeaderContains('Content-Type', 'text/csv');
});

// ---------------------------------------------------------------------------
// Indicators
// ---------------------------------------------------------------------------

it('lists indicators', function () {
    Indicator::factory()->count(3)->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/indicators');

    $response->assertOk();
    expect(count($response->json('data')))->toBe(3);
});

it('shows single indicator in json:api format', function () {
    $indicator = Indicator::factory()->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/indicators/' . $indicator->id);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => ['name', 'description'],
                'links',
            ],
            'jsonapi',
        ]);

    expect($response->json('data.type'))->toBe('indicators');
});

// ---------------------------------------------------------------------------
// Topics
// ---------------------------------------------------------------------------

it('lists topics', function () {
    Topic::factory()->count(3)->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/topics');

    $response->assertOk();
    expect(count($response->json('data')))->toBe(3);
});

it('shows single topic in json:api format', function () {
    $topic = Topic::factory()->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/topics/' . $topic->id);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => ['name', 'description', 'code', 'rank'],
                'links',
            ],
            'jsonapi',
        ]);

    expect($response->json('data.type'))->toBe('topics');
});

// ---------------------------------------------------------------------------
// Dimensions
// ---------------------------------------------------------------------------

it('lists dimensions', function () {
    Dimension::factory()->count(3)->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/dimensions');

    $response->assertOk();
    expect(count($response->json('data')))->toBe(3);
});

it('shows single dimension in json:api format', function () {
    $dimension = Dimension::factory()->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/dimensions/' . $dimension->id);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => ['name', 'description', 'code', 'table_name'],
                'links',
            ],
            'jsonapi',
        ]);

    expect($response->json('data.type'))->toBe('dimensions');
});

it('returns dimension values', function () {
    $dimension = Dimension::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->getJson('/api/dimensions/' . $dimension->id . '/values')
        ->assertOk()
        ->assertJsonStructure([
            'meta' => ['values'],
            'jsonapi',
        ]);
});

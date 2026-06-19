<?php

use App\Models\User;
use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Enums\SortDirection;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;

it('can be created with an attribute', function () {
    $column = new SmartTableColumn('name');

    expect($column->attribute)->toBe('name')
        ->and($column->getLabel())->toBe('NAME');
});

it('uses a custom label', function () {
    $column = (new SmartTableColumn('name'))->setLabel('Full Name');

    expect($column->getLabel())->toBe('FULL NAME');
});

it('can be marked as sortable', function () {
    $column = (new SmartTableColumn('name'))->sortable();

    expect($column->isSortable())->toBeTrue();
});

it('can set table cell classes', function () {
    $column = (new SmartTableColumn('name'))->tdClasses('font-bold');

    expect($column->classes)->toBe('font-bold');
});

it('can customize its blade template', function () {
    $template = '<strong>{{ $row[$column->attribute] }}</strong>';
    $column = (new SmartTableColumn('name'))->setBladeTemplate($template);

    expect($column->getBladeTemplate())->toBe($template);
});

it('reverses sort direction when it is the active sorted column', function () {
    $request = Request::create('/', 'GET', [
        'sort_by' => 'name',
        'sort_direction' => SortDirection::ASC->value,
    ]);

    $table = new SmartTableData(User::query(), $request);
    $column = (new SmartTableColumn('name'))->sortable();
    $table->columns([$column])->sortBy('name');

    expect($column->reverseSortDirection())->toBe('DESC');
});

it('defaults reverse sort direction to ascending when not active', function () {
    $request = Request::create('/', 'GET');

    $table = new SmartTableData(User::query(), $request);
    $column = (new SmartTableColumn('name'))->sortable();
    $table->columns([$column])->sortBy('email');

    expect($column->reverseSortDirection())->toBe('ASC');
});

it('renders a sort icon when sortable', function () {
    $request = Request::create('/', 'GET');

    $table = new SmartTableData(User::query(), $request);
    $column = (new SmartTableColumn('name'))->sortable();
    $table->columns([$column])->sortBy('name');

    expect($column->sortIcon())->toBeString();
});

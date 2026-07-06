@props([
    'inputName' => 'published',
    'value', 'route',
    'onAction' => 'Publish',
    'offAction' => 'Unpublish',
])
<form action="{{ $route }}" method="POST" class="inline">
    @csrf
    @method('PATCH')
    <input type="hidden" name="{{ $inputName }}" value="{{ ! $value }}">
    <button @class([
        'text-gray-500' => $value,
        'text-green-600' => ! $value,
    ])>{{ $value ? __($offAction) : __($onAction) }}</button>
</form>
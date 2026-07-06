@props(['directives' => []])
@if ($directives['input_control'] == 'select')
    <select {{ $attributes }} class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach($directives['options'] ?? ['false' => 'No', 'true' => 'Yes'] as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
@else
    <x-input {{ $attributes }} type="{{ $directives['input_control'] }}" />
@endif

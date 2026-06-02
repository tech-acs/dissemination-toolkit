@props(['var' => 'block', 'visualizations' => []])

<div x-show="{{ $var }}.type === 'visualization'" class="p-4 pt-6">
    <select x-model="{{ $var }}.data.viz_id"
            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <option value="">{{ __('Select a visualization') }}</option>
        @foreach($visualizations as $viz)
            <option value="{{ $viz->id }}">{{ $viz->title }} ({{ $viz->type }})</option>
        @endforeach
    </select>
</div>

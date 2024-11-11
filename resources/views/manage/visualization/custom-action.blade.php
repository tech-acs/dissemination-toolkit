<a href="{{route('visualization.show', $row->id)}}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ __('Preview') }}</a>
@if($row->is_owner)
    <span class="text-gray-400 px-1">|</span>
    <a href="{{route('manage.viz-builder.' . strtolower($row->type) . '.edit', ['viz' => $row->id])}}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
    {{--<span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.viz-builder.chart.design') }}?viz-id={{ $row->id }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Design') }}</a>--}}
    <span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.visualization.destroy', $row->id) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
@endif

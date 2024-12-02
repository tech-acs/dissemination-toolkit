<a href="{{route('visualization.show', $row->id)}}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ __('Preview') }}</a>
@if($row->is_owner)
    @can('create-and-edit:viz')
        <span class="text-gray-400 px-1">|</span>
        <a href="{{route('manage.viz-builder.' . strtolower($row->type) . '.edit', ['viz' => $row->id])}}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
    @endcan
    @can('delete:viz')
        <span class="text-gray-400 px-1">|</span>
        <a href="{{ route('manage.visualization.destroy', $row->id) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
    @endcan
@endif

@can('publish-and-unpublish:viz')
    <span class="text-gray-400 px-1">|</span>
    <x-dissemination::toggle :value="$row->published" route="{{ route('manage.visualization.change-published-status', $row->id) }}" />
@endcan
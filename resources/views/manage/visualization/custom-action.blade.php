<a href="{{route('visualization.show', $row->id)}}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ __('Preview') }}</a>
@if($row->is_owner || ! $row->restricted)
    @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::EDIT_VIZ)
        <span class="text-gray-400 px-1">|</span>
        <a href="{{route('manage.viz-builder.' . strtolower($row->type) . '.edit', ['viz' => $row->id])}}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
    @endcan
    @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::DELETE_VIZ)
        <span class="text-gray-400 px-1">|</span>
        <a href="{{ route('manage.visualization.destroy', $row->id) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
    @endcan
@endif
@if($row->is_owner)
    <span class="text-gray-400 px-1">|</span>
    <x-dissemination::toggle inputName="restricted" :value="$row->restricted" onAction="Restrict" offAction="Share" route="{{ route('manage.visualization.change-restricted-status', $row->id) }}" />
@endif
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::PUBLISH_AND_UNPUBLISH_VIZ)
    <span class="text-gray-400 px-1">|</span>
    <x-dissemination::toggle :value="$row->published" route="{{ route('manage.visualization.change-published-status', $row->id) }}" />
@endcan
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::EDIT_DOCUMENT)
    <a href="{{ route('manage.document.edit', $row) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
@endcan
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::PUBLISH_AND_UNPUBLISH_DOCUMENT)
    <span class="text-gray-400 px-1">|</span>
    <x-dissemination::toggle :value="$row->published" route="{{ route('manage.document.change-published-status', $row->id) }}" />
@endcan
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::DELETE_DOCUMENT)
    <span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.document.destroy', $row) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
@endcan



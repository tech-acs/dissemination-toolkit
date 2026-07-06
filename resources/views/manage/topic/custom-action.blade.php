@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::EDIT_TOPIC)
    <a href="{{ route('manage.topic.edit', $row) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
@endcan
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::DELETE_TOPIC)
    <span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.topic.destroy', $row) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
@endcan



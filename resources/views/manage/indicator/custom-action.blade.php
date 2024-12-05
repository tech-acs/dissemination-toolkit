@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::EDIT_INDICATOR)
    <a href="{{ route('manage.indicator.edit', $row) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
@endcan
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::DELETE_INDICATOR)
    <span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.indicator.destroy', $row) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
@endcan



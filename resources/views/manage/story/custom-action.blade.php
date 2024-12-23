<a href="{{ route('story.show', $row) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Preview') }}</a>
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::CREATE_STORY)
    <span class="text-gray-400 px-1">|</span>
    <a href="{{route('manage.story.duplicate', $row->id)}}" class="text-amber-600 hover:text-amber-900">{{ __('Duplicate') }}</a>
@endcan
@if($row->is_owner || ! $row->restricted)
    @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::EDIT_STORY)
        <span class="text-gray-400 px-1">|</span>
        <a href="{{ route('manage.story.edit', $row->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
        <span class="text-gray-400 px-1">|</span>
        <a href="{{route('manage.story-builder.edit', $row->id)}}" class="text-green-600 hover:text-green-900">{{ __('Design') }}</a>
    @endcan
    @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::DELETE_STORY)
        <span class="text-gray-400 px-1">|</span>
        <a href="{{ route('manage.story.destroy', $row->id) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
    @endcan

@endif
@if($row->is_owner)
    <span class="text-gray-400 px-1">|</span>
    <x-dissemination::toggle inputName="restricted" :value="$row->restricted" onAction="Restrict" offAction="Share" route="{{ route('manage.story.change-restricted-status', $row->id) }}" />
@endif
@can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::PUBLISH_AND_UNPUBLISH_STORY)
    <span class="text-gray-400 px-1">|</span>
    <x-dissemination::toggle :value="$row->published" route="{{ route('manage.story.change-published-status', $row->id) }}" />
@endcan
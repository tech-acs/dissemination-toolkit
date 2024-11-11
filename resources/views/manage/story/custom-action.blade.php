<a href="{{ route('story.show', $row) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
<span class="text-gray-400 px-1">|</span>
<a href="{{route('manage.story.duplicate', $row->id)}}" class="text-amber-600 hover:text-amber-900">{{ __('Duplicate') }}</a>
@if($row->is_owner)
    <span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.story.edit', $row->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
    <span class="text-gray-400 px-1">|</span>
    <a href="{{route('manage.story-builder.edit', $row->id)}}" class="text-green-600 hover:text-green-900">{{ __('Design') }}</a>
    <span class="text-gray-400 px-1">|</span>
    <a href="{{ route('manage.story.destroy', $row->id) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
@endif

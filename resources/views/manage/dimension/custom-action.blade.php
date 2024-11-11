<a href="{{ route('manage.dimension.edit', $row) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
<span class="text-gray-400 px-1">|</span>
@if($row->table_created_at)
    <a href="{{ route('manage.dimension.values.index', $row->id) }}" class="text-sky-600 hover:text-sky-900">{{ __('Values') }}</a>
@else
    <a href="{{ route('manage.dimension.create-table', ['id' => $row->id]) }}" class="text-green-600 hover:text-green-900">{{ __('Create Table') }}</a>
@endif
<span class="text-gray-400 px-1">|</span>
<a href="{{ route('manage.dimension.destroy', $row) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>

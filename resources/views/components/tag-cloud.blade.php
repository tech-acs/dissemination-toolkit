@props([
    'tags' => []
])
<div class="space-x-2">
    @foreach($tags as $tag)
        <a href="?tag={{ $tag->id }}" class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
            {{ $tag->name }}
        </a>
    @endforeach
</div>

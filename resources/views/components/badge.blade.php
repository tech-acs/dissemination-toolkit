@props([
    'count'
])
<span class="inline-flex items-center gap-x-1.5 rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-700">
  <span class="font-semibold p-1/2 text-indigo-800">{{ $count }}</span>
  {{ $slot }}
</span>

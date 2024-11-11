@props(['icon' => 'none'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'group border border-indigo-700 px-2 h-7 uppercase hover:bg-indigo-700 hover:text-white rounded-md shadow-sm bg-white cursor-pointer inline-flex items-center gap-x-2 text-xs font-semibold text-blue-700']) }} class="">
    @if($icon === 'save')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] text-blue-800 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
            <path d="M14 4l0 4l-6 0l0 -4"></path>
        </svg>
    @elseif($icon === 'embed')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] text-blue-800 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M7 8l-4 4l4 4"></path>
            <path d="M17 8l4 4l-4 4"></path>
            <path d="M14 4l-4 16"></path>
        </svg>
    @elseif($icon === 'reset')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] text-blue-800 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
            <path d="M14 4l0 4l-6 0l0 -4"></path>
        </svg>
    @elseif($icon === 'download')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] text-blue-800 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
            <path d="M7 11l5 5l5 -5"></path>
            <path d="M12 4l0 12"></path>
        </svg>
    @elseif($icon === 'download-xls')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] text-blue-800 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4"></path>
            <path d="M4 15l4 6"></path>
            <path d="M4 21l4 -6"></path>
            <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75"></path>
            <path d="M11 15v6h3"></path>
        </svg>
    @endif
    {{ $slot }}
</button>

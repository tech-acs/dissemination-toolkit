@props([
    'var' => 'block',
    'index' => null,
    'containerId' => null,
    'column' => null,
    'ci' => null,
])

@php
    $isChild = $containerId !== null;
    $maxHeight = $isChild ? 'max-h-32' : 'max-h-48';
    $iconSize = $isChild ? 'w-3 h-3' : 'w-3.5 h-3.5';
    $fileInputSize = $isChild ? 'text-xs' : 'text-sm';
    $padded = $isChild ? '' : 'p-4 pt-6 ';
@endphp

<div x-show="{{ $var }}.type === 'image'" class="{{ $padded }}space-y-2">
    @if($isChild)
    <input type="file" accept="image/*" x-on:change="uploadChildImage($el, {{ $containerId }}, '{{ $column }}', {{ $ci }})"
           class="block w-full {{ $fileInputSize }} text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:{{ $fileInputSize }} file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
    @else
    <input type="file" accept="image/*" x-on:change="uploadImage($el, {{ $index }})"
           class="block w-full {{ $fileInputSize }} text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:{{ $fileInputSize }} file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
    @endif

    <template x-if="{{ $var }}.data.src">
        <div class="flex flex-col" :class="{
            'items-center': !{{ $var }}.data.alignment || {{ $var }}.data.alignment === 'center',
            'items-start': {{ $var }}.data.alignment === 'left',
            'items-end': {{ $var }}.data.alignment === 'right',
            '': {{ $var }}.data.alignment === 'full'
        }">
            <div class="flex items-center gap-1">
                <button @click="{{ $var }}.data.alignment = 'left'"
                        :class="{{ $var }}.data.alignment === 'left' ? 'text-indigo-600' : 'text-gray-400'"
                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                        title="{{ __('Align left') }}">
                    <svg class="{{ $iconSize }}" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="1" y="12" width="8" height="2" rx="1"/></svg>
                </button>
                <button @click="{{ $var }}.data.alignment = 'center'"
                        :class="(!{{ $var }}.data.alignment || {{ $var }}.data.alignment === 'center') ? 'text-indigo-600' : 'text-gray-400'"
                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                        title="{{ __('Align center') }}">
                    <svg class="{{ $iconSize }}" viewBox="0 0 16 16" fill="currentColor"><rect x="3" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="3" y="12" width="10" height="2" rx="1"/></svg>
                </button>
                <button @click="{{ $var }}.data.alignment = 'right'"
                        :class="{{ $var }}.data.alignment === 'right' ? 'text-indigo-600' : 'text-gray-400'"
                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                        title="{{ __('Align right') }}">
                    <svg class="{{ $iconSize }}" viewBox="0 0 16 16" fill="currentColor"><rect x="5" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="7" y="12" width="8" height="2" rx="1"/></svg>
                </button>
                <button @click="{{ $var }}.data.alignment = 'full'"
                        :class="{{ $var }}.data.alignment === 'full' ? 'text-indigo-600' : 'text-gray-400'"
                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                        title="{{ __('Full width') }}">
                    <svg class="{{ $iconSize }}" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="5" width="14" height="6" rx="1"/></svg>
                </button>
            </div>

            <img :src="{{ $var }}.data.src"
                 class="{{ $maxHeight }} rounded block"
                 :class="{ 'w-full max-h-none': {{ $var }}.data.alignment === 'full' }" />

            <input type="text" x-model="{{ $var }}.data.caption" placeholder="{{ __('Caption') }}"
                   class="border-gray-300 rounded-md {{ $fileInputSize }} shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                   :class="{
                       'text-center': !{{ $var }}.data.alignment || {{ $var }}.data.alignment === 'center',
                       'text-left': {{ $var }}.data.alignment === 'left' || {{ $var }}.data.alignment === 'full',
                       'text-right': {{ $var }}.data.alignment === 'right'
                   }"
                   :style="{ width: {{ $var }}.data.alignment === 'full' ? '100%' : Math.max(20, ({{ $var }}.data.caption || '').length + 2) + 'ch' }" />
        </div>
    </template>
</div>

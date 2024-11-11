@props([
    'name' => null,
])
@pushonce('styles')
    @vite(['resources/css/markdown-editor.css'])
@endpushonce
<div>
    <textarea
        x-cloak
        name="{{ $name }}"
        x-data="{easyMDE: null}"
        x-init="this.easyMDE = new EasyMDE({element: $el, minHeight: '100px', forceSync: true});"
    >{{ old($name, $slot) }}</textarea>
</div>

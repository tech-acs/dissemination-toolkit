@props([
    'name' => 'tags',
    'value' => '[]'
])
<div x-data="{tags: {{ $value }} }" {!! $attributes->merge(['class' => 'flex flex-col gap-1']) !!}>
    <input type="hidden" name="{{ $name }}" x-model="tags">
    <div class="flex items-center gap-2">
        <x-input type="text" x-ref="tag" class="py-2" maxlength="25" />
        <x-button x-on:click.prevent="let tag = $refs.tag.value; if ((tag.indexOf(',') < 0) && tag.trim() && ! tags.includes(tag) ) { tags.push(tag); $refs.tag.value = ''; }">
            {{ __('Add') }}
        </x-button>
    </div>
    <div class="flex gap-x-2">
        <template x-for="(tag, index) in tags" :key="index">
            <div class="border rounded-md p-1 px-2 bg-indigo-100 inline-block flex items-center">
                <span x-text="tag"></span>
                <a x-on:click="tags.splice(index, 1)" class="cursor-pointer inline-flex ml-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-6.489 5.8a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor"></path>
                    </svg>
                </a>
            </div>
        </template>
    </div>
</div>


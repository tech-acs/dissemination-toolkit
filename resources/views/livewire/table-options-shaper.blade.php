<div>
    {{--<h3 class="text-2xl pb-4">Table options</h3>--}}
    <h4 class="text-lg pb-2">Columns</h4>
    <div x-data="{ active: null }" x-cloak class="border border-gray-200 rounded-md divide-y text-sm mb-4">
        @foreach($options['columnDefs'] as $index => $columnDef)
        <div x-data="{
            id: {{ $index }},
            get expanded() {
                return this.active === this.id
            },
            set expanded(value) {
                this.active = value ? this.id : null
            },
        }">
            <h2>
                <button
                    type="button"
                    x-on:click="expanded = !expanded"
                    :aria-expanded="expanded"
                    class="flex w-full items-center justify-between px-4 py-2"
                >
                    <span>{{ $columnDef['headerName'] }}</span>
                    <span x-show="expanded" aria-hidden="true" class="ml-4">
                        <svg class="size-3 shrink-0 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </span>
                    <span x-show="!expanded" aria-hidden="true" class="ml-4">
                        <svg class="size-3 rotate-180 shrink-0 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </span>
                </button>
            </h2>

            <div x-show="expanded" x-collapse>
                <div class="px-6 pl-10 py-2 grid grid-cols-2 gap-y-1">
                    <div class="flex">
                        <input wire:model="options.columnDefs.{{ $index }}.hide" type="checkbox" class="h-4 w-4 mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        Hide
                    </div>
                    <div class="flex">
                        <input wire:model="options.columnDefs.{{ $index }}.filter" type="checkbox" class="h-4 w-4 mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        Filterable
                    </div>
                    <div class="flex">
                        <input wire:model="options.columnDefs.{{ $index }}.sortable" type="checkbox" class="h-4 w-4 mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        Sortable
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h4 class="text-lg pb-2">Default sorting</h4>
    <div class="space-y-3 mb-8 pl-2">
        <div class="text-sm leading-6">
            <div>
                {{ __('Sort by') }}
                <select wire:model="sortColumn" class="mt-1 mx-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value>-</option>
                    @foreach($options['columnDefs'] as $index => $columnDef)
                        <option class="p-1 rounded" value="{{ $index }}">
                            {{ $columnDef['headerName'] }}
                        </option>
                    @endforeach
                </select>
                column in
                <select wire:model="sortDirection" class="mt-1 mx-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option class="p-1 rounded" value="asc">ascending</option>
                    <option class="p-1 rounded" value="desc">descending</option>
                </select>
                order
            </div>
        </div>
    </div>

    <h4 class="text-lg pb-2">Other options</h4>
    <div class="space-y-3 mb-8 pl-2">
        @foreach($optionLabels as $option => $label)
            <div class="text-sm leading-6">
                <label>
                    <input wire:model="options.{{ $option }}" type="checkbox" class="size-4 mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>

    {{--@dump($options)--}}
    <button wire:click="apply" class="cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Apply
    </button>
</div>

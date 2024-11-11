<div>
    {{--<h3 class="text-2xl pb-4">Table options</h3>--}}
    <h4 class="text-lg pb-2">Columns</h4>

    <h4 class="text-lg pb-2">Default sorting</h4>
    <div class="space-y-3 mb-8 pl-2">
        <div class="text-sm leading-6">
            <div>
                {{ __('Sort by') }}
                <select wire:model="sortColumn" class="mt-1 mx-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value>-</option>
                    @foreach($options['columnDefs'] ?? [] as $index => $columnDef)
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

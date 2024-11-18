<div>
    <h4 class="text-lg pb-2">Map options</h4>
    <div class="space-y-3 mb-8 pl-4">
        @foreach($options as $key => $option)
            @if($option['type'] !== 'hidden')
                <div class="flex flex-col justify-start">
                    <div>{{ $option['label'] }}</div>
                    <div>
                        <select wire:model.live="optionValues.{{ $key }}" class="mt-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            {{--<option value></option>--}}
                            @foreach($option['options'] as $index => $label)
                                <option class="p-1 rounded" value="{{ $label }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        @endforeach
        <button wire:click="apply" class="cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Apply
        </button>
    </div>
</div>

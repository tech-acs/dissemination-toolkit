<form wire:submit="save" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="name" value="{{ __('Name') }} *" />
                <x-dissemination::multi-lang-input wire:model="form.name" />
                <x-input-error for="form.name" class="mt-2" />
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }}" class="inline" /><x-dissemination::locale-display />
                <x-dissemination::textarea wire:model="form.description" rows="3"></x-dissemination::textarea>
                <x-input-error for="form.description" class="mt-2" />
            </div>
            <div class="grid grid-cols-2">
                <div class="space-y-8">
                    <div>
                        <x-label for="indicators" value="{{ __('Indicators') }} *" />
                        <select size="5" wire:model="form.indicators" multiple class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            @foreach($indicatorsList ?? [] as $id => $name)
                                <option class="p-1 mb-1 rounded" value="{{ $id }}">
                                    {{ $name }}
                                </option>
                                {{--<option class="p-1 mb-1 rounded" value="{{ $indicator?->id }}" @selected( in_array($indicator->id, old('indicators', $dataset->indicators->pluck('id')->all() ?? [])) )>
                                    {{ $indicator->name }}
                                </option>--}}
                            @endforeach
                        </select>
                        <x-input-error for="form.indicators" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="max_area_level" value="{{ __('Data geographic granularity') }} *" />
                        <select wire:model="form.max_area_level" id="max_area_level" class="mt-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="">{{ __('Select geographic granularity') }}</option>
                            @foreach($areaLevelsList ?? [] as $id => $name)
                                <option class="p-1 rounded" value="{{ $id }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="form.max_area_level" class="mt-2" />
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <x-label for="fact_table" value="{{ __('Fact table') }} *" />
                        <select wire:model="form.fact_table" wire:change="updateDimensionsList()" id="fact_table" class="mt-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="">{{ __('Select fact table') }}</option>
                            @foreach($factTablesList ?? [] as $factTable => $name)
                                <option class="p-1 rounded" value="{{ $factTable }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="form.fact_table" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="dimensions" value="{{ __('Dimensions') }} *" />
                        <select wire:model="form.dimensions" size="5" id="dimensions" multiple class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            @foreach($dimensionsList ?? [] as $id => $name)
                                <option class="p-1 mb-1 rounded" value="{{ $id }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="form.dimensions" class="mt-2" />
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a onclick="window.history.back()">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button type="submit">{{ __('Submit') }}</x-button>
    </div>
</form>

<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="name" value="{{ __('Name') }} *" />
                <x-dissemination::multi-lang-input id="name" name="name" type="text" value="{{ old('name', $dataset->name ?? null) }}"/>
                <x-input-error for="name" class="mt-2" />
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }}" class="inline" /><x-dissemination::locale-display />
                <x-dissemination::textarea name="description" rows="3">{{ old('description', $dataset->description ?? null) }}</x-dissemination::textarea>
                <x-input-error for="description" class="mt-2" />
            </div>
            <div>
                <x-label for="code" value="{{ __('Code') }} *" />
                <x-input id="code" name="code" class="w-50 mt-1" value="{{ old('code', $dataset->code ?? null) }}" />
                <x-input-error for="code" class="mt-2" />
            </div>
            <div class="grid grid-cols-2">
                <div class="space-y-8">
                    <div>
                        <x-label for="indicators" value="{{ __('Indicators') }} *" />
                        <select size="5" id="indicators" name="indicators[]" multiple class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            @foreach($indicators ?? [] as $indicator)
                                <option class="p-1 mb-1 rounded" value="{{ $indicator?->id }}" @selected( in_array($indicator->id, old('indicators', $dataset->indicators->pluck('id')->all() ?? [])) )>
                                    {{ $indicator->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="indicators" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="max_area_level" value="{{ __('Data geographic granularity') }} *" />
                        <select id="max_area_level" name="max_area_level" class="mt-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="">{{ __('Select geographic granularity') }}</option>
                            @foreach($areaLevels ?? [] as $level => $name)
                                <option class="p-1 rounded" value="{{ $level }}" @selected($level == old('max_area_level', $dataset->max_area_level ?? -1))>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="max_area_level" class="mt-2" />
                    </div>

                    @if (count($factTables) > 1)
                        <div>
                            <x-label for="fact_table" value="{{ __('Fact table') }} *" />
                            <select id="fact_table" name="fact_table" class="mt-1 pr-10 space-y-1 text-sm p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">{{ __('Select fact table') }}</option>
                                @foreach($factTables ?? [] as $factTable => $name)
                                    <option class="p-1 rounded" value="{{ $factTable }}" @selected($factTable == old('fact_table', $dataset->fact_table ?? null))>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error for="fact_table" class="mt-2" />
                        </div>
                    @else
                        <input type="hidden" name="fact_table" value="{{ array_key_first($factTables) }}" class="invisible">
                    @endif

                    <div>
                        <x-label for="data_source" value="{{ __('Data source') }}" />
                        <x-input id="data_source" name="data_source" class="w-3/4 mt-1" value="{{ old('data_source', $dataset->data_source ?? null) }}" />
                        <x-input-error for="data_source" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="data_date" value="{{ __('Data date') }}" />
                        <x-input id="data_date" name="data_date" type="date" class="w-3/4 mt-1" value="{{ old('data_date', $dataset->data_date ?? null) }}" />
                        <x-input-error for="data_date" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="language" value="{{ __('Language') }}" />
                        <x-input id="language" name="language" class="w-3/4 mt-1" value="{{ old('language', $dataset->language ?? null) }}" />
                        <x-input-error for="language" class="mt-2" />
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="mt-2">
                        <x-label for="dimensions" value="{{ __('Dimensions') }} *" />
                        <select size="8" id="dimensions" name="dimensions[]" multiple class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            @foreach($dimensions ?? [] as $dimension)
                                <option class="p-1 mb-1 rounded" value="{{ $dimension?->id }}" @selected( in_array($dimension->id, old('dimensions', $dataset->dimensions->pluck('id')->all() ?? null)) )>
                                    {{ $dimension->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="dimensions" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="contributor" value="{{ __('Contributor') }}" />
                        <x-input id="contributor" name="contributor" class="w-3/4 mt-1" value="{{ old('contributor', $dataset->contributor ?? null) }}" />
                        <x-input-error for="contributor" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="format" value="{{ __('Format') }}" />
                        <x-input id="format" name="format" class="w-3/4 mt-1" value="{{ old('format', $dataset->format ?? null) }}" />
                        <x-input-error for="format" class="mt-2" />
                    </div>

                </div>

            </div>

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a onclick="window.history.back()">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>{{ __('Submit') }}</x-button>
    </div>
</div>

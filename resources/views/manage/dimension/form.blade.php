<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="name" value="{{ __('Name') }} *"/>
                <x-dissemination::multi-lang-input id="name" name="name" type="text" value="{{ old('name', $dimension->name ?? null) }}"/>
                <x-input-error for="name" class="mt-2"/>
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }}" class="inline"/>
                <x-dissemination::locale-display/>
                <x-dissemination::textarea name="description" rows="3">{{ old('description', $dimension->description ?? null) }}</x-dissemination::textarea>
                <x-input-error for="description" class="mt-2"/>
            </div>
            <div>
                <x-label for="code" value="{{ __('Code') }} *" />
                <x-input id="code" name="code" class="w-50 mt-1" value="{{ old('code', $dimension->code ?? null) }}" />
                <x-input-error for="code" class="mt-2" />
            </div>
            {{--<div>
                <x-label for="table_name" value="{{ __('Table name') }} *"/>
                @if (! ($dimension->table_created_at ?? null))
                    <x-input id="table_name" name="table_name" type="text" value="{{ old('table_name', $dimension->table_name ?? null) }}"/>
                @else
                    <x-input id="table_name" name="table_name" type="hidden" value="{{ old('table_name', $dimension->table_name ?? null) }}"/>
                    <div class="border p-2 mt-2 w-fit pr-16 bg-gray-100 text-gray-500 border-gray-300 rounded-md shadow-sm">{{ $dimension->table_name }}</div>
                @endif
                <x-input-error for="table_name" class="mt-2"/>
            </div>--}}
            <div>
                <x-label for="sorting_type" value="{{ __('Value sorting type') }}"/>
                <select id="sorting_type" name="sorting_type"
                        class="mt-1 pr-10 space-y-1 text-base p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    @foreach(\Uneca\DisseminationToolkit\Enums\SortingTypeEnum::cases() ?? [] as $sortingType)
                        <option class="p-2 rounded-md" value="{{ $sortingType->value }}"
                            @selected(old('sorting_type', $dimension->sorting_type) == $sortingType->value)
                        >
                            {{ $sortingType->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error for="sorting_type" class="mt-2"/>
            </div>

            @if (count($factTables) > 1)
                <div>
                    <x-label for="for" value="{{ __('Applies to') }} *"/>
                    <div class="p-2 space-y-2">
                        @foreach($factTables as $tableName => $label)
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input id="{{ $tableName }}" name="for[]" value="{{ $tableName }}" @checked(in_array($tableName, old('for', $dimension->for ?? []))) type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="{{ $tableName }}" class="text-gray-900">{{ $label }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <x-input-error for="for" class="mt-2"/>
                </div>
            @else
                <input id="{{ array_key_first($factTables) }}" name="for[]" value="{{ array_key_first($factTables) }}" @checked(true) type="checkbox" class="hidden">
            @endif
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.dimension.index') }}">{{ __('Cancel') }}</a>
        </x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

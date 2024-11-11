<div class="shadow sm:rounded-md sm:overflow-hidden mt-4">
    @if($importError)
        <div class="rounded-md bg-red-100 p-4 py-3 my-2 border border-red-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: x-circle -->
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"></path>
                    </svg>
                </div>
                <div class="ml-3  text-sm text-red-700">
                    <p class="mb-1 font-semibold">{!! $importError !!}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        {{--@if ($message)
            <div class="rounded-md bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: mini/information-circle -->
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-blue-700">{{ $message }}</p>
                        <p class="mt-3 text-sm md:mt-0 md:ml-6"></p>
                    </div>
                </div>
            </div>
        @endif--}}
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Spreadsheet') }}</h3>
                <p class="mt-2 text-sm text-gray-500">{{ __('The spreadsheet must include all required columns as specified in the dataset') }}</p>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <div>
                    <div class="flex flex-grow items-center">
                        <label for="spreadsheet" class="flex justify-between w-2/3 rounded-md sm:text-sm border border-gray-300">
                            <span wire:loading.remove wire:target="spreadsheet" id="file_label" class="my-auto pl-4 text-gray-700">{{ $spreadsheet?->getClientOriginalName() ?? "Choose your file" }}</span>
                            <span wire:loading wire:target="spreadsheet" class="my-auto pl-4 text-gray-700">Uploading...</span>
                            <div class="relative inline-flex items-center hover:bg-gray-100 cursor-pointer space-x-2 px-4 py-2 border-0 border-l rounded-r-md border-gray-300 text-sm font-medium text-gray-700 bg-gray-50">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path></svg>
                                <span>Browse</span>
                            </div>
                        </label>
                        <input type="file" id="spreadsheet" name="spreadsheet" wire:model.live="spreadsheet" onchange="document.getElementById('file_label').innerText=this.files[0].name;" class="hidden">
                        @if ($fileAccepted)
                            <x-dissemination::icon.accepted />
                        @endif
                        @if($errors->has('spreadsheet'))
                            <x-dissemination::icon.rejected />
                        @endif
                    </div>
                </div>
                @if($errors->has('spreadsheet'))
                    <x-input-error for="spreadsheet" />
                @else
                    <div class="text-xs text-gray-500 mt-1">
                        You must upload a spreadsheet (csv or xlsx)
                    </div>
                @endif
            </div>

            <div class="col-span-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Column mapping') }}</h3>
                <p class="mt-3 text-sm text-gray-500">
                    The file is expected to have at least <b>{{ $this->dataset->dimensions_count + $this->dataset->indicators_count + 1 }} columns</b>.
                    <b>{{ $this->dataset->dimensions_count }} columns</b> for the dimensions, <b>{{ $this->dataset->indicators_count }} columns</b> for the indicators
                    and a <b>geography</b> column.
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Please map the columns of your file to their corresponding indicators, dimensions and geography.
                </p>
            </div>

            <div class="mt-5 col-span-1">
                <table>
                    <thead>
                        <tr class="border-b">
                            <th scope="col" class="p-2 text-right text-sm font-semibold text-gray-900">{{ __('Indicator') }}</th>
                            <th scope="col" class="p-2 text-center text-sm font-semibold text-gray-900">{{ __('Column in file') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($indicators as $indicator)
                        <tr>
                            <td class="p-2 whitespace-nowrap text-sm text-right text-gray-900">{{ $indicator->name }}</td>
                            <td class="p-3 align-top whitespace-nowrap text-sm text-gray-500">
                                <select wire:model.live="columnMapping.indicators.{{ $indicator->id }}" class="w-full pr-8 rounded-md border border-gray-300 bg-white px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Select column') }}</option>
                                    @foreach($columnHeaders as $column)
                                        <option value="{{ $column }}">{{ $column }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="columnMapping.indicators.{{ $indicator->id }}" class="text-xs" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">You have not associated any indicators with this dataset</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5 col-span-1">
                <table>
                    <thead>
                    <tr class="border-b">
                        <th scope="col" class="p-2 text-right text-sm font-semibold text-gray-900">{{ __('Dimension') }}</th>
                        <th scope="col" class="p-2 text-center text-sm font-semibold text-gray-900">{{ __('Column in file') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dimensions as $dimension)
                        <tr>
                            <td class="p-2 whitespace-nowrap text-sm text-right text-gray-900 sm:pl-6 md:pl-0">{{ $dimension->name }}</td>
                            <td class="p-2 align-top whitespace-nowrap text-sm text-gray-500">
                                <select wire:model.live="columnMapping.dimensions.{{ $dimension->id }}" class="w-full pr-8 rounded-md border border-gray-300 bg-white px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Select column') }}</option>
                                    @foreach($columnHeaders as $column)
                                        <option value="{{ $column }}">{{ $column }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="columnMapping.dimensions.{{ $dimension->id }}" class="text-xs" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">You have not associated any dimensions with this dataset</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5 col-span-1">
                <table>
                    <thead>
                    <tr class="border-b">
                        <th scope="col" class="p-2 text-right text-sm font-semibold text-gray-900">{{ __('Other fields') }}</th>
                        <th scope="col" class="p-2 text-center text-sm font-semibold text-gray-900">{{ __('Column in file') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="p-2 whitespace-nowrap text-sm text-right text-gray-900">Geography</td>
                        <td class="p-3 align-top whitespace-nowrap text-sm text-gray-500">
                            <select wire:model.live="columnMapping.others.geography" class="w-full pr-8 rounded-md border border-gray-300 bg-white px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option value="">{{ __('Select column') }}</option>
                                @foreach($columnHeaders as $column)
                                    <option value="{{ $column }}">{{ $column }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="columnMapping.others.geography" class="text-xs" />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <a href="{{ route('manage.area.index') }}"><x-secondary-button class="mr-2">{{ __('Cancel') }}</x-secondary-button></a>
        <x-button wire:click="import()">
            {{ __('Import') }}
        </x-button>
    </div>
</div>


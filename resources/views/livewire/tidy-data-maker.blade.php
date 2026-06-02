<div class="p-6 max-w-7xl mx-auto space-y-6 bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold mb-2">1. Paste wide format data (CSV/TSV) </h2>
                <span class="text-sm text-gray-400">Allowed delimiters: Comma ( , )  Tab ( \t )  Semi-colon ( ; )</span>
                <textarea
                    wire:model.live.debounce.300ms="rawData"
                    class="w-full h-64 p-3 border border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Paste tabular data here (e.g. from Excel)..."></textarea>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-2">2. Select columns to melt/pivot</h2>
                <div class="bg-gray-50 p-5 rounded border border-gray-200 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-3">Checked columns will be melted into variable/value rows. Unchecked columns remain as columns.
                            If any are named as one of your dimensions, "Area" or "Geography" then they will be <b>codified</b> (name/label replaced by code).</p>

                        <div class="flex flex-wrap gap-4 bg-white p-3 border rounded shadow-inner">
                            @forelse($columns as $column)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        wire:model.live="checkedColumns"
                                        value="{{ $column }}"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <span class="text-sm font-medium">{{ $column }}</span>
                                </label>
                            @empty
                                <p class="text-base text-red-500 mb-3">When you paste data in the box above, the identified columns will be listed here.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New "Dimension" column name</label>
                            <select wire:model.live="nameColumn" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select a dimension...</option>
                                @foreach($this->dimensions as $dimension)
                                    <option value="{{ $dimension }}">{{ $dimension }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New "Value" column name</label>
                            <select wire:model.live="valueColumn" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select an indicator...</option>
                                @foreach($this->indicators as $indicator)
                                    <option value="{{ $indicator }}">{{ $indicator }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            @if(count($codificationWarnings) > 0)
                <div class="rounded-md bg-yellow-50 border border-yellow-200 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-yellow-700">
                            <p class="font-medium">{{ __('Codification incomplete') }}</p>
                            <p>{{ __('The following values could not be mapped to codes and will keep their original labels in the Codified CSV:') }}</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($codificationWarnings as $warning)
                                    <li>{{ $warning }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div>
            <h2 class="text-xl font-bold mb-2">3. Tidy data (long format)</h2>
            <div class="space-y-6">

                @if(count($tidiedData) > 0)
                    <textarea
                        readonly
                        class="w-full h-64 p-3 border border-green-300 bg-green-50 rounded shadow-sm text-sm font-mono whitespace-pre"
                    >{{ $csvOutput }}</textarea>

                    <div>
                        <div class="mb-3 flex justify-between">
                            <x-secondary-button wire:click="downloadCodifiedCsv">{{ __('Download Codified CSV') }}</x-secondary-button>
                            <x-secondary-button wire:click="downloadCsv">{{ __('Download CSV') }}</x-secondary-button>
                        </div>
                        <div class="overflow-x-auto border rounded border-gray-200 max-h-64">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    @foreach(array_keys($tidiedData[0]) as $header)
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider bg-gray-100">
                                            {{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Limiting to 100 rows in HTML just to not crash the browser on massive datasets --}}
                                @foreach(array_slice($tidiedData, 0, 100) as $row)
                                    <tr class="hover:bg-gray-50">
                                        @foreach($row as $cell)
                                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-600">{{ $cell }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if(count($tidiedData) > 100)
                                <div class="p-3 text-center text-sm text-gray-500 bg-gray-50 border-t">
                                    Showing first 100 rows of {{ count($tidiedData) }} total rows. Use the text area above to copy all data.
                                </div>
                            @endif
                        </div>
                    </div>

                @else
                    <div class="h-64 border-2 border-dashed border-gray-300 rounded flex items-center justify-center bg-gray-50 text-gray-400">
                        <p>Select columns on the left to see the tidy result here.</p>
                    </div>
                @endif
            </div>
        </div>


    </div>
</div>

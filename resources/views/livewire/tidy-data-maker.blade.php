<div class="p-6 max-w-7xl mx-auto space-y-6 bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold mb-2">1. Paste Data (CSV/TSV)</h2>
                <textarea
                    wire:model.live.debounce.300ms="rawData"
                    class="w-full h-64 p-3 border border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Paste tabular data here (e.g. from Excel)..."></textarea>
            </div>


            <div>
                <h2 class="text-xl font-bold mb-2">2. Select columns to melt/pivot</h2>
                <div class="bg-gray-50 p-5 rounded border border-gray-200 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-3">Checked columns will be melted into variable/value rows. Unchecked columns remain as columns.</p>

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
                            <label class="block text-sm font-medium text-gray-700">New "Variable" column name</label>
                            <input type="text" wire:model.live="nameColumn" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">E.g. Sex, Age, Employment, etc.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New "Value" column name</label>
                            <input type="text" wire:model.live="valueColumn" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">E.g. Population, No. of households, etc.</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div>
            <h2 class="text-xl font-bold mb-2">3. Tidy Data Result</h2>
            <div class="space-y-6">

                @if(count($tidiedData) > 0)
                    <textarea
                        readonly
                        class="w-full h-64 p-3 border border-green-300 bg-green-50 rounded shadow-sm text-sm font-mono whitespace-pre"
                    >{{ $csvOutput }}</textarea>

                    <div class="overflow-x-auto border rounded border-gray-200 max-h-[400px]">
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
                @else
                    <div class="h-64 border-2 border-dashed border-gray-300 rounded flex items-center justify-center bg-gray-50 text-gray-400">
                        <p>Select columns on the left to see the tidy result here.</p>
                    </div>
                @endif
            </div>
        </div>


    </div>
</div>

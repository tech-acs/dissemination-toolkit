<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">

            <div>
                <div class="text-sm pb-3 leading-7">
                    You are about to upload values for the following dimension:
                    <span class="rounded-md border border-gray-100 p-1 font-semibold text-gray-700">{{ $dimension->name }}</span>
                    <br />Before uploading, please make sure:
                    <ul class="list-disc pl-6 py-2 text-gray-600">
                        <li>The file is an excel file (.xslx)</li>
                        <li>The excel file must have at least these columns:
                            <span class="font-semibold">code</span>,
                            <span class="font-semibold">label</span>
                        </li>
                        <li>Codes must be unique</li>
                    </ul>
                </div>
                <div class="flex items-stretch flex-grow">
                    <label for="datafile" class="flex justify-between w-2/3 rounded-md sm:text-sm border border-gray-300">
                        <span id="file_label" class="my-auto pl-4 text-gray-700">{{ __('Choose your file') }}</span>
                        <div class="relative inline-flex items-center hover:bg-gray-100 cursor-pointer space-x-2 px-4 py-2 border-0 border-l rounded-r-md border-gray-300 text-sm font-medium text-gray-700 bg-gray-50">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path></svg>
                            <span>{{ __('Browse') }}</span>
                        </div>
                    </label>
                    <input
                        type="file" id="datafile" class="hidden" name="datafile" accept=".xls,.xlsx"
                        onchange="document.getElementById('file_label').innerText = Array.from(this.files).map(f => f.name).join(', ')"
                    >
                </div>
            </div>
            @if($errors->has('datafile'))
                <x-input-error for="datafile" />
            @endif

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.dimension.values.index', $dimension) }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

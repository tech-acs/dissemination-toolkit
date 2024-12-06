<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="name" value="{{ __('Name') }} *" />
                <x-dissemination::multi-lang-input id="name" name="name" type="text" value="{{old('name', $indicator->name ?? null)}}" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }}" class="inline" /><x-dissemination::locale-display />
                <x-dissemination::textarea name="description" rows="3">{{old('description', $indicator->description ?? null)}}</x-dissemination::textarea>
                <x-input-error for="description" class="mt-2" />
            </div>
            <div>
                <x-label for="code" value="{{ __('Code') }} *" />
                <x-input id="code" name="code" class="w-50 mt-1" value="{{ old('code', $indicator->code ?? null) }}" />
                <x-input-error for="code" class="mt-2" />
            </div>
            {{--<div>
                <x-label for="rank" value="{{ __('Rank') }}" />
                <x-input id="rank" name="rank" type="number" class="w-20 mt-1" value="{{ old('rank', $indicator->rank ?? null) }}" />
                <x-input-error for="rank" class="mt-2" />
            </div>--}}
            <div>
                <x-label for="topics" value="{{ __('Topics') }} *" />
                <select size="5" multiple id="topics" name="topics[]" class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                    @foreach($topics as $id => $topicName)
                        <option class="p-1 mb-1 rounded" value="{{ $id }}" @selected(in_array($id, old('topics', $indicator->topics->pluck('id')->all())))>{{ $topicName }}</option>
                    @endforeach
                </select>
                <x-input-error for="topics" class="mt-2" />
            </div>

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.indicator.index') }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

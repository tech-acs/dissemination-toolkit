<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="name" value="{{ __('Name') }} *" />
                <x-multi-lang-input id="name" name="name" type="text" value="{{ old('name', $tag->name ?? null )}}" />
                <x-input-error for="name" class="mt-2" />
            </div>

            {{--<div>
                <x-label for="rank" value="{{ __('Rank') }}" />
                <x-input id="rank" name="rank" type="number" class="w-20 mt-1" value="{{ old('rank', $topic->rank ?? null) }}" />
                <x-input-error for="rank" class="mt-2" />
            </div>--}}
            {{--<div>
                <x-label for="indicators" value="{{ __('Indicators') }}" />
                <select id="indicators" name="indicators[]" multiple class="mt-1 space-y-1 text-base p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option disabled>{{ __('Multiple selection is allowed') }}</option>
                    @foreach($indicators ?? [] as $indicator)
                        <option class="p-2 rounded-md"
                                value="{{ $indicator->id }}"
                                @if($topic ?? null)
                                    @selected(in_array($indicator->id, $topic?->indicators?->pluck('id')->all() ?? []))
                                @endif
                            >{{ $indicator->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error for="indicators" class="mt-2" />
            </div>--}}

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.tag.index') }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            {{--<div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $visualization->name ?? null) }}" />
                <x-input-error for="name" class="mt-2" />
            </div>--}}
            <div class="mt-1">
                <x-label for="title" value="{{ __('Title') }} *" />
                <x-multi-lang-input id="title" name="title" value="{{ old('title', $visualization->title ?? null) }}" />
                <x-input-error for="title" class="mt-2" />
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }} *" class="inline" /><x-locale-display />
                <textarea name="description" rows="3" class='w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm'>{{old('description', $visualization->description ?? null)}}</textarea>
                <x-input-error for="description" class="mt-2" />
            </div>

            <div class="grid grid-cols-2">
                <div>
                    <x-label for="topics" value="{{ __('Topics') }} *" />
                    <select size="5" multiple id="topics" name="topics[]" class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                        @foreach($topics as $id => $topicName)
                            <option class="p-1 mb-1 rounded" value="{{ $id }}" @selected(in_array($id, old('$topics', $visualization->topics->pluck('id')->all())))>{{ $topicName }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="topics" class="mt-2" />
                </div>
                <div>
                    <x-label for="tags" value="{{ __('Tags') }}" />
                    <x-tags :value="\App\Models\Tag::tagsToJsArray($visualization->tags())" class="mt-1" />
                    <x-input-error for="tags" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div>
                    <x-label for="page" value="{{ __('Status') }}" />
                    <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($visualization->published ?? false) }">
                        <label for="status">
                            <span class="text-sm text-gray-500">{{ __('Draft') }}</span>
                        </label>
                        <input type="hidden" name="published" :value="enabled">
                        <button
                            x-on:click="enabled = ! enabled"
                            :class="enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                            type="button"
                            class="ml-3 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="switch"
                            id="status"
                        >
                            <span aria-hidden="true" :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                        </button>
                        <label for="status" class="ml-3">
                            <span class="text-sm text-gray-900">{{ __('Published') }}</span>
                        </label>
                    </div>

                </div>
                <div>
                    <x-label for="topic" value="{{ __('Filterable by geography') }}" />
                    <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($visualization->is_filterable ?? false) }" x-cloak>
                        <label for="is_filterable">
                            <span class="text-sm text-gray-500">{{ __('No') }}</span>
                        </label>
                        <input type="hidden" name="is_filterable" :value="enabled">
                        <button
                            x-on:click="enabled = ! enabled"
                            :class="enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                            type="button"
                            class="ml-3 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="switch"
                            id="is_filterable"
                        >
                            <span aria-hidden="true" :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                        </button>
                        <label for="is_filterable" class="ml-3">
                            <span class="text-sm text-gray-900">{{ __('Yes') }}</span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.visualization.index') }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>{{ __('Submit') }}</x-button>
    </div>
</div>

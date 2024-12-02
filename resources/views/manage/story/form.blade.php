<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="grid grid-cols-1 gap-8">
            <div>
                <x-label for="title" value="{{ __('Title') }} *" />
                <x-dissemination::multi-lang-input id="title" name="title" type="text" value="{{ old('title', $story->title ?? null )}}" />
                <x-input-error for="title" class="mt-2" />
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }} *" class="inline" /><x-dissemination::locale-display />
                <x-dissemination::textarea name="description" rows="3" placeholder="{{ __('Please enter a helpful description that is at least 20 characters in length') }}">{{old('description', $story->description ?? null)}}</x-dissemination::textarea>
                <x-input-error for="description" class="mt-2" />
            </div>
            <div class="grid lg:grid-cols-3">
                <div class="space-y-6">
                    <div>
                        <x-label for="topics" value="{{ __('Topics') }} *" />
                        <select size="5" multiple id="topics" name="topics[]" class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            @foreach($topics as $id => $topicName)
                                <option class="p-1 mb-1 rounded" value="{{ $id }}" @selected(in_array($id, old('topics', $story?->topics->pluck('id')->all())))>{{ $topicName }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="topics" class="mt-2" />
                    </div>
                    {{--<div>
                        <x-label for="published" value="{{ __('Status') }}" />
                        <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($story->published ?? false) }" x-cloak>
                            <label for="status">
                                <span class="text-sm text-gray-500">Draft</span>
                            </label>
                            <input type="hidden" name="published" :value="enabled">
                            <button
                                x-on:click="enabled = ! enabled"
                                :class="enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                                type="button"
                                class="ml-3  relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                role="switch"
                                id="status"
                            >
                                <span aria-hidden="true" :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                            <label for="status" class="ml-3">
                                <span class="text-sm text-gray-900">{{ __('Published') }}</span>
                            </label>
                        </div>
                    </div>--}}
                </div>

                <div class="space-y-6">
                    <div>
                        <x-label for="topic" value="{{ __('Filterable by geography') }}" />
                        <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($story->is_filterable ?? false) }" x-cloak>
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
                    <div>
                        <x-label for="tags" value="{{ __('Tags') }}" />
                        @if(isset($story))
                            <x-dissemination::tags :value="\Uneca\DisseminationToolkit\Models\Tag::tagsToJsArray($story->tags())" class="mt-1" />
                        @else
                            <x-dissemination::tags class="mt-1" />
                        @endif
                        <x-input-error for="tags" class="mt-2" />
                    </div>
                </div>

            </div>

            <div class="grid lg:grid-cols-3">
                <div>
                    <x-label value="{{ __('Featured') }}" />
                    <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($story->featured ?? false) }" x-cloak>
                        <label for="featured">
                            <span class="text-sm text-gray-500">{{ __('No') }}</span>
                        </label>
                        <input type="hidden" name="featured" :value="enabled">
                        <button
                            x-on:click="enabled = ! enabled"
                            :class="enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                            type="button"
                            class="ml-3  relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="switch"
                            id="featured"
                        >
                            <span aria-hidden="true" :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                        </button>
                        <label for="featured" class="ml-3">
                            <span class="text-sm text-gray-900">{{ __('Yes') }}</span>
                        </label>
                    </div>
                </div>

                <div>
                    <x-label for="featured_image" value="{{ __('Featured image') }}" />
                    <x-input id="image" name="image" type="file" value="{{ old('image', $story->featured_image ?? null) }}"
                             class="mt-1 block border border-gray-300 rounded-md shadow-sm focus:outline-none file:border-0 file:overflow-hidden file:p-2" />
                    <x-input-error for="image" class="mt-2" />
                </div>
            </div>

            <div class="grid lg:grid-cols-3">
                <div>
                    <x-label value="{{ __('Reviewable') }}" />
                    <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($story->is_reviewable ?? false) }" x-cloak>
                        <label for="is_reviewable">
                            <span class="text-sm text-gray-500">{{ __('No') }}</span>
                        </label>
                        <input type="hidden" name="is_reviewable" :value="enabled">
                        <button
                            x-on:click="enabled = ! enabled"
                            :class="enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                            type="button"
                            class="ml-3  relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="switch"
                            id="is_reviewable"
                        >
                            <span aria-hidden="true" :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                        </button>
                        <label for="is_reviewable" class="ml-3">
                            <span class="text-sm text-gray-900">{{ __('Yes') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            {{--@if(! isset($story))
            <div x-data="{selected: null}">
                <x-label for="rank" value="{{ __('Template (click to select)') }}" class="inline" /> <x-input-error for="template_id" class="inline ml-4" />
                <input type="hidden" name="template_id" x-ref="template_id" />
                <ul role="list" class="mt-2 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    @foreach($templates ?? [] as $template)
                        <li
                            :class="selected === {{ $loop->iteration }} ? 'ring-4 ring-indigo-600 ring-offset-2' : ''"
                            class="relative border"
                            @click="$refs.template_id.value='{{ $template->id }}'; selected={{ $loop->iteration }}"
                        >
                            <div class="group aspect-h-7 aspect-w-10 block w-full overflow-hidden bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                <img src="{{ asset($template->thumbnailPath) }}" alt="Template thumbnail" class="pointer-events-none object-cover group-hover:opacity-75">
                            </div>
                            <div class="p-2 py-4 space-y-1">
                                <p class="pointer-events-none block truncate text-sm font-medium text-gray-900">{{ $template->name }}</p>
                                <p class="pointer-events-none block text-sm font-medium text-gray-500 line-clamp-3">{{ $template->description }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif--}}

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.story.index') }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

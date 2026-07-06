<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
        <div class="grid grid-cols-2 gap-6">
            <div x-data="{ fileName: '{{ $document->file_name ?? '' }}'}"
                 class="col-span-full" x-cloak>
                <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-full">
                            <div class="flex justify-center px-6 py-10 mt-2 border border-gray-900 border-dashed rounded-lg">
                                <div class="text-center">
                                    <div class="flex mt-4 text-sm leading-6 text-gray-600">
                                        <label for="file-upload"
                                               class="relative font-semibold text-indigo-600 bg-white rounded-md cursor-pointer focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                               x-on:click="fileName = ''">
                                            <span x-show="fileName === ''">{{ __('Click here to upload the file')}}</span>
                                            <span x-show="fileName !== ''" x-text="fileName"></span>
                                            <input id="file-upload" name="file" type="file" class="sr-only"
                                                   x-on:change="fileName = $event.target.files[0].name">
                                        </label>
                                        <button type="button"
                                                class="ml-2 text-sm font-medium text-red-600 hover:text-red-500 focus:outline-none focus:underline"
                                                x-show="fileName !== ''" x-on:click="fileName = ''">
                                            {{ __('Clear')}}
                                        </button>
                                    </div>
                                    <p x-show="fileName === ''" class="text-xs leading-5 text-gray-600">upload up to 100MB</p>
                                </div>
                            </div>
                            <x-input-error for="file" class="mt-2"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-full">
                <div>
                    <x-label for="title" value="{{ __('Type') }} *"/>
                    <fieldset class="mt-4">
                        <legend class="sr-only">Dataset type</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0 border rounded-md">
                            @foreach($types as $type)
                                <div class="flex items-center p-3 ">
                                    <input id="type-{{ $type->id }}" name="dataset_type" value="{{ $type->id }}"
                                           type="radio"
                                           class="w-4 h-4 p-2.5 text-indigo-600 border-gray-300 focus:ring-indigo-600"
                                            @checked($type->id == ($document->dataset_type->value ?? \Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum::CensusTable->value ) )>
                                    <label for="type-{{ $type->id }}"
                                           class="block ml-3 text-sm font-medium leading-6 text-gray-900">{{ $type->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>

            </div>

        </div>
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-label for="title" value="{{ __('Title') }} *"/>
                <x-dissemination::multi-lang-input id="title" name="title" type="text"
                                              value="{{old('title', $document->title ?? null)}}"/>
                <x-input-error for="title" class="mt-2"/>
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }}" class="inline"/>
                <x-dissemination::locale-display/>
                <x-dissemination::textarea id="description" name="description"
                                      rows="3">{{old('description', $document->description ?? null)}}</x-dissemination::textarea>
                <x-input-error for="description" class="mt-2"/>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-label for="data_source" value="{{ __('Data source') }} *"/>
                <x-dissemination::multi-lang-input id="data_source" name="data_source" type="text"
                                              value="{{old('data_source', $document->data_source ?? null)}}"/>
                <x-input-error for="data_source" class="mt-2"/>
            </div>
            <div>
                <x-label for="producer" value="{{ __('Producer') }} *" />
                <x-dissemination::multi-lang-input id="producer" name="producer" type="text" value="{{old('producer', $document->producer ?? null)}}"/>
                <x-input-error for="producer" class="mt-2"/>
            </div>

            <div>
                <x-label for="publisher" value="{{ __('Publisher') }} *" />
                <x-dissemination::multi-lang-input id="publisher" name="publisher" type="text" value="{{old('publisher', $document->publisher ?? null)}}"/>
                <x-input-error for="publisher" class="mt-2"/>
            </div>
            <div>
                <x-label for="published_date" value="{{ __('Published date') }} *"/>
                <x-input
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        id="published_date" name="published_date" type="date" max="{{now()}}"
                        value="{{ old('published_date', $document->published_date ?? '') }}"/>
                <x-input-error for="published_date" class="mt-2"/>
            </div>

            <div class="flex flex-col">
                <x-label for="topics" value="{{ __('Topics') }} *" />
                <select size="5" multiple id="topics" name="topics[]" class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                    @foreach($topics as $id => $topicName)
                        <option class="p-1 mb-1 rounded" value="{{ $id }}" @selected(in_array($id, old('topics', $document->topics->pluck('id')->all())))>{{ $topicName }}</option>
                    @endforeach
                </select>
                <x-input-error for="topics" class="mt-2" />
            </div>

            <div class="">
                <x-label for="tags" value="{{ __('Tags') }}"/>
                @if(isset($document))
                    <x-dissemination::tags :value="\Uneca\DisseminationToolkit\Models\Tag::tagsToJsArray($document->tags())" class="mt-1"/>
                @else
                    <x-dissemination::tags class="mt-1"/>
                @endif
                <x-input-error for="tags" class="mt-2"/>
            </div>

            <div class="col-span-2">
                <x-label for="comment" value="{{ __('Comment') }}" class="inline"/>
                <x-dissemination::textarea id="comment" name="comment" rows="2">{{old('comment', $document->comment ?? null)}}</x-dissemination::textarea>
                <x-input-error for="comment" class="mt-2"/>
            </div>

            {{--<div class="">
                <x-label for="published" value="{{ __('Status') }}"/>
                <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($document->published ?? false) }" x-cloak>
                    <label for="status">
                        <span class="text-sm text-gray-500">{{ __('Draft') }}</span>
                    </label>
                    <input type="hidden" id="status" name="published" :value="enabled">
                    <button
                            x-on:click="enabled = ! enabled"
                            :class="enabled ? 'bg-indigo-600' : 'bg-gray-200'"
                            type="button"
                            class="relative inline-flex flex-shrink-0 h-6 ml-3 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="switch"
                            id="published">
                    <span aria-hidden="true" :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                          class="inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow pointer-events-none ring-0"></span>
                    </button>
                    <label for="status" class="ml-3">
                        <span class="text-sm text-gray-900">{{ __('Published') }}</span>
                    </label>
                </div>
            </div>--}}

        </div>
    </div>
    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.document.index') }}">{{ __('Cancel') }}</a>
        </x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>

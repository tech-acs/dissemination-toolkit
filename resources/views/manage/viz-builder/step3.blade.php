<x-app-layout>

    <div class="flex flex-col max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <x-dissemination::message-display />
        <livewire:state-recorder />

        <section class="shadow sm:rounded-md sm:overflow-hidden py-5 bg-white sm:p-6">
            @include('dissemination::manage.viz-builder.nav')

            <div class="flex w-full">
                <div class="w-1/2 border-r pr-4 py-8">
                    <input type="hidden" id="should-capture-thumbnail" value="1" />
                    <livewire:visualizer
                        :designated-component="$visualization->livewire_component"
                        :raw-data="$resource->rawData"
                        :data="$resource->data"
                        :layout="$resource->layout"
                        :options="$resource->options"
                    />
                </div>

                <div class="w-1/2 pr-12">
                    {{--<div class="w-10/12 mx-auto -mb-4"><x-error-display /></div>--}}
                    <form id="viz_info" action="{{ route("manage.viz-builder.$type.store") }}" method="post" class="w-10/12 mx-auto space-y-12 py-6">
                        @csrf
                        <div>
                            <x-label for="title" value="{{ __('Title') }} *" />
                            <input type="text" name="title" value="{{ old('title', $visualization?->title ?? null) }}" class="min-w-0 mt-1 flex-1 rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full px-3" />
                            <x-input-error for="title" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="description" value="{{ __('Description') }} *" class="inline" /><x-dissemination::locale-display />
                            <x-dissemination::textarea name="description" rows="3">{{ old('description', $visualization->description ?? null) }}</x-dissemination::textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>


                        <div class="grid grid-cols-2">
                            {{--<div>
                                <x-label for="topics" value="{{ __('Topics') }} *" />
                                <select name="topics[]" size="5" multiple id="topics" class="mt-1 p-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                                    @foreach($topics as $id => $topicName)
                                        <option class="p-1 mb-1 rounded" value="{{ $id }}" @selected(in_array($id, old('topics', $visualization?->topics->pluck('id')->all() ?? [])))>{{ $topicName }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="topics" class="mt-2" />
                            </div>--}}
                            <div>
                                <x-label for="topic" value="{{ __('Filterable by geography') }}" />
                                <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json((bool)old('filterable', $visualization?->is_filterable) ?? false) }" x-cloak>
                                    <label for="featured">
                                        <span class="text-sm text-gray-500">{{ __('No') }}</span>
                                    </label>
                                    <input type="hidden" name="filterable" :value="enabled">
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

                            <div class="space-y-10 pt-2">
                                <div>
                                    <x-label for="page" value="{{ __('Status') }}" />
                                    <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json((bool)old('published', $visualization?->published) ?? false) }">
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
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>
                                <x-label value="{{ __('Reviewable') }}" />
                                <div class="flex items-center mt-3 ml-3" x-data="{enabled: @json($visualization->is_reviewable ?? false) }" x-cloak>
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
                            <div>
                                <x-label for="tags" value="{{ __('Tags') }}" />
                                <x-dissemination::tags :value="\Uneca\DisseminationToolkit\Models\Tag::tagsToJsArray($visualization?->tags() ?? [])" class="mt-1" />
                                <x-input-error for="tags" class="mt-2" />
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <footer class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 pt-5 sm:px-8">
                <button type="submit" form="viz_info" class="cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Save
                </button>
            </footer>

            <x-dissemination::toast />
        </section>
    </div>
</x-app-layout>

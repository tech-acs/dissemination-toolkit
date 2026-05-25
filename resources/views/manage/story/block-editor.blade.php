@pushOnce('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpushOnce

@pushOnce('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endPushOnce

<x-app-layout>
    <div class="h-full" x-data="blockEditor()" x-cloak>
        <div class="flex items-center justify-between gap-x-4 bg-gray-100 py-4 px-6">
            <span class="text-xl font-medium">{{ $story->title }}</span>
            <div class="space-x-2">
                <x-danger-button x-on:click="reset()">{{ __('Reset') }}</x-danger-button>
                <x-button x-on:click="save()">{{ __('Save') }}</x-button>
                <x-button x-on:click="window.history.back()">{{ __('Close') }}</x-button>
            </div>
        </div>

        <div class="flex" style="height: calc(100vh - 73px);">
            <div class="flex-1 overflow-y-auto p-6 space-y-4 border-2 border-gray-200 rounded-lg m-4 bg-white">
                <template x-for="(block, index) in blocks" :key="block.id">
                    <div class="border rounded-lg bg-white shadow-sm">
                        <div class="flex items-center justify-between px-4 py-2 bg-gray-50 border-b rounded-t-lg">
                            <span class="text-sm font-semibold text-gray-700" x-text="blockLabel(block.type)"></span>
                            <button x-on:click="removeBlock(index)" class="text-xs text-red-600 hover:text-red-800">
                                {{ __('Remove') }}
                            </button>
                        </div>

                        <div x-show="block.type === 'text'" class="p-4"
                             x-init="
                                if (block.type === 'text' && !editors[block.id]) {
                                    let q = new Quill($el.querySelector('.quill-editor'), { theme: 'snow' });
                                    if (block.data.content) q.root.innerHTML = block.data.content;
                                    q.on('text-change', () => { block.data.content = q.root.innerHTML; });
                                    editors[block.id] = q;
                                }
                             ">
                            <div class="quill-editor" style="min-height: 200px;"></div>
                        </div>

                        <div x-show="block.type === 'image'" class="p-4 space-y-3">
                            <input type="file" accept="image/*" x-on:change="uploadImage($el, index)"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0 file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <template x-if="block.data.src">
                                <div>
                                    <img :src="block.data.src" class="max-h-48 rounded" />
                                </div>
                            </template>
                            <input type="text" x-model="block.data.caption" placeholder="{{ __('Caption') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <div x-show="block.type === 'visualization'" class="p-4">
                            <select x-model="block.data.viz_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">{{ __('Select a visualization') }}</option>
                                @foreach($visualizations as $viz)
                                    <option value="{{ $viz->id }}">{{ $viz->title }} ({{ $viz->type }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </template>

                <div x-show="blocks.length === 0" class="text-center text-gray-400 py-16">
                    {{ __('No blocks yet. Click one of the buttons on the right to add a block.') }}
                </div>
            </div>

            <div class="w-64 bg-gray-50 border-l p-4 flex-shrink-0">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">{{ __('Add Block') }}</h3>
                <div class="space-y-3">
                    <button x-on:click="addBlock('text')"
                            class="w-full text-left px-4 py-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-indigo-300 transition">
                        <span class="font-medium text-gray-800">{{ __('+ Text') }}</span>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Add a rich text block') }}</p>
                    </button>
                    <button x-on:click="addBlock('image')"
                            class="w-full text-left px-4 py-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-indigo-300 transition">
                        <span class="font-medium text-gray-800">{{ __('+ Image') }}</span>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Add an image with caption') }}</p>
                    </button>
                    <button x-on:click="addBlock('visualization')"
                            class="w-full text-left px-4 py-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-indigo-300 transition">
                        <span class="font-medium text-gray-800">{{ __('+ Visualization') }}</span>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Embed a chart, map or table') }}</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-dissemination::toast />

    <script>
        function blockEditor() {
            return {
                blocks: @json($blocks),
                _nextId: {{ count($blocks) }},
                editors: {},

                init() {
                    this.blocks.forEach(block => {
                        if (! block.id) block.id = this._uid();
                    });
                },

                _uid() {
                    return ++this._nextId;
                },

                blockLabel(type) {
                    return { text: '{{ __("Text") }}', image: '{{ __("Image") }}', visualization: '{{ __("Visualization") }}' }[type] || type;
                },

                addBlock(type) {
                    const id = this._uid();
                    const block = { id, type, data: {} };
                    if (type === 'text') block.data.content = '';
                    if (type === 'image') block.data = { src: '', caption: '' };
                    if (type === 'visualization') block.data = { viz_id: '' };
                    this.blocks.push(block);
                },

                removeBlock(index) {
                    const block = this.blocks[index];
                    if (block.type === 'text' && this.editors[block.id]) {
                        delete this.editors[block.id];
                    }
                    this.blocks.splice(index, 1);
                },

                async save() {
                    const payload = this.blocks.map(({ type, data }) => ({ type, data }));
                    const response = await axios.patch(
                        `${window.ajaxBaseURL}/manage/story/{{ $story->id }}/design`,
                        { blocks: payload },
                        { validateStatus: () => true }
                    );

                    if (response.status === 200) {
                        this.$dispatch('notify', { type: 'success', content: '{{ __("Saved successfully") }}' });
                    } else {
                        this.$dispatch('notify', { type: 'error', content: '{{ __("Error while saving") }}' });
                    }
                },

                async uploadImage(input, index) {
                    const file = input.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('image', file);

                    const response = await axios.post(
                        `${window.ajaxBaseURL}/manage/story/upload-image`,
                        formData,
                        {
                            headers: { 'Content-Type': 'multipart/form-data' },
                            validateStatus: () => true,
                        }
                    );

                    if (response.status === 200 && response.data.image_path) {
                        this.blocks[index].data.src = response.data.image_path;
                    } else {
                        this.$dispatch('notify', { type: 'error', content: '{{ __("Image upload failed") }}' });
                    }
                },

                reset() {
                    this.editors = {};
                    this.blocks = [];
                }
            }
        }
    </script>
</x-app-layout>

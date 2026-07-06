<div x-data="blockEditor()">
    <div class="flex items-center justify-between gap-x-4 bg-gray-100 py-4 px-6">
        <div class="flex flex-col">
            <span class="text-xl font-medium">{{ $story->title }}</span>
            <span class="text-sm text-gray-600">{{ $story->description }}</span>
        </div>

        <div class="space-x-2">
            <x-danger-button x-on:click="reset()">{{ __('Reset') }}</x-danger-button>
            <x-button x-on:click="save()">{{ __('Save') }}</x-button>
            <x-button x-on:click="window.history.back()">{{ __('Close') }}</x-button>
        </div>
    </div>

    <div class="flex" style="height: calc(100vh - 73px);">
        <div wire:ignore class="flex-1 overflow-y-auto p-6 space-y-4 border-2 border-gray-200 rounded-lg m-4 mt-0 bg-white">
            <template x-for="(block, index) in blocks" :key="block.id">
                <div class="border-2 border-dashed border-gray-300 rounded-lg bg-white relative">
                    <div class="absolute -top-3 left-4 inline-flex items-center gap-2 px-3 py-0.5 bg-white border-2 border-dashed border-gray-300 rounded-t-lg text-sm font-medium text-gray-700 z-10">
                        <span x-text="blockLabel(block.type)"></span>
                        <button x-on:click="removeBlock(index)" class="text-red-500 hover:text-red-700 text-sm leading-none">✕</button>
                    </div>

                    <template x-if="block.type === 'two-column'">
                        <div class="grid grid-cols-2 gap-4 p-4 pt-6 min-h-[120px]"
                             @click.outside="clearCursor()">
                            <div class="border border-dashed border-gray-200 rounded p-3 min-h-[100px] relative cursor-pointer transition"
                                 @click.stop="setCursor(block.id, 'left')"
                                 :class="cursor.containerId === block.id && cursor.column === 'left' ? 'ring-2 ring-indigo-400' : ''">
                                <template x-for="(child, ci) in block.data.left" :key="child.id">
                                    <div class="relative mb-3 last:mb-0 group">
                                        <button x-on:click="removeChild(block.id, 'left', ci)"
                                                class="absolute -top-1.5 -right-1.5 text-red-500 hover:text-red-700 text-sm leading-none bg-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10 shadow-sm border border-gray-200">✕</button>

                                        <x-dissemination::manage.story.block-editor-text var="child" height="100px" />
                                        <x-dissemination::manage.story.block-editor-image var="child" :container-id="'block.id'" column="left" :ci="'ci'" />
                                        <x-dissemination::manage.story.block-editor-viz var="child" :visualizations="$visualizations" />
                                    </div>
                                </template>
                                <div x-show="!block.data.left || block.data.left.length === 0"
                                     class="text-gray-400 text-xs text-center py-8 select-none">
                                    {{ __('Left column') }}
                                </div>
                            </div>

                            <div class="border border-dashed border-gray-200 rounded p-3 min-h-[100px] relative cursor-pointer transition"
                                 @click.stop="setCursor(block.id, 'right')"
                                 :class="cursor.containerId === block.id && cursor.column === 'right' ? 'ring-2 ring-indigo-400' : ''">
                                <template x-for="(child, ci) in block.data.right" :key="child.id">
                                    <div class="relative mb-3 last:mb-0 group">
                                        <button x-on:click="removeChild(block.id, 'right', ci)"
                                                class="absolute -top-1.5 -right-1.5 text-red-500 hover:text-red-700 text-sm leading-none bg-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10 shadow-sm border border-gray-200">✕</button>

                                        <x-dissemination::manage.story.block-editor-text var="child" height="100px" />
                                        <x-dissemination::manage.story.block-editor-image var="child" :container-id="'block.id'" column="right" :ci="'ci'" />
                                        <x-dissemination::manage.story.block-editor-viz var="child" :visualizations="$visualizations" />
                                    </div>
                                </template>
                                <div x-show="!block.data.right || block.data.right.length === 0"
                                     class="text-gray-400 text-xs text-center py-8 select-none">
                                    {{ __('Right column') }}
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="block.type !== 'two-column'">
                        <div>
                            <x-dissemination::manage.story.block-editor-text var="block" height="200px" />
                            <x-dissemination::manage.story.block-editor-image var="block" :index="'index'" />
                            <x-dissemination::manage.story.block-editor-viz var="block" :visualizations="$visualizations" />
                        </div>
                    </template>
                </div>
            </template>

            <div x-show="blocks.length === 0" class="text-center text-gray-400 py-16">
                {{ __('No blocks yet. Click one of the buttons on the right to add a block.') }}
            </div>
        </div>

        <div class="w-64 bg-gray-50 border-l p-4 flex-shrink-0">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">{{ __('Add Block') }}</h3>
            <div class="space-y-3">
                <button x-on:click="addBlock('two-column')"
                        class="w-full text-left px-4 py-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-indigo-300 transition">
                    <span class="font-medium text-gray-800">{{ __('+ Two-Column Container') }}</span>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Add a two-column section') }}</p>
                </button>
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

    <x-dissemination::toast />

    <script>
        function blockEditor() {
            return {
                blocks: @json($blocks),
                _nextId: 0,
                editors: {},
                cursor: { containerId: null, column: null },

                init() {
                    let maxId = 0;
                    const walk = (items) => {
                        items.forEach(block => {
                            if (block.id && block.id > maxId) maxId = block.id;
                            if (!block.id) block.id = ++maxId;
                            if (block.type === 'two-column') {
                                walk(block.data.left || []);
                                walk(block.data.right || []);
                            }
                        });
                    };
                    walk(this.blocks);
                    this._nextId = maxId;
                },

                _uid() {
                    return ++this._nextId;
                },

                blockLabel(type) {
                    return { text: '{{ __("Text") }}', image: '{{ __("Image") }}', visualization: '{{ __("Visualization") }}', 'two-column': '{{ __("Two-Column") }}' }[type] || type;
                },

                setCursor(containerId, column) {
                    if (this.cursor.containerId === containerId && this.cursor.column === column) {
                        this.cursor = { containerId: null, column: null };
                    } else {
                        this.cursor = { containerId, column };
                    }
                },

                clearCursor() {
                    this.cursor = { containerId: null, column: null };
                },

                addBlock(type) {
                    const id = this._uid();
                    const block = { id, type, data: {} };
                    if (type === 'text') block.data.content = '';
                    if (type === 'image') block.data = { src: '', caption: '', alignment: 'center' };
                    if (type === 'visualization') block.data = { viz_id: '' };
                    if (type === 'two-column') block.data = { left: [], right: [] };

                    if (this.cursor.containerId && type !== 'two-column') {
                        const container = this.blocks.find(b => b.id === this.cursor.containerId);
                        if (container && container.type === 'two-column' && this.cursor.column) {
                            container.data[this.cursor.column].push(block);
                            return;
                        }
                    }
                    this.blocks.push(block);
                },

                removeBlock(index) {
                    const block = this.blocks[index];
                    this._cleanupEditors(block);
                    this.blocks.splice(index, 1);
                },

                _cleanupEditors(block) {
                    if (block.type === 'text' && this.editors[block.id]) {
                        delete this.editors[block.id];
                    }
                    if (block.type === 'two-column') {
                        (block.data.left || []).forEach(child => {
                            if (this.editors[child.id]) delete this.editors[child.id];
                        });
                        (block.data.right || []).forEach(child => {
                            if (this.editors[child.id]) delete this.editors[child.id];
                        });
                    }
                },

                removeChild(containerId, column, childIndex) {
                    const container = this.blocks.find(b => b.id === containerId);
                    if (!container) return;
                    const child = container.data[column][childIndex];
                    if (child && child.type === 'text' && this.editors[child.id]) {
                        delete this.editors[child.id];
                    }
                    container.data[column].splice(childIndex, 1);
                },

                save() {
                    const payload = this.blocks.map(({ type, data }) => ({ type, data }));
                    this.$wire.save(payload);
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

                async uploadChildImage(input, containerId, column, childIndex) {
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
                        const container = this.blocks.find(b => b.id === containerId);
                        if (container) {
                            container.data[column][childIndex].data.src = response.data.image_path;
                        }
                    } else {
                        this.$dispatch('notify', { type: 'error', content: '{{ __("Image upload failed") }}' });
                    }
                },

                reset() {
                    this.editors = {};
                    this.blocks = [];
                    this.cursor = { containerId: null, column: null };
                }
            }
        }
    </script>
</div>

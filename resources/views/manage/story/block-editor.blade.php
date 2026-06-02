@pushOnce('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpushOnce

@pushOnce('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .block-editor-quill .ql-editor {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 1rem;
            line-height: 1.75;
            color: #374151;
            padding: 0;
        }
        .block-editor-quill .ql-editor p { margin-bottom: 0.75em; }
    </style>
@endPushOnce

<x-app-layout>
    <div class="h-full" x-data="blockEditor()" x-cloak>
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
            <div class="flex-1 overflow-y-auto p-6 space-y-4 border-2 border-gray-200 rounded-lg m-4 mt-0 bg-white">
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
                                            <div x-show="child.type === 'text'" class=""
                                                 x-init="if (child.type === 'text' && !editors[child.id]) { let q = new Quill($el.querySelector('.quill-editor'), { theme: 'snow' }); if (child.data.content) q.root.innerHTML = child.data.content; q.on('text-change', () => { child.data.content = q.root.innerHTML; }); editors[child.id] = q; }">
                                                <div class="quill-editor block-editor-quill" style="min-height: 100px;"></div>
                                            </div>
                                            <div x-show="child.type === 'image'" class="space-y-2">
                                                <input type="file" accept="image/*" x-on:change="uploadChildImage($el, block.id, 'left', ci)"
                                                       class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                                  <template x-if="child.data.src">
                                                      <div class="flex flex-col" :class="{
                                                          'items-center': !child.data.alignment || child.data.alignment === 'center',
                                                          'items-start': child.data.alignment === 'left',
                                                          'items-end': child.data.alignment === 'right',
                                                          '': child.data.alignment === 'full'
                                                      }">
                                                          <div class="flex items-center gap-1">
                                                              <button @click="child.data.alignment = 'left'"
                                                                      :class="child.data.alignment === 'left' ? 'text-indigo-600' : 'text-gray-400'"
                                                                      class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                      title="{{ __('Align left') }}">
                                                                  <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="1" y="12" width="8" height="2" rx="1"/></svg>
                                                              </button>
                                                              <button @click="child.data.alignment = 'center'"
                                                                      :class="(!child.data.alignment || child.data.alignment === 'center') ? 'text-indigo-600' : 'text-gray-400'"
                                                                      class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                      title="{{ __('Align center') }}">
                                                                  <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="3" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="3" y="12" width="10" height="2" rx="1"/></svg>
                                                              </button>
                                                              <button @click="child.data.alignment = 'right'"
                                                                      :class="child.data.alignment === 'right' ? 'text-indigo-600' : 'text-gray-400'"
                                                                      class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                      title="{{ __('Align right') }}">
                                                                  <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="5" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="7" y="12" width="8" height="2" rx="1"/></svg>
                                                              </button>
                                                              <button @click="child.data.alignment = 'full'"
                                                                      :class="child.data.alignment === 'full' ? 'text-indigo-600' : 'text-gray-400'"
                                                                      class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                      title="{{ __('Full width') }}">
                                                                  <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="5" width="14" height="6" rx="1"/></svg>
                                                              </button>
                                                          </div>
                                                          <img :src="child.data.src"
                                                               class="max-h-32 rounded block"
                                                               :class="{ 'w-full max-h-none': child.data.alignment === 'full' }" />
                                                          <input type="text" x-model="child.data.caption" placeholder="{{ __('Caption') }}"
                                                                 class="self-stretch border-gray-300 rounded-md text-xs shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                 :class="{
                                                                     'text-center': !child.data.alignment || child.data.alignment === 'center',
                                                                     'text-left': child.data.alignment === 'left' || child.data.alignment === 'full',
                                                                     'text-right': child.data.alignment === 'right'
                                                                 }" />
                                                      </div>
                                                  </template>
                                             </div>
                                             <div x-show="child.type === 'visualization'" class="">
                                                 <select x-model="child.data.viz_id"
                                                         class="w-full border-gray-300 rounded-md text-xs shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                     <option value="">{{ __('Select a visualization') }}</option>
                                                     @foreach($visualizations as $viz)
                                                         <option value="{{ $viz->id }}">{{ $viz->title }} ({{ $viz->type }})</option>
                                                     @endforeach
                                                 </select>
                                             </div>
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
                                             <div x-show="child.type === 'text'" class=""
                                                  x-init="if (child.type === 'text' && !editors[child.id]) { let q = new Quill($el.querySelector('.quill-editor'), { theme: 'snow' }); if (child.data.content) q.root.innerHTML = child.data.content; q.on('text-change', () => { child.data.content = q.root.innerHTML; }); editors[child.id] = q; }">
                                                 <div class="quill-editor block-editor-quill" style="min-height: 100px;"></div>
                                             </div>
                                             <div x-show="child.type === 'image'" class="space-y-2">
                                                 <input type="file" accept="image/*" x-on:change="uploadChildImage($el, block.id, 'right', ci)"
                                                        class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                                 <template x-if="child.data.src">
                                                     <div class="flex flex-col" :class="{
                                                         'items-center': !child.data.alignment || child.data.alignment === 'center',
                                                         'items-start': child.data.alignment === 'left',
                                                         'items-end': child.data.alignment === 'right',
                                                         '': child.data.alignment === 'full'
                                                     }">
                                                         <div class="flex items-center gap-1">
                                                             <button @click="child.data.alignment = 'left'"
                                                                     :class="child.data.alignment === 'left' ? 'text-indigo-600' : 'text-gray-400'"
                                                                     class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                     title="{{ __('Align left') }}">
                                                                 <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="1" y="12" width="8" height="2" rx="1"/></svg>
                                                             </button>
                                                             <button @click="child.data.alignment = 'center'"
                                                                     :class="(!child.data.alignment || child.data.alignment === 'center') ? 'text-indigo-600' : 'text-gray-400'"
                                                                     class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                     title="{{ __('Align center') }}">
                                                                 <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="3" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="3" y="12" width="10" height="2" rx="1"/></svg>
                                                             </button>
                                                             <button @click="child.data.alignment = 'right'"
                                                                     :class="child.data.alignment === 'right' ? 'text-indigo-600' : 'text-gray-400'"
                                                                     class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                     title="{{ __('Align right') }}">
                                                                 <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="5" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="7" y="12" width="8" height="2" rx="1"/></svg>
                                                             </button>
                                                             <button @click="child.data.alignment = 'full'"
                                                                     :class="child.data.alignment === 'full' ? 'text-indigo-600' : 'text-gray-400'"
                                                                     class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                                     title="{{ __('Full width') }}">
                                                                 <svg class="w-3 h-3" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="5" width="14" height="6" rx="1"/></svg>
                                                             </button>
                                                         </div>
                                                         <img :src="child.data.src"
                                                              class="max-h-32 rounded block"
                                                              :class="{ 'w-full max-h-none': child.data.alignment === 'full' }" />
                                                         <input type="text" x-model="child.data.caption" placeholder="{{ __('Caption') }}"
                                                                class="self-stretch border-gray-300 rounded-md text-xs shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                :class="{
                                                                    'text-center': !child.data.alignment || child.data.alignment === 'center',
                                                                    'text-left': child.data.alignment === 'left' || child.data.alignment === 'full',
                                                                    'text-right': child.data.alignment === 'right'
                                                                }" />
                                                     </div>
                                                 </template>
                                            </div>
                                            <div x-show="child.type === 'visualization'" class="">
                                                <select x-model="child.data.viz_id"
                                                        class="w-full border-gray-300 rounded-md text-xs shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="">{{ __('Select a visualization') }}</option>
                                                    @foreach($visualizations as $viz)
                                                        <option value="{{ $viz->id }}">{{ $viz->title }} ({{ $viz->type }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                <div x-show="block.type === 'text'" class="p-4 pt-6"
                                     x-init="
                                        if (block.type === 'text' && !editors[block.id]) {
                                            let q = new Quill($el.querySelector('.quill-editor'), { theme: 'snow' });
                                            if (block.data.content) q.root.innerHTML = block.data.content;
                                            q.on('text-change', () => { block.data.content = q.root.innerHTML; });
                                            editors[block.id] = q;
                                        }
                                     ">
                                    <div class="quill-editor block-editor-quill" style="min-height: 200px;"></div>
                                </div>

                                <div x-show="block.type === 'image'" class="p-4 pt-6 space-y-3">
                                    <input type="file" accept="image/*" x-on:change="uploadImage($el, index)"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0 file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <template x-if="block.data.src">
                                        <div class="flex flex-col" :class="{
                                            'items-center': !block.data.alignment || block.data.alignment === 'center',
                                            'items-start': block.data.alignment === 'left',
                                            'items-end': block.data.alignment === 'right',
                                            '': block.data.alignment === 'full'
                                        }">
                                            <div class="flex items-center gap-1">
                                                <button @click="block.data.alignment = 'left'"
                                                        :class="block.data.alignment === 'left' ? 'text-indigo-600' : 'text-gray-400'"
                                                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                        title="{{ __('Align left') }}">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="1" y="12" width="8" height="2" rx="1"/></svg>
                                                </button>
                                                <button @click="block.data.alignment = 'center'"
                                                        :class="(!block.data.alignment || block.data.alignment === 'center') ? 'text-indigo-600' : 'text-gray-400'"
                                                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                        title="{{ __('Align center') }}">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor"><rect x="3" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="3" y="12" width="10" height="2" rx="1"/></svg>
                                                </button>
                                                <button @click="block.data.alignment = 'right'"
                                                        :class="block.data.alignment === 'right' ? 'text-indigo-600' : 'text-gray-400'"
                                                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                        title="{{ __('Align right') }}">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor"><rect x="5" y="2" width="10" height="2" rx="1"/><rect x="1" y="7" width="14" height="2" rx="1"/><rect x="7" y="12" width="8" height="2" rx="1"/></svg>
                                                </button>
                                                <button @click="block.data.alignment = 'full'"
                                                        :class="block.data.alignment === 'full' ? 'text-indigo-600' : 'text-gray-400'"
                                                        class="hover:text-indigo-500 p-0.5 rounded transition-colors"
                                                        title="{{ __('Full width') }}">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="5" width="14" height="6" rx="1"/></svg>
                                                </button>
                                            </div>
                                            <img :src="block.data.src"
                                                 class="max-h-48 rounded block"
                                                 :class="{ 'w-full max-h-none': block.data.alignment === 'full' }" />
                                            <input type="text" x-model="block.data.caption" placeholder="{{ __('Caption') }}"
                                                   class="self-stretch border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                   :class="{
                                                       'text-center': !block.data.alignment || block.data.alignment === 'center',
                                                       'text-left': block.data.alignment === 'left' || block.data.alignment === 'full',
                                                       'text-right': block.data.alignment === 'right'
                                                   }" />
                                        </div>
                                    </template>
                                </div>

                                <div x-show="block.type === 'visualization'" class="p-4 pt-6">
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
</x-app-layout>

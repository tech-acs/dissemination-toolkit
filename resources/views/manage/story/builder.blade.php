@push('styles')
    @vite(['resources/css/grid.css'])
@endpush

<x-app-layout>
    <div class="container mx-auto py-12 pt-0">

        <div class="col-span-3 bg-white" x-cloak x-data="storyEditor()">

            <div class="col-span-3 flex justify-between gap-x-4 bg-gray-100 py-4">
                <div>
                    <span class="text-xl">{{ $story->title }}</span>
                </div>
                <div>
                    <x-danger-button x-on:click="reset()">Reset</x-danger-button>
                    <x-button x-on:click="save()">Save</x-button>
                </div>
            </div>

            <div id="story-editor" class="h-full"></div>

        </div>

    </div>

    <script>
        function storyEditor() {
            return {
                editor: null,
                storyId: @json($story->id),
                storyHtml: @json($story->html),
                chartList: @json($visualizations),

                init() {
                    ClassicEditor.defaultConfig.chartList = this.chartList
                    ClassicEditor
                        .create(document.querySelector('#story-editor'))
                        .then(e => {
                            this.editor = e
                            e.setData(this.storyHtml)

                            CKEditorInspector.attach( e );
                        })
                        .catch( error => {
                            console.error( error.stack )
                        });
                },

                async save() {
                    let data = Alpine.raw(this.editor).getData()
                    const response = await axios.patch(`/manage/story-builder/${this.storyId}`, { storyHtml: data }, {validateStatus: () => true})
                    console.log(data, 'Save response: (response.status, response.data)', response.status, response.data)
                    if (response.status === 200) {
                        this.$dispatch('notify', {type: 'success', content: 'Successfully saved'})
                    } else {
                        this.$dispatch('notify', {type: 'error', content: 'Error while saving'})
                    }
                },

                reset() {
                    let editor = Alpine.raw(this.editor)
                    editor.setData('')
                }
            }
        }
    </script>
    <x-toast />
</x-app-layout>

<x-app-layout>
    {{-- Editor Wrapper --}}
    <div class="editor-wrapper">
        <div id="gjs"
{{--             x-init="new StoryBuilder()"--}}
             data-story-id="{{ $story->id }}"
             data-story-html="{{ $story->html }}"
             data-story-css="{{ $story->css }}"
             data-story-project-data="{{ $story->gjs_project_data }}">
        </div>
    </div>

    {{-- Optional, if you have an info container for the modal --}}
    <div id="info-panel" style="display:none;">
        <p>This is your info panel content</p>
    </div>

    @push('styles')
        <!-- GrapesJS core CSS -->
        <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet" />

        <!-- Any other CSS, e.g. custom or plugin CSS -->
    @endpush

    @push('scripts')
        <!-- External scripts for GrapesJS and plugins -->
        <script>

            window.APP_CSS_URLS = [
                "{{ Vite::asset('resources/css/app.css') }}",
                "{{ Vite::asset('resources/css/map.css') }}",
                "{{ Vite::asset('resources/css/grid.css') }}"
            ];
            window.VISUALIZATION_JS = "{{ Vite::asset('resources/js/visualization.js') }}";
        </script>

    @endpush
    @vite('resources/js/StoryBuilder.js')
    @vite('resources/css/editor.css')
</x-app-layout>

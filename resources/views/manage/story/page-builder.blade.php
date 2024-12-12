<script src="https://unpkg.com/grapesjs"> </script>
<!-- <script src="https://unpkg.com/grapesjs-component-twitch"></script> -->
<script src="https://unpkg.com/grapesjs-ga"></script>
<script src="https://unpkg.com/grapesjs-tailwind"></script>
<script src="https://unpkg.com/grapesjs-plugin-forms"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic@1.0.1"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage"></script>

<!-- <script src="https://unpkg.com/grapesjs-preset-newsletter@1.0.1"></script> -->
<!-- <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->

<link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet" />

<x-app-layout>

<div x-data="grapesjsEditor()" class="editor-wrapper">
    <div id="gjs"></div>
    <button @click="saveContent()" class="btn btn-primary mt-3">Save</button>
</div>
<!--
    <div id="gjs" style="height:0px; overflow:hidden;">
        <livewire:i-need-alpine />
    </div>
    </div> -->
    <script>


        const escapeName = (name) =>
            `${name}`.trim().replace(/([^a-z0-9\w-:/]+)/gi, "-");

       function grapesjsEditor() {
        return {
            saveContent() {
                console.log("Content saved");
                // Add logic to save the content
                },
            };
       }
        document.addEventListener('DOMContentLoaded', function () {

            const editor = grapesjs.init({
                height: "900px",
                autoRender: false,
                container: "#gjs",
                showOffsets: true,
                canvas: {
    styles: [], // Add external stylesheets if needed
    scripts: [], // Add external scripts if needed
    iframe: false // Disable iframe
  },
                fromElement: false,
                noticeOnUnload: false,
                storageManager: false,
                pageManager: {
                    pages: [
                        {
                            // without an explicit ID, a random one will be created
                            id: 'my-first-page',
                            // CSS or a JSON of styles
                            styles: '.my-el { color: red }',
                            // HTML string or a JSON of components
                            component: '',
                        }
                    ]
                },
                selectorManager: { escapeName },
                plugins: [
                    'grapesjs-preset-webpage',
                    'gjs-blocks-basic',
                    'grapesjs-tailwind',
                    'flexBlocks'
                ],

                pluginsOpts: {
                    'gjs-blocks-basic': { flexGrid: true },
                    'grapesjs-preset-webpage': {
                        // options
                    }
                }
            });




        var pnm = editor.Panels;
        var cmdm = editor.Commands;
        var md = editor.Modal;

        // Add info command
        var infoContainer = document.getElementById("info-panel");
        cmdm.add('open-info', {
            run: function (editor, sender) {
                var mdlClass = 'gjs-mdl-dialog-sm';
                sender.set('active', 0);
                var mdlDialog = document.querySelector('.gjs-mdl-dialog');
                mdlDialog.className += ' ' + mdlClass;
                infoContainer.style.display = 'block';
                md.open({
                    title: 'About',
                    content: infoContainer,
                });
                md.getModel().once('change:open', function () {
                    mdlDialog.className = mdlDialog.className.replace(mdlClass, '');
                })
            }
        });

        var titles = document.querySelectorAll('*[title]');
        for (var i = 0; i < titles.length; i++) {
            var el = titles[i];
            var title = el.getAttribute('title');
            title = title ? title.trim() : '';
            if (!title)
                break;
            el.setAttribute('data-tooltip', title);
            el.setAttribute('title', '');
        }

        // Update canvas-clear command
        cmdm.add('canvas-clear', function () {
            if (confirm('Are you sure to clean the canvas?')) {
                editor.runCommand('core:canvas-clear')
                setTimeout(function () { localStorage.clear() }, 0)
            }
        });

        // Do stuff on load
        editor.onReady(function () {
            // Show borders by default
            pnm.getButton('options', 'sw-visibility').set('active', 1);
        });

        editor.Panels.addButton("options", {
            id: "save-project",
            className: "fa fa-save",
            command: "save-project",
            attributes: {
                title: "Save",
                "data-tooltip-pos": "bottom"
            }
        });

        editor.Commands.add('save-project', {
            run(editor, sender, opts) {
                saveStory({{ $story->id }});
            }
        });

        editor.DomComponents.addType('visualization-component', {
    model: {
        // Component model properties and methods
        defaults: {
            name: 'data-viz',
            type: 'visualization-component',
            void: true,
            droppable: 0,
            editable: 1,
            highlightable: 0,
            resizable: { ratioDefault: 1 },
            draggable: true, // Allow dragging
            'viz-id': '', // Add the viz-id attribute as part of the defaults
            content: `<div>Visualization Component</div>`, // Root content
        },

        // Generate a unique viz-id during initialization
        init() {
            if (!this.get('viz-id')) {
                this.set('viz-id', `viz-${this.cid}`);
            }
        }
    },
    view: {
        // Component view properties and methods
        events: {
            dblclick: "openDialog"
        },

        /**
         * Called after the component is rendered in the canvas
         */
        onRender() {

            console.log('Custom component is rendering...');

            // Delay the execution to ensure the component is fully loaded
            setTimeout(() => {
                this.updateComponentContent();
            }, 3000); // Adjust the delay time as needed
        },

        updateComponentContent() {
            const canvasDocument = editor.Canvas.getDocument(); // Access the canvas document
            const componentId = this.model.get('id'); // Get the component's ID
            const liveElement = canvasDocument.getElementById(componentId); // Get the live DOM element

            if (liveElement) {
                liveElement.innerHTML = `<b>This is bold text added after delay</b>`; // Change content
                console.log('Updated content for:', liveElement);
            } else {
                console.error('Live element not found for the component.');
            }
        },
        /**
         * Custom method to initialize the visualization
         */
        initializeVisualization() {
            const vizId = this.model.get('viz-id'); // Get the viz-id from the model
            const document = editor.Canvas.getDocument(); // Get the Canvas document

            if (vizId && document) {
                console.log(`Initializing visualization for viz-id: ${vizId}`);

                // Initialize the PlotlyChart or other visualization
                new window['PlotlyChart'](vizId, document);

                // Optionally set additional properties or perform other tasks
                this.model.set('visualizationInitialized', true);
            } else {
                console.error('Missing required parameters for visualization initialization');
            }
        },

        openDialog() {
            editor.runCommand('open-viz-dialog', {
                model: this
            });
        }
    }
});

        // Add a command to open a dialog
        editor.Commands.add('open-viz-dialog', {
            run(editor, sender, opts) {
                load_dialog();
            }
        });
        editor.onReady(function () {
            Alpine.initTree(document.querySelector('#gjs'));

            // Alpine.start(); // Reinitialize Alpine.js to capture initial components
        });

        editor.on('component:drag:end', (component) => {
    if (component.get('type') === 'visualization-component') {
        const vizId = component.get('viz-id');
        const document = editor.Canvas.getDocument();
        console.log(`Reinitializing PlotlyChart for dragged component: ${vizId}`);

        if (vizId && document) {
            new window['PlotlyChart'](vizId, document);
        }
    }
});

        editor.on('load', () => {
            const html = `{!! $story->html !!}`;
            const css = `{!! $story->css !!}`;
            editor.setComponents(html);
            editor.setStyle(css);
            const customComponents = editor.Canvas.getDocument().querySelectorAll('[data-gjs-type="visualization-component"]');
            if (customComponents.length === 0) {
                console.warn('No custom components found.');
                return;
            }

            console.log(`Found ${customComponents.length} custom components.`);

            customComponents.forEach((component) => {
                console.log('Found custom component:', component);
                const vizId = component.getAttribute('id'); // Get the viz-id attribute
                console.log('found component',vizId)
                const xInit = component.getAttribute('gjs-init'); // Get the x-init attribute
                console.log('component xinit',xInit);
                const canvasDocument = editor.Canvas.getDocument(); // Access the canvas document

                if (vizId && canvasDocument) {
                    console.log(`Reinitializing visualization for viz-id: ${vizId}`);
                    try {
                        // Reinitialize the visualization (e.g., PlotlyChart)
                        new window[xInit](vizId,editor.Canvas.getDocument());

                    } catch (error) {
                        console.error(`Error reinitializing component with viz-id: ${vizId}`, error);
                    }
                }

                // Trigger re-rendering
                // const currentContent = component.get('content');
                // component.set('content', currentContent);
            });
    });

        editor.on('component:add', () => {
            // Alpine.start(); // This will ensure that Alpine is reinitialized after adding new components
        });

        // Function to fetch topics from the API
        async function fetchTopics() {
            try {
                const response = await fetch(`{{route('manage.story.builder.topics')}}`);
                const topics = await response.json();
                return topics;
            } catch (error) {
                console.log('Error fetching topics:', error);
            }
        }

        // Function to create a modal with a dropdown
        function createModalWithDropdown(topics) {
            const modal = editor.Modal;
            const content = document.createElement('div');

            // Create dropdown
            const select = document.createElement('select');
            select.id = 'topics-dropdown';

            const optionDefault = document.createElement('option');
            optionDefault.value = 0; //topic.id; // Assuming each topic has an 'id'
            optionDefault.textContent = 'Select a topic to filter visualizations';//topic.name; // Assuming each topic has a 'name'
            select.appendChild(optionDefault);

            topics.forEach(topic => {
                const option = document.createElement('option');
                option.value = topic.id; // Assuming each topic has an 'id'
                option.textContent = topic.name; // Assuming each topic has a 'name'
                select.appendChild(option);
            });

            content.appendChild(select);
            modal.setContent(content);
            modal.setTitle('Select visualization')
            modal.open();

            // Attach event listener to the dropdown
            select.addEventListener('change', (event) => {
                filterVisualizations(event.target.value, content);
            });
        }

        // Function to filter visualizations based on the selected topic
        function filterVisualizations(topicId, content) {
            // Your logic to filter visualizations
            const visDiv = document.getElementById('vis_list');
            // Remove the div
            if (visDiv && visDiv.parentNode) {
                visDiv.parentNode.removeChild(visDiv);
            }

            const dialogContent = document.createElement('div');
            dialogContent.id = 'vis_list';

            dialogContent.classList.add('vislist');
            var fetchArtifactUrl =
                // Make an API call to Laravel backend
                fetch(`{{route('manage.story.builder.artifacts', '')}}` + "/" + topicId)
                    .then(response => response.json())
                    .then(items => {
                        //     // Populate the dialog box
                        items.forEach(item => {
                            const itemElement = document.createElement('div');
                            const iconElement = document.createElement('div');
                            const titleElement = document.createElement('div');
                            itemElement.classList.add('flex', 'items-center', 'p-2', 'rounded-md', 'cursor-pointer', 'hover:bg-gray-50', 'bg-indigo-100', 'border-l-4', 'border-indigo-500');
                            iconElement.classList.add('mr-4', 'w-12', 'h-12', 'rounded-md');
                            iconElement.innerHTML = item.icon;
                            titleElement.classList.add('text-gray-700');
                            titleElement.innerText = item.title;
                            itemElement.appendChild(iconElement);
                            itemElement.appendChild(titleElement);
                            itemElement.onclick = () => {

                                // Handle the selection
                                editor.getSelected().set('content', "<div class='relative overflow-hidden h-full w-full min-h-full block p-6 border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 rounded-lg ring-1 ring-blue-900/10'>" + item.code

                                    + "</div>"
                                );
                                editor.Modal.close();
                                new window[item.xinit](item.vizid,editor.Canvas.getDocument());
                                // eval('new '+item.xinit+'('+item.vizid+','+editor)+');

                            };
                            dialogContent.appendChild(itemElement);
                            content.appendChild(dialogContent);
                        });
                    });
        }

        // Main function to start the process
        async function load_dialog() {
            const topics = await fetchTopics();
            if (topics) {
                createModalWithDropdown(topics);
            }
        }

        //Finally, add the new block to the block manager

        editor.BlockManager.add('visualization-laravel-block', {
            label: 'Visualization (table, chart and map)',
            category: 'Visualization',
            resizable: true,
            content: {
                type: 'visualization-component',
                content: `<div class="h-full w-full flex-1 w-2/3 mx-auto p-4 text-lg shadow-lg border-gray-300">
  <div class="rotate-0">visualization </div>
  </div>
  `
            },
            media: `
<div style=" display: block; display: flex">
<i class="fa fa-table" style="font-size:36px"></i>
<i class="fa fa-bar-chart" style="font-size:36px"></i>
<i class="fa fa-globe" style="font-size:36px"></i>
</div>
` // An icon for your block
        });


        // Load project data

        editor.loadProjectData({!! $story->gjs_project_data !!});
        editor.setStyle('{!! $story->css !!}');


        //Save story page project data and html
        function saveStory(storyId) {
            let story_project_data = JSON.stringify(editor.getProjectData());
            let story_html = editor.getHtml();
            let story_css = editor.getCss();

            story_html = story_html.replace("<body>", "");
            story_html = story_html.replace("</" + "body>", "");

            const data = [
                { "story_html": story_html },
                { "story_project_data": story_project_data },
                { "story_css": story_css },
            ];


            axios.patch(`{{route('manage.story.updatePage', $story->id)}}`, {
                data
            },
                {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                }).then(function (response) {
                    alert("Page saved successfully.")
                    // console.log("success",response);

                }).catch(function (response) {
                    console.log("error", response);
                });

        }
    });

    </script>

</x-app-layout>

import 'grapesjs/dist/css/grapes.min.css';
import grapesjs from 'grapesjs';

import 'grapesjs-ga';
import * as pluginTailwind from 'grapesjs-tailwind';
import 'grapesjs-plugin-forms';
import * as pluginBasicBlocks from 'grapesjs-blocks-basic';
import * as pluginWebpage from 'grapesjs-preset-webpage';
import 'grapesjs-preset-newsletter';

document.addEventListener('DOMContentLoaded', () => {
    const gjsElement = document.getElementById('gjs');
    const storyId = gjsElement.getAttribute('data-story-id');
    const storyHTML = gjsElement.getAttribute('data-story-html');
    const storyCSS = gjsElement.getAttribute('data-story-css');
    const storyProjectData = gjsElement.getAttribute('data-story-project-data');
    const cssPaths = window.APP_CSS_URLS || [];
    const visualizationJs = window.VISUALIZATION_JS;

    // Initialize the GrapesJS editor
    const editor = grapesjs.init({
        height: "900px",
        container: "#gjs",
        showOffsets: true,
        autoRender: false,
        noticeOnUnload: false,
        storageManager: false,
        selectorManager: {
            escapeName: (name) => `${name}`.trim().replace(/([^a-z0-9\w-:/]+)/gi, "-"),
        },
        canvas: {
            styles: cssPaths,
            scripts: [{ type: 'module', src: visualizationJs }],
        },
        plugins: [pluginWebpage, pluginBasicBlocks, pluginTailwind],
        pluginsOpts: {
            'gjs-blocks-basic': { flexGrid: true },
        },        panels: {
            defaults: [
                {
                    id: 'panel-block-manager',
                    el: '.panel__block-manager',
                    resizable: true,
                    buttons: []
                },
            ],
        },
    });

    // Customize editor styles and layout
    editor.Panels.addPanel({
        id: 'blocks',
        el: '.panel__block-manager',
        buttons: []
    });

    // Panels and Commands
    setupPanelsAndCommands(editor, storyId);

    // Load project data and styles
    editor.on('load', () => {
        editor.loadProjectData(JSON.parse(storyProjectData));
        editor.setComponents(storyHTML);
        editor.setStyle(storyCSS);
        // initializeCustomComponents(editor);
    });

    editor.setStyle(storyCSS);

    // Visualization Modal Logic
    setupVisualizationModal(editor);

    // Add custom block
    addCustomBlock(editor);

    // Add visualization component type
    editor.DomComponents.addType('visualization-component', {
        model: {
            defaults: {
                name: 'Visualization',
                tagName: 'div',
                draggable: true,
                droppable: false,
                resizable: true,
                attributes: {
                    'data-gjs-type': 'visualization-component',
                },
                content: `<div class='flex items center justify-center h-full w-full'>
                            <div class='text-lg'>Visualization</div>
                        </div>`
            },
        },
        view: {
            events: {
                dblclick: 'openDialog',
            },
            openDialog() {
                editor.runCommand('open-viz-dialog', { model: this.model });
            },
            onRender() {
                console.log('Visualization component rendered:', this.model);
            },
        },
    });
});

function setupPanelsAndCommands(editor, storyId) {
    const cmdm = editor.Commands;
    const pnm = editor.Panels;

    // Add info command
    cmdm.add('open-info', {
        run: (editor, sender) => {
            const mdlClass = 'gjs-mdl-dialog-sm';
            sender.set('active', 0);
            const mdlDialog = document.querySelector('.gjs-mdl-dialog');
            mdlDialog.classList.add(mdlClass);
            const infoPanel = document.getElementById("info-panel");
            infoPanel.style.display = 'block';
            editor.Modal.open({ title: 'About', content: infoPanel });
            editor.Modal.getModel().once('change:open', () => {
                mdlDialog.classList.remove(mdlClass);
            });
        },
    });

    // Clear canvas command
    cmdm.add('canvas-clear', () => {
        if (confirm('Are you sure to clean the canvas?')) {
            editor.runCommand('core:canvas-clear');
            setTimeout(() => localStorage.clear(), 0);
        }
    });

    // Save project command
    cmdm.add('save-project', {
        run: () => saveStory(storyId, editor),
    });
    // Save button
    pnm.addButton("options", {
        id: "save-project",
        className: "fa fa-save",
        command: "save-project",
        attributes: {
            title: "Save",
            "data-tooltip-pos": "bottom",
        },
    });
}

function setupVisualizationModal(editor) {
    const cmdm = editor.Commands;

    cmdm.add('open-viz-dialog', {
        run: async (editor, sender, opts) => {
            console.log('Opening dialog for visualization component:', opts.model);
            const topics = await fetchTopics();
            if (topics) {
                createModalWithDropdown(topics, editor);
            }
        },
    });
}

async function fetchTopics() {
    try {
        const response = await fetch(`${window.ajaxBaseURL}/manage/story/topics`);
        return await response.json();
    } catch (error) {
        console.error('Error fetching topics:', error);
    }
}

function createModalWithDropdown(topics, editor) {
    const modal = editor.Modal;
    const content = document.createElement('div');

    const select = document.createElement('select');
    select.id = 'topics-dropdown';

    const defaultOption = document.createElement('option');
    defaultOption.value = 0;
    defaultOption.textContent = 'Select a topic to filter visualizations';
    select.appendChild(defaultOption);

    topics.forEach(topic => {
        const option = document.createElement('option');
        option.value = topic.id;
        option.textContent = topic.name;
        select.appendChild(option);
    });

    content.appendChild(select);
    modal.setContent(content);
    modal.setTitle('Select visualization');
    modal.open();

    select.addEventListener('change', (event) => {
        filterVisualizations(event.target.value, content, editor);
    });
}

function filterVisualizations(topicId, content, editor) {
    const visDiv = document.getElementById('vis_list');
    if (visDiv) visDiv.remove();

    const dialogContent = document.createElement('div');
    dialogContent.id = 'vis_list';
    dialogContent.classList.add('vislist');
    dialogContent.style.maxHeight = '400px'; // Set the desired fixed height
    dialogContent.style.overflowY = 'auto';  // Enable vertical scrolling

    fetch(`${window.ajaxBaseURL}/manage/story/artifacts/${topicId}`)
        .then(response => response.json())
        .then(items => {
            items.forEach(item => {
                const itemElement = createVisualizationItem(item, editor);
                dialogContent.appendChild(itemElement);
            });
            content.appendChild(dialogContent);
        });
}

function createVisualizationItem(item, editor) {
    const itemElement = document.createElement('div');
    itemElement.classList.add(
        'flex', 'items-center', 'cursor-pointer',
        'hover:bg-gray-50', 'bg-indigo-100','border-1', 'border-l-4', 'border-indigo-700'
    );

    const iconElement = document.createElement('div');
    iconElement.classList.add('mr-4','p-2', 'w-24', 'h-24', 'rounded-md');
    iconElement.innerHTML = item.icon;

    const titleElement = document.createElement('div');
    titleElement.classList.add('text-gray-700');
    titleElement.innerText = item.title;

    itemElement.appendChild(iconElement);
    itemElement.appendChild(titleElement);

    itemElement.onclick = () => {
        let selectedComponent = editor.getSelected();
        while (selectedComponent && selectedComponent.get('type') !== 'visualization-component') {
            selectedComponent = selectedComponent.parent();
        }
        if (selectedComponent && selectedComponent.get('type') === 'visualization-component') {
            selectedComponent.components().reset(); // Clear the existing content
            selectedComponent.set('content', `${item.code}`); // Set the new content
        }
        editor.Modal.close();
    };

    return itemElement;
}

function addCustomBlock(editor) {
    editor.BlockManager.add('visualization-laravel-block', {
        label: 'Visualization (table, chart, map)',
        category: 'Visualization',
        resizable: true,
        content: {
            type: 'visualization-component',
            content: `
                    <div class="visualization-placeholder bg-gray-300 h-full w-full flex-1 mx-auto p-4 shadow-lg border-gray-300 min-w-96 min-h-96 self-center">
                        <div class="text-center text-white text-[5vw]">
                        <span class="align-middle">Visualization</span>
                        </div>
                    </div>
            `,
        },
        media: `
            <div style="display: flex;">
                <i class="fa fa-table" style="font-size:36px"></i>
                <i class="fa fa-bar-chart" style="font-size:36px"></i>
                <i class="fa fa-globe" style="font-size:36px"></i>
            </div>
        `,
    });
}

function saveStory(storyId, editor) {
    const story_project_data = JSON.stringify(editor.getProjectData());
    let story_html = editor.getHtml();
    let story_css = editor.getCss();

    // Clean out body tags if needed
    story_html = story_html.replace("<body>", "");
    story_html = story_html.replace("</body>", "");

    const data = [
        { "story_html": story_html },
        { "story_project_data": story_project_data },
        { "story_css": story_css },
    ];

    axios.patch(`${ajaxBaseURL}/manage/page-builder/${storyId}`, { data }, {
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(function (response) {
            alert("Page saved successfully.");
        })
        .catch(function (error) {
            console.error("Error saving page:", error);
        });
}

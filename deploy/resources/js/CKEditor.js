import { ClassicEditor as ClassicEditorBase } from '@ckeditor/ckeditor5-editor-classic';
import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { Autoformat } from '@ckeditor/ckeditor5-autoformat';
import { Bold, Italic, Underline } from '@ckeditor/ckeditor5-basic-styles';
import { BlockQuote } from '@ckeditor/ckeditor5-block-quote';
import { Heading } from '@ckeditor/ckeditor5-heading';
import { Link, LinkImage } from '@ckeditor/ckeditor5-link';
import { List } from '@ckeditor/ckeditor5-list';
import { Paragraph } from '@ckeditor/ckeditor5-paragraph';
import { Table, TableCellProperties, TableColumnResize, TableProperties, TableToolbar } from "@ckeditor/ckeditor5-table";
import { MediaEmbed } from "@ckeditor/ckeditor5-media-embed";
import { Indent, IndentBlock } from "@ckeditor/ckeditor5-indent";
import {
    Image,
    ImageCaption, ImageInline,
    ImageInsert,
    ImageResize,
    ImageResizeEditing, ImageResizeHandles, ImageStyle, ImageToolbar,
    ImageUpload
} from '@ckeditor/ckeditor5-image';
import { HorizontalLine } from "@ckeditor/ckeditor5-horizontal-line";
import { Base64UploadAdapter } from "@ckeditor/ckeditor5-upload";
import { RemoveFormat } from "@ckeditor/ckeditor5-remove-format";
import { HtmlEmbed } from '@ckeditor/ckeditor5-html-embed';
import { SourceEditing } from "@ckeditor/ckeditor5-source-editing";
import { TextTransformation } from "@ckeditor/ckeditor5-typing";
import { Font } from "@ckeditor/ckeditor5-font";
import { ShowBlocks } from "@ckeditor/ckeditor5-show-blocks";
import { Style } from "@ckeditor/ckeditor5-style";
import { GeneralHtmlSupport } from "@ckeditor/ckeditor5-html-support";
import { Alignment } from "@ckeditor/ckeditor5-alignment";

import ChartEmbed from "./ChartEmbed/ChartEmbed";
import Placeholder from "./Placeholder/Placeholder";

export default class ClassicEditor extends ClassicEditorBase {}

ClassicEditor.builtinPlugins = [
    Essentials, Autoformat, Font, Style, GeneralHtmlSupport, Bold, ShowBlocks, Alignment,
    Italic, Underline, BlockQuote, Heading, TextTransformation, Link, List, Paragraph,
    Table, TableToolbar, TableColumnResize, MediaEmbed, Indent, IndentBlock, TableProperties, TableCellProperties,
    Image, ImageCaption, ImageStyle, ImageInsert, ImageResize, ImageUpload, ImageToolbar, LinkImage, ImageInline,
    ImageResizeEditing, ImageResizeHandles,
    HtmlEmbed, SourceEditing, HorizontalLine, Base64UploadAdapter, RemoveFormat,
    ChartEmbed, Placeholder
];

ClassicEditor.defaultConfig = {
    placeholderConfig: {
        types: [ 'date', 'color', 'first name', 'surname' ]
    },
    toolbar: {
        items: [
            'undo', 'redo',
            '|', 'heading', 'style',
            '|', 'link', 'insertImage', 'insertTable', 'blockQuote', 'mediaEmbed', 'htmlEmbed', 'horizontalLine',
            '|', 'bold', 'italic', 'underline',
            {
                label: 'Basic styles',
                icon: 'text',
                items: [
                    'fontSize',
                    'fontFamily',
                    'fontColor',
                    'fontBackgroundColor'
                ],
            },
            'removeFormat',
            '|', 'alignment',
            '|', 'bulletedList', 'numberedList',
            '|', 'outdent', 'indent',
            '|', 'showBlocks', 'sourceEditing',
            '|', 'placeholder',
            'chartEmbed',
        ], shouldNotGroupWhenFull: true,
    },
    language: 'en',
    table: {
        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties' ],
        tableProperties: {
            // The default styles for tables in the editor.
            // They should be synchronized with the content styles.
            defaultProperties: {
                borderStyle: 'double',
                borderColor: 'hsl(0, 0%, 70%)',
                borderWidth: '1px',
                width: '100%',
                height: '100%'
            }
            // The default styles for table cells in the editor.
            // They should be synchronized with the content styles.
        },
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
        ]
    },
    alignment: {
        options: [ 'left', 'center', 'right', 'justify' ]
    },
    style: {
        definitions: [
            {
                name: 'Article category',
                element: 'h3',
                classes: [ 'category' ]
            },
            {
                name: 'Title',
                element: 'h2',
                classes: [ 'document-title' ]
            },
            {
                name: 'Subtitle',
                element: 'h3',
                classes: [ 'document-subtitle' ]
            },
            {
                name: 'Info box',
                element: 'p',
                classes: [ 'info-box' ]
            },
            {
                name: 'Side quote',
                element: 'blockquote',
                classes: [ 'side-quote' ]
            },
            {
                name: 'Marker',
                element: 'span',
                classes: [ 'marker' ]
            },
            {
                name: 'Spoiler',
                element: 'span',
                classes: [ 'spoiler' ]
            },
            {
                name: 'Code (dark)',
                element: 'pre',
                classes: [ 'fancy-code', 'fancy-code-dark' ]
            },
            {
                name: 'Code (bright)',
                element: 'pre',
                classes: [ 'fancy-code', 'fancy-code-bright' ]
            }
        ]
    },
    // ToDo: define the styles.
    image: {
        toolbar: [
            'imageStyle:block',
            'imageStyle:alignBlockLeft',
            'imageStyle:alignBlockRight',
            '|',
            'imageStyle:inline',
            'imageStyle:alignLeft',
            'imageStyle:alignRight',
            '|',
            'toggleImageCaption',
            'imageTextAlternative',
            '|',
            'linkImage'
        ],
        insert: {
            // If this setting is omitted, the editor defaults to 'block'.
            // See explanation below.
            type: 'auto'
        }
    },
    htmlEmbed: {
        showPreviews: true,
        sanitizeHtml: ( inputHtml ) => {
            // Strip unsafe elements and attributes, for example:
            // the `<script>` elements and `on*` attributes.
            //const outputHtml = sanitize( inputHtml );

            return {
                html: inputHtml,
                // true or false depending on whether the sanitizer stripped anything.
                hasChanged: false
            };
        }
    },
    htmlSupport: {
        allow: [
            {
                name: 'div',
                classes: [ 'grid', 'grid-cols-2', 'grid-cols-3', 'grid-cols-4', 'border-1', 'border-2', 'flex' ]
            },
        ]
    },
    chartList: []
};

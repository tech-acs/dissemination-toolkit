import { Plugin } from '@ckeditor/ckeditor5-core';
import { Widget, toWidget } from '@ckeditor/ckeditor5-widget';
import ChartEmbedCommand from './ChartEmbedCommand.js';

export default class ChartEmbedEditing extends Plugin {
    constructor( editor ) {
        super( editor );
    }

    static get requires() {
        return [ Widget ];
    }

    init() {
        this._defineSchema();
        this._defineConverters();

        this.editor.commands.add( 'chartEmbed', new ChartEmbedCommand( this.editor ) );
    }

    _defineSchema() {
        const schema = this.editor.model.schema;

        schema.register( 'chartEmbedElement', {
            inheritAllFrom: '$inlineObject',
            allowAttributes: [ 'id', 'viz-id', 'type', 'x-data', 'x-init' ]
        } );
    }

    _defineConverters() {
        const editor = this.editor;

        editor.conversion.for( 'upcast' ).elementToElement( {
            view: {
                name: 'div',
                attributes: [ 'id', 'viz-id', 'x-init', 'type' ]
            },
            model: ( viewElement, { writer } ) => {
                return writer.createElement( 'chartEmbedElement', {
                    'id': viewElement.getAttribute( 'id' ),
                    'viz-id': viewElement.getAttribute( 'viz-id' ),
                    'type': viewElement.getAttribute( 'type' )
                } );
            }
        } );

        editor.conversion.for( 'dataDowncast' ).elementToElement( {
            model: 'chartEmbedElement',
            view: ( modelElement, { writer } ) => {
                let id = modelElement.getAttribute('id')
                let vizType = modelElement.getAttribute('type')

                let vizInit
                if (vizType === 'Chart') {
                    vizInit = `new PlotlyChart('${id}')`
                } else if (vizType === 'Table') {
                    vizInit = `new AgGridTable('${id}')`
                }

                return writer.createEmptyElement( 'div', {
                    'id': id,
                    'viz-id': modelElement.getAttribute('viz-id'),
                    'type': vizType,
                    'x-init': vizInit
                } );
            }
        } );

        editor.conversion.for( 'editingDowncast' ).elementToElement( {
            model: 'chartEmbedElement',
            view: ( modelElement, { writer } ) => {
                let id = modelElement.getAttribute('id')
                let vizType = modelElement.getAttribute('type')

                let vizInit
                if (vizType === 'Chart') {
                    vizInit = `new PlotlyChart('${id}')`
                } else if (vizType === 'Table') {
                    vizInit = `new AgGridTable('${id}')`
                }

                const vizRootElement = writer.createRawElement(
                    'div',
                    {id: id, 'viz-id': modelElement.getAttribute('viz-id')}
                );

                const vizContainer = writer.createContainerElement(
                    'div',
                    {'x-init': vizInit},
                    vizRootElement
                );

                return toWidget( vizContainer, writer);
            }
        } );
    }
}

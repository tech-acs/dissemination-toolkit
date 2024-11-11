import { Plugin } from '@ckeditor/ckeditor5-core';
import { Widget, toWidget, viewToModelPositionOutsideModelElement } from '@ckeditor/ckeditor5-widget';
import PlaceholderCommand from './PlaceholderCommand.js';
import './theme/placeholder.css';

export default class PlaceholderEditing extends Plugin {
    static get requires() {
        return [ Widget ];
    }

    init() {
        console.log( 'PlaceholderEditing#init() got called' );

        this._defineSchema();
        this._defineConverters();

        this.editor.commands.add( 'placeholder', new PlaceholderCommand( this.editor ) );

        this.editor.editing.mapper.on(
            'viewToModelPosition',
            viewToModelPositionOutsideModelElement( this.editor.model, viewElement => viewElement.hasClass( 'placeholder' ) )
        );

        this.editor.config.define( 'placeholderConfig', {
            types: [ 'date', 'first name', 'surname']
        } );
    }

    _defineSchema() {
        const schema = this.editor.model.schema;

        schema.register( 'placeholder', {
            // Behaves like a self-contained inline object (e.g. an inline image)
            // allowed in places where $text is allowed (e.g. in paragraphs).
            // The inline widget can have the same attributes as text (for example linkHref, bold).
            inheritAllFrom: '$inlineObject',

            // The placeholder can have many types, like date, name, surname, etc:
            allowAttributes: [ 'name', 'x-init' ]
        } );
    }

    _defineConverters() {
        const editor = this.editor;

        editor.conversion.for( 'upcast' ).elementToElement( {
            view: {
                name: 'div',
                attributes: ['x-init']
            },
            model: ( viewElement, { writer } ) => {
                return writer.createElement( 'placeholder', {
                    'name': 'area'
                } );
            }
        } );

        editor.conversion.for( 'dataDowncast' ).elementToElement( {
            model: 'placeholder',
            view: ( modelElement, { writer } ) => {
                let name = modelElement.getAttribute('name')

                let init = `new DynamicText('${name}')`

                return writer.createEmptyElement( 'div', {
                    'name': name,
                    'x-init': init
                } );
            }
        } );

        editor.conversion.for( 'editingDowncast' ).elementToElement( {
            model: 'placeholder',
            view: ( modelElement, { writer } ) => {
                let name = modelElement.getAttribute('name')

                let init = `new DynamicText('${name}')`

                const vizRootElement = writer.createRawElement(
                    'div',
                    {name: name}
                );

                const vizContainer = writer.createContainerElement(
                    'div',
                    {'x-init': init},
                    vizRootElement
                );

                return toWidget( vizContainer, writer);
            }
        } );
    }
}

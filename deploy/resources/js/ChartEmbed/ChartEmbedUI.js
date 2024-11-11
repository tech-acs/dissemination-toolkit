import { Plugin } from '@ckeditor/ckeditor5-core';
import { ViewModel, addListToDropdown, createDropdown } from '@ckeditor/ckeditor5-ui';
import { Collection } from '@ckeditor/ckeditor5-utils';

export default class ChartEmbedUI extends Plugin {
    init() {
        const editor = this.editor;
        const t = editor.t;

        const chartList = this.editor.config.get('chartList')

        editor.ui.componentFactory.add( 'chartEmbed', locale => {
            const dropdownView = createDropdown( locale )
            addListToDropdown( dropdownView, getDropdownItemsDefinitions( chartList ) );
            dropdownView.buttonView.set( {
                label: t( 'Chart' ),
                tooltip: true,
                withText: true
            } );

            // Disable the placeholder button when the command is disabled.
            const command = editor.commands.get( 'chartEmbed' );
            dropdownView.bind( 'isEnabled' ).to( command );

            // Execute the command when the dropdown item is clicked (executed).
            this.listenTo( dropdownView, 'execute', evt => {
                editor.execute( 'chartEmbed', { value: evt.source.commandParam } );
                editor.editing.view.focus();
            } );

            return dropdownView;
        } );
    }
}

function getDropdownItemsDefinitions( charts ) {
    const itemDefinitions = new Collection();

    for ( const chart of charts ) {
        const definition = {
            type: 'button',
            model: new ViewModel( {
                //commandParam: chart.id,
                commandParam: chart,
                label: `${chart.name} (${chart.type})`,
                withText: true
            } )
        };

        // Add the item definition to the collection.
        itemDefinitions.add( definition );
    }

    return itemDefinitions;
}

import { Command } from '@ckeditor/ckeditor5-core';

export default class ChartEmbedCommand extends Command {
    execute(commandParam) {
        //console.log({commandParam})
        const editor = this.editor;
        const selection = editor.model.document.selection;

        editor.model.change( writer => {
            const externalWidget = writer.createElement(
                'chartEmbedElement', {
                    ...Object.fromEntries( selection.getAttributes() ),
                    'id': `viz-${commandParam.value.id}`,
                    'viz-id': commandParam.value.id,
                    'type': commandParam.value.type
                }
            );

            editor.model.insertObject( externalWidget, null, null, {
                setSelection: 'on'
            } );
        } );
    }

    refresh() {
        const model = this.editor.model;
        const selection = model.document.selection;

        const isAllowed = model.schema.checkChild( selection.focus.parent, 'chartEmbedElement' );

        this.isEnabled = isAllowed;
    }
}

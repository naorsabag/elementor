export class NotesContextMenu extends elementorModules.editor.utils.Module {
	onInit() {
		this.contextMenuNotesGroup();
	}

	contextMenuNotesGroup() {
		const elTypes = [ 'widget', 'section', 'column', 'container' ];

		elTypes.forEach( ( type ) => {
			elementor.hooks.addFilter( `elements/${ type }/contextMenuGroups`, this.contextMenuAddGroup );
		} );
	}

	/**
	 * Append the 'Notes' context menu group
	 *
	 * @since 3.8.0
	 *
	 * @param {Array} groups
	 * @return {Array} The updated groups.
	 */
	contextMenuAddGroup( groups ) {
		const deleteGroup = _.findWhere( groups, { name: 'delete' } );
		let deleteGroupIndex = groups.indexOf( deleteGroup );

		if ( -1 === deleteGroupIndex ) {
			deleteGroupIndex = groups.length;
		}

		groups.splice( deleteGroupIndex, 0, {
			name: 'notes',
			actions: [
				{
					name: 'open_notes',
					title: __( 'AI-Kitty!', 'elementor' ),
					shortcut: '<i class="eicon-pro-icon"></i>',
					promotionURL: 'https://go.elementor.com/go-pro-notes-context-menu/',
					isEnabled: () => true,
					callback: () => {
						const elementNodeListOf = document.querySelectorAll( '.elementor-heading-title, .elementor-text-editor' );
						console.log( 'Element Node List Of:', elementNodeListOf );
						elementNodeListOf
							.forEach( ( elInput ) => {
								const clickHandler = ( event ) => {
									console.log( `AI-KITTY!!!!!! You clicked on: ${ event.target.className }` );
									window.aiKitty.clickedElement = event.target;
									elInput.removeEventListener( 'click', clickHandler );

									document.querySelectorAll( '.elementor-field-textual' )
										.forEach( ( elOutput ) => {
											const clickHandlerOut = ( eventOut ) => {
												console.log( `You clicked on: ${ eventOut.target.className }` );
												window.aiKitty.clickedElement = eventOut.target;
												elOutput.removeEventListener( 'click', clickHandlerOut );

												const instructions = prompt( 'Insert Prompt' );
												if ( instructions ) {
													console.log( `Prompt: ${ instructions }` );
													window.aiKitty.prompt = instructions;
												}
											};
											elInput.addEventListener( 'click', clickHandlerOut );
										} );
								};
								elInput.addEventListener( 'click', clickHandler );
							} );
					},
				},
			],
		} );

		return groups;
	}
}

export default NotesContextMenu;

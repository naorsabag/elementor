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
			name: 'ai-kitty',
			actions: [
				{
					name: 'open-ai-kitty',
					title: __( 'AI-Kitty!', 'elementor' ),
					shortcut: '<i class="eicon-ai"></i>',
					isEnabled: () => true,
					callback: () => {
						alert( 'AI-Kitty!' );
					},
				},
			],
		} );

		return groups;
	}
}

export default NotesContextMenu;

import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { Panel, PanelBody, CheckboxControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { useState, useEffect } from '@wordpress/element';

export default function Edit( { attributes, setAttributes } ) {
	const [ gotUsersList, setGotUsersList ] = useState( false );

	// All the table content
	const [ tableData, setTableData ] = useState( {
		title: '',
		headers: [],
		rows: [],
		fields: [],
		hiddenFields: {},
	} );

	const apiPath = '/joaocarvalho/v1/users/';

	// run only once, if the gotUsersList is false
	useEffect( () => {
		async function fetchUsers() {
			if ( gotUsersList === false ) {
				apiFetch( { path: apiPath } ).then( ( users ) => {
					// Prepare the table headers and fields names
					const rowKeys = Object.keys( users?.data?.rows[ 1 ] );
					const rowHeaders = Object.values( users?.data?.headers );
					const obj = Object.assign(
						{},
						...rowKeys.map( ( e, i ) => ( {
							[ e ]: rowHeaders[ i ],
						} ) )
					);

					// Prepare the hidden fields
					if ( attributes.hiddenFields.length === 0 ) {
						const hiddenFields = [];
						rowKeys.map( ( key ) => {
							return ( hiddenFields[ key ] = false );
						} );

						setAttributes( { hiddenFields } );
					}

					// Store the settings
					setTableData( {
						title: users?.title ?? '',
						headers: users?.data?.headers ?? [],
						rows: users?.data?.rows ?? [],
						fields: obj ?? [],
					} );

					setGotUsersList( true );
				} );
			}
		}

		fetchUsers();
	} );

	const onChangeHide = ( attribute ) => {
		// Gets all the hidden fields
		const attributeValue = attributes.hiddenFields[ attribute ];
		const newHiddenFields = {
			...attributes.hiddenFields,
			[ attribute ]: ! attributeValue,
		};

		// Update the hidden fields
		setAttributes( { hiddenFields: newHiddenFields } );
	};

	setAttributes( { tableContent: tableData } );

	return (
		<div { ...useBlockProps() }>
			<InspectorControls key="setting">
				<Panel>
					<PanelBody
						icon={ 'layout' }
						title={ __( 'Hide Columns', 'api-plugin' ) }
						initialOpen={ false }
					>
						{ Object.values( tableData.fields ).map(
							( header, index ) => (
								<CheckboxControl
									key={ header }
									label={ header }
									checked={
										attributes.hiddenFields[
											Object.keys( tableData.fields )[
												index
											]
										]
									}
									onChange={ () =>
										onChangeHide(
											Object.keys( tableData.fields )[
												index
											]
										)
									}
								/>
							)
						) }
					</PanelBody>
				</Panel>
			</InspectorControls>

			<div className="plugin-content">
				<h4>{ attributes.tableContent.title }</h4>

				<table>
					<thead>
						<tr>
							{ Object.values( tableData.fields ).map(
								( header, index ) =>
									! attributes.hiddenFields[
										Object.keys( tableData.fields )[ index ]
									] && (
										<th
											key={ header }
											className={
												Object.keys( tableData.fields )[
													index
												]
											}
										>
											{ header }
										</th>
									)
							) }
						</tr>
					</thead>

					<tbody>
						{ Object.values( tableData.rows ).map( ( row ) => (
							<tr key={ row.id }>
								{ Object.values( row ).map(
									( element, index ) =>
										! attributes.hiddenFields[
											Object.keys( row )[ index ]
										] && (
											<td
												key={ element }
												className={
													Object.keys( row )[ index ]
												}
											>
												{ element }
											</td>
										)
								) }
							</tr>
						) ) }
					</tbody>
				</table>
			</div>
		</div>
	);
}

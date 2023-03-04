import { useBlockProps } from '@wordpress/block-editor';

export default function Save( { attributes } ) {
	return (
		<div { ...useBlockProps.save() }>
			<div className="plugin-content">
				<h4>{ attributes.tableContent.title }</h4>

				<table>
					<thead>
						<tr>
							{ Object.values(
								attributes.tableContent.fields
							).map(
								( header, index ) =>
									! attributes.hiddenFields[
										Object.keys(
											attributes.tableContent.fields
										)[ index ]
									] && (
										<th
											key={ header }
											className={
												Object.keys(
													attributes.tableContent
														.fields
												)[ index ]
											}
										>
											{ header }
										</th>
									)
							) }
						</tr>
					</thead>

					<tbody>
						{ Object.values( attributes.tableContent.rows ).map(
							( row ) => (
								<tr key={ row.id }>
									{ Object.values( row ).map(
										( element, index ) =>
											! attributes.hiddenFields[
												Object.keys( row )[ index ]
											] && (
												<td
													key={ element }
													className={
														Object.keys( row )[
															index
														]
													}
												>
													{ element }
												</td>
											)
									) }
								</tr>
							)
						) }
					</tbody>
				</table>
			</div>
		</div>
	);
}

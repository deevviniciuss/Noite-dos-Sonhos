/**
 * Table
 *
 * Works with tables to handle data population, pagination, and filtering.
 *
 * @author Alex Standiford
 * @since 1.0.0
 * @global table
 *
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import table from '@affiliatewp-portal/alpine-table'
import { portalSchemaColumns } from '@affiliatewp-portal/sdk';

/**
 * Table handler for visits.
 *
 * Works referrals table to handle data population, pagination, and filtering.
 *
 * @since 1.0.0
 * @access private
 * @global visitsTable
 * @arguments table
 *
 * @returns object The visits table AlpineJS object.
 */
export default ( args = {} ) => {
	const result = { ...table, ...args };
	result.fetchPage = async function ( page ) {
		const fetchPage = table.fetchPage.bind( this );

		// If we have already retrieved the schema columns, just fetch the rows.
		if ( this.schema.length ) {
			return fetchPage( page );
		}

		// Declare the promise that will ultimately set the schema.
		const columnsPromise = new Promise( async ( res, rej ) => {
			const control = await portalSchemaColumns( this.type );
			this.schema = control.columns;

			res( control.columns );
		} );

		// Fetch both both the columns and rows at the same time.
		const [rows, columns] = await Promise.all( [columnsPromise, fetchPage( page )] );

		// Return the fetched page
		return rows;
	}

	return result;
};

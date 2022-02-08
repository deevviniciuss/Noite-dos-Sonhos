/**
 * Internal dependencies
 */
import {portalDataset} from '@affiliatewp-portal/sdk';
/**
 * External dependencies
 */
import Chart from 'chart.js';
import 'alpinejs';

export default {

	isLoading: true,

	datasets: [],

	type: '',

	chartArgs: {
		type: 'line',
		options: {
			elements: {
				line: {
					tension: 0
				}
			}
		},
	},

	chart: false,

	label: '',

	dateQueries: [
		{
			key: 'today',
			label: 'Today',
		},
		{
			key: 'yesterday',
			label: 'Yesterday',
		},
		{
			key: 'this_week',
			label: 'This Week',
		},
		{
			key: 'last_week',
			label: 'Last Week',
		},
		{
			key: 'this_month',
			label: 'This Month',
		},
		{
			key: 'last_month',
			label: 'Last Month',
		},
		{
			key: 'this_quarter',
			label: 'This Quarter',
		},
		{
			key: 'last_quarter',
			label: 'Last Quarter',
		},
		{
			key: 'this_year',
			label: 'This Year',
		},
		{
			key: 'last_year',
			label: 'Last Year',
		},
	],

	currentDateQuery: '',

	/**
	 *
	 * @param e
	 */
	handleSubmit( e ) {
		e.preventDefault();

		this.updateChart( this.currentDateQuery );
	},

	/**
	 *
	 * @param e
	 */
	handleSelectChange( e ) {
		this.currentDateQuery = e.target.value;
	},

	/**
	 *
	 * @param type
	 * @returns {*}
	 */
	getDateQuery( type ) {
		let dateQueryType = this.dateQueries.find( item => item.key === type );

		return undefined === dateQueryType ? false : dateQueryType;
	},

	/**
	 *
	 * @param control
	 */
	prepareChartData() {
		this.data = {};

		// Prepare the datasets (The y-axis)
		this.chartArgs.data.datasets = this.prepareDatasets();

		// Prepare the labels (the x-axis)
		this.chartArgs.data.labels = this.prepareLabels()
	},

	/**
	 *
	 * @param dateQueryType
	 */
	async updateChart( dateQueryType ) {
		this.isLoading = true;
		this.control = await this.fetchPortalData( dateQueryType );

		this.prepareChartData();
		this.chart.update();
		this.isLoading = false;
	},


	prepareDatasets() {
		// Replace the data provided in the control with the rendered data.
		return this.control.map( controlItem => ( {
			...controlItem,
			...{
				data: controlItem.data.map( controlData => controlData.data )
			}
		} ) );
	},
	/**
	 *
	 * @param data
	 * @returns {*}
	 */
	prepareLabels() {
		const data = this.control.map( controlItem => controlItem.data );

		return data[0].map( datum => datum[this.label] );
	},

	/**
	 *
	 * @param dateQueryType
	 * @returns {Promise}
	 */
	fetchPortalData( dateQueryType ) {
		console.error( 'undefined_dashboard_callback', 'To use this chart, you must provide a method to fetch dashboard data.' );
		return []
	},

	/**
	 * Init.
	 *
	 * Initializes the AlpineJS instance.
	 *
	 * @since      1.0.0
	 * @access     public
	 *
	 * @return void
	 */
	async init() {
		if ( this.$refs.canvas ) {
			this.chartArgs.data = {};

			// Fetch the portal data.
			this.control = await this.fetchPortalData( 'today' );

			// Update the chart data
			this.prepareChartData();

			// Create the chart
			this.chart = new Chart( this.$refs.canvas.getContext( '2d' ), this.chartArgs );

			// Notify Alpine that this is no-longer loading
			this.isLoading = false;
		}
	}
}
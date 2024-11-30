jQuery('#chart1').vectorMap({
	map: 'world_mill_en',
	backgroundColor: '#008540',
	borderWidth: 1,
	zoomOnScroll: false,
	color: '#ddd',
	regionStyle: {
		initial: {
			fill: '#fff'
		}
	},
	enableZoom: true,
	normalizeFunction: 'linear',
	showTooltip: true
});
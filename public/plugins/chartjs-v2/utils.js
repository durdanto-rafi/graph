/* global Chart */

'use strict';

window.chartColors = {
	red: '#D50000',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: '#008000',
	blue: '#0000CD',
	sky: 'rgb(54, 162, 235)',
	purple: '#9C27B0',
	grey: 'rgb(201, 203, 207)'
};

window.randomScalingFactor = function() {
	return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
};


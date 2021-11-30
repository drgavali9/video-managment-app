

(function (window, undefined) {
	'use strict';

	var $primary = '#168a7c',
		$success = '#103e39',
		$danger = '#EA5455',
		$warning = '#FF9F43',
		$info = '#00cfe8',
		$label_color_light = '#dae1e7';

	var themeColors = [$primary, $success, $danger, $warning, $info];

	// RTL Support
	var yaxis_opposite = false;
	if ($('html').data('textdirection') == 'rtl') {
		yaxis_opposite = true;
	}

	// Column Chart
	// ----------------------------------
	var columnChartOptions = {
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			},
		},
		colors: themeColors,
		plotOptions: {
			bar: {
				horizontal: false,
				endingShape: 'rounded',
				columnWidth: '30%',
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Net Profit',
			data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
		}, {
			name: 'Revenue',
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}],
		legend: {
			offsetY: -10
		},
		xaxis: {
			categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
		},
		yaxis: {
			title: {
				text: '$ (thousands)'
			},
			opposite: yaxis_opposite
		},
		fill: {
			opacity: 1

		},
		tooltip: {
			y: {
				formatter: function (val) {
					return "$ " + val + " thousands"
				}
			}
		}
	}
	var columnChart = new ApexCharts(
		document.querySelector("#column-chart"),
		columnChartOptions
	);

	// columnChart.render();

	// Bar Chart

	// Subscribed Gained Chart
	// ----------------------------------

	var gainedChartoptions = {
		chart: {
			height: 70,
			type: 'area',
			toolbar: {
				show: false,
			},
			sparkline: {
				enabled: true
			},
			grid: {
				show: false,
				padding: {
					left: 0,
					right: 0
				}
			},
		},
		colors: [$primary],
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'straight',
			width: 2.5
		},
		fill: {
			type: 'gradient',
			gradient: {
				shadeIntensity: 0.9,
				opacityFrom: 0.7,
				opacityTo: 0.5,
				stops: [0, 80, 100]
			}
		},
		series: [{
			name: 'Subscribers',
			data: [28, 40, 36, 52, 38, 60, 55]
		}],

		xaxis: {

			labels: {
				show: false,
			},
			axisBorder: {
				show: false,
			}
		},
		yaxis: [{
			y: 0,
			offsetX: 0,
			offsetY: 0,
			padding: {
				left: 0,
				right: 0
			},
		}],
		tooltip: {
			x: {
				show: true
			}
		},
	}

	var gainedChart = new ApexCharts(
		document.querySelector("#line-area-chart-1"),
		gainedChartoptions
	);

	// gainedChart.render();


	// Line Chart
	// ----------------------------------
	var lineChartOptions = {
		chart: {
			height: 350,
			type: 'line',
			zoom: {
				enabled: false
			}
		},
		colors: themeColors,
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'straight'
		},
		series: [{
			name: "Desktops",
			data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
		}],

		grid: {
			row: {
				colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
				opacity: 0.5
			},
		},
		xaxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
		},
		yaxis: {
			tickAmount: 5,
			opposite: yaxis_opposite
		}
	}
	var lineChart = new ApexCharts(
		document.querySelector("#line-chart"),
		lineChartOptions
	);
	// lineChart.render();


	// $('.data-list').DataTable({
	//   "bPaginate": false,
	//   "bFilter": false,
	//   "bInfo": false

	// });


	// $('select').niceSelect();

	// $(".shipping-details li").click(function () {
	//   $(this).addClass('active');

	// });
	// $(".shipping-info-list li").click(function () {
	//   $(this).addClass('active');
	// });
	// $(".shipping-info-list .update").click(function () {
	//   $(this).addClass('active');
	//   $(".shipping-info-list .update-form").addClass('active');
	// });

	var tbl;
	$(document).ready(function () {
		// tbl = $('.example').DataTable({
		//   columnDefs: [{
		//       targets: 0,
		//       data: 2,
		//       'checkboxes': {
		//         'selectRow': true
		//       }
		//     },
		//     {
		//       "visible": true,
		//       "targets": 1
		//     }
		//   ],
		//   select: {
		//     style: 'multi'
		//   },
		//   order: [
		//     [1, 'asc']
		//   ],
		//   iDisplayLength: 10,

		// });
	});

	function getSelected() {
		var selectedIds = tbl.columns().checkboxes.selected()[0];
		console.log(selectedIds)

		selectedIds.forEach(function (selectedId) {
			alert(selectedId);
		});
	}

	$(document).ready(function () {
		$(".dt-checkboxes-cell  input").change(function () {
			if ($(this).prop('checked')) {
				$('.data-hide').hide();
				$('.data-show').show();
			}
			else {
				$('.data-hide').show();
				$('.data-show').hide();
			}
		});

		$('.action-delete').on("click", function (e) {
			e.stopPropagation();
			$(this).closest('td').parent('tr').fadeOut();
		});

	});

	$(document).on('hidden.bs.modal', function (event) {
		if ($('.modal:visible').length) {
			$('body').addClass('modal-open');
		}
	});

	if ($(".loction-slider .item").length) {
		$('.loction-slider').owlCarousel({
			loop: false,
			autoplay: false,
			mouseDrag: true,
			autoplayTimeout: 4000,
			smartSpeed: 1200,
			margin: 10,
			nav: true,
			dots: false,
			navText: ["<i class='feather icon-chevron-left'></i>", "<i class='feather icon-chevron-right'></i>"],
			responsive: {
				0: {
					items: 1
				},
				575: {
					items: 2
				},
				768: {
					items: 2
				},
				992: {
					items: 2
				},

			}
		});
	}
	if ($(".form-group .date").length) {
		$('.form-group .date').datepicker({
			format: 'dd/mm/yyyy',
			todayBtn: "linked",
			todayHighlight: true,
		});
	}
	if ($(".form-group select").length) {
		$('.form-group select').select2();
	}
	if ($(".pickatime").length) {
		$('.pickatime').pickatime({
			format: 'HH:i',
		});
	}

})(window);

function confomationDailog(SelObj, url, id, key, val, type = "update", table_reload = false) {
	Swal.fire({
		title: 'Are you sure?',
		text: "You want to " + type + " this!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085D6',
		cancelButtonColor: '#DD3333',
		confirmButtonText: 'Yes, ' + type + ' it!'
	}).then((result) => {
		if (result.isConfirmed) {
			let formData = new FormData();
			formData.append(key, val);
			$.ajax({
				url: url + id,
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					if (response.success === true) {
						Swal.fire(
							type + 'd!',
							response.message,
							'success'
						);
						if (table_reload == true) {
							table.ajax.reload()
						}
					} else {
						Swal.fire(
							'Error',
							response.message,
							'error'
						);
						if ($(SelObj).is(':checked')) {
							$(SelObj).prop('checked', false);
						} else {
							$(SelObj).prop('checked', true);
						}
					}
				},
				error: function (response, status, error) {
					Swal.fire(
						'Error',
						response.message,
						'error'
					);
					if ($(SelObj).is(':checked')) {
						$(SelObj).prop('checked', false);
					} else {
						$(SelObj).prop('checked', true);
					}
				}
			});
		} else {
			if ($(SelObj).is(':checked')) {
				$(SelObj).prop('checked', false);
			} else {
				$(SelObj).prop('checked', true);
			}
		}
	})
}


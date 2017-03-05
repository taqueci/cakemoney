var myDoughnutChart = new Chart(
    document.getElementById('<?= $id ?>').getContext('2d'), {
		type: 'doughnut',
		data: {
			labels: <?= json_encode($label) ?>,
			datasets: [{
				data: <?= json_encode($data) ?>,
				backgroundColor: [
					"#FF6384",
					"#36A2EB",
					"#FFCE56",
					'#e2b2c0',
					'#fff353',
					'#a5d1f4',
					'#e4ad6d',
					'#d685b0',
					'#dbe159',
					'#7fc2ef',
					'#c4a6ca',
					'#eabf4c',
					'#f9e697',
					'#b3d3ac',
					'#eac7cd'
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56",
					'#e2b2c0',
					'#fff353',
					'#a5d1f4',
					'#e4ad6d',
					'#d685b0',
					'#dbe159',
					'#7fc2ef',
					'#c4a6ca',
					'#eabf4c',
					'#f9e697',
					'#b3d3ac',
					'#eac7cd'
                ]
            }]
		}
	}
);

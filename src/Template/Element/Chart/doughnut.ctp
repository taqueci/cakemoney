<?php
$label = [];
$value = [];
foreach ($data as $x) {
	$label[] = $x->name;
	$value[] = $x->sum;
}

$color = [
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
];
?>
<?php if (count($label)): ?>
var myDoughnutChart = new Chart(
	document.getElementById('<?= h($id) ?>').getContext('2d'), {
		type: 'doughnut',
		options: {
			maintainAspectRatio: false
		},
		data: {
			labels: <?= json_encode($label) ?>,
			datasets: [{
				data: <?= json_encode($value) ?>,
				backgroundColor: <?= json_encode($color) ?>,
				hoverBackgroundColor: <?= json_encode($color) ?>
			}]
		}
	}
);
<?php else: ?>
$(function() {
    $('#<?= h($id) ?>').after('<div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?= __('No data') ?></div>');
    $('#<?= h($id) ?>').hide();
});
<?php endif ?>

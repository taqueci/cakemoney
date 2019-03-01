<?php
$label = [];
$value = [];
foreach ($data as $x) {
	$label[] = $x->name;
	$value[] = $x->sum;
}

$color = [
    '#ff4081', // 02
    '#448aff', // 06
    '#69f0ae', // 10
    '#ffd740', // 14
    '#e040fb', // 03
    '#40c4ff', // 07
    '#b2ff59', // 11
    '#ffab40', // 15
    '#ff5252', // 01
    '#536dfe', // 05
    '#64ffda', // 09
    '#ffff00', // 13
    '#7c4dff', // 04
    '#18ffff', // 08
    '#eeff41', // 12
    '#ff6e40', // 16
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
$('#<?= h($id) ?>').after('<div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> <?= __('No data') ?></div>');
$('#<?= h($id) ?>').hide();
<?php endif ?>

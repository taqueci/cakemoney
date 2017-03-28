<?php
$label = [];
$incoming = [];
$outgoing = [];

foreach ($data as $x) {
	$label[] = $format($x);
	$incoming[] = $x->income;
	$outgoing[] = $x->expense;
}
?>
var myChart = new Chart(
	document.getElementById('<?= h($id) ?>').getContext('2d'), {
		type: 'line',
		options: {
			maintainAspectRatio: false
		},
		data: {
			labels: <?= json_encode($label) ?>,
			datasets: [{
				label: '<?= __('Incomings') ?>',
				data: <?= json_encode($incoming) ?>,
				backgroundColor: "rgba(153,255,51,0.4)"
			}, {
				label: '<?= __('Outgoings') ?>',
				data: <?= json_encode($outgoing) ?>,
				backgroundColor: "rgba(255,153,0,0.4)"
			}]
		}
	}
);
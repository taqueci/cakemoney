<?php
$label = [];
$asset = [];
$liability = [];

foreach ($data as $x) {
	$label[] = $format($x);
	$asset[]     = $x->asset;
	$liability[] = $x->liability;
}
?>
{
	labels: <?= json_encode($label) ?>,
	datasets: [{
		label: '<?= __('Assets') ?>',
		data: <?= json_encode($asset) ?>,
		backgroundColor: "rgba(153,255,51,0.4)"
	}, {
		label: '<?= __('Liabilities') ?>',
		data: <?= json_encode($liability) ?>,
		backgroundColor: "rgba(255,153,0,0.4)"
	}]
}

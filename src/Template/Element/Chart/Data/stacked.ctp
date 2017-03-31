<?php
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

$label = [];
$value = [];
foreach ($data as $x) {
	$l = $format($x);
	$label[$l] = 1;
	foreach ($category as $c) {
		if (isset($value[$c][$l])) {
			$value[$c][$l] += ($x->name === $c) ? $x->sum : 0;
		}
		else {
			$value[$c][$l] = ($x->name === $c) ? $x->sum : 0;
		}
	}
}

$dataset = [];
$i = 0;
foreach ($value as $k => $v) {
	$dataset[] = [
		'label' => $k,
		'borderWidth' => 0,
		'backgroundColor' => isset($color[$i]) ? $color[$i] : null,
		'data' => array_values($v)
	];

    $i++;
}
?>
{
	labels: <?= json_encode(array_keys($label)) ?>,
	datasets: <?= json_encode($dataset) ?>
}

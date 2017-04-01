<?php
$color = [
    '#ff80ab', // 02
    '#82b1ff', // 06
    '#b9f6ca', // 10
    '#ffe57f', // 14
    '#ea80fc', // 03
    '#80d8ff', // 07
    '#ccff90', // 11
    '#ffd180', // 15
    '#b388ff', // 04
    '#84ffff', // 08
    '#f4ff81', // 12
    '#ff9e80', // 16
    '#ff8a80', // 01
    '#8c9eff', // 05
    '#a7ffeb', // 09
    '#ffff8d', // 13
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

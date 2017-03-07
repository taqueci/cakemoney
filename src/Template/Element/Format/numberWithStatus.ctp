<?php
if ($value < 0) {
    $class = 'text-danger';
    $icon = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;';
}
else {
    $class = 'text-success';
    $icon = '';
}
?>
<span class="<?= $class ?>"><?= $icon ?><?= number_format($value) ?></span>

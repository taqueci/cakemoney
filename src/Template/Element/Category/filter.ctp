<div id="category-filter" class="btn-group" role="group" aria-label="Category filter">
  <button id="category-filter-btn-outgoings" type="button" class="btn btn-default"><?= __('Outgoings') ?></button>
  <button id="category-filter-btn-incomings" type="button" class="btn btn-default"><?= __('Incomings') ?></button>
  <button id="category-filter-btn-repayments" type="button" class="btn btn-default"><?= __('Repayments') ?></button>
  <button id="category-filter-btn-all" type="button" class="btn btn-default"><?= __('Other') ?></button>
</div>
<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
	$('body').after('<select id="attic"></select>');
	$('#attic').hide();
	$('<?= h($debit_id) ?> optgroup').clone().appendTo('#attic');

	$('#category-filter-btn-all').addClass('active');
});

$('#category-filter button').click(function() {
	$('#category-filter button').removeClass('active');
	$(this).addClass('active');
});

$('#category-filter-btn-outgoings').click(function() {
	$('<?= h($debit_id) ?> optgroup').remove();
	$('#attic optgroup[label="<?= __('Expense') ?>"]').clone().appendTo('<?= h($debit_id) ?>');

	$('<?= h($credit_id) ?> optgroup').remove();
	$('#attic optgroup[label="<?= __('Asset') ?>"]').clone().appendTo('<?= h($credit_id) ?>');
	$('#attic optgroup[label="<?= __('Liability') ?>"]').clone().appendTo('<?= h($credit_id) ?>');
});

$('#category-filter-btn-incomings').click(function() {
	$('<?= h($debit_id) ?> optgroup').remove();
	$('#attic optgroup[label="<?= __('Asset') ?>"]').clone().appendTo('<?= h($debit_id) ?>');

	$('<?= h($credit_id) ?> optgroup').remove();
	$('#attic optgroup[label="<?= __('Income') ?>"]').clone().appendTo('<?= h($credit_id) ?>');
});

$('#category-filter-btn-repayments').click(function() {
	$('<?= h($debit_id) ?> optgroup').remove();
	$('#attic optgroup[label="<?= __('Liability') ?>"]').clone().appendTo('<?= h($debit_id) ?>');

	$('<?= h($credit_id) ?> optgroup').remove();
	$('#attic optgroup[label="<?= __('Asset') ?>"]').clone().appendTo('<?= h($credit_id) ?>');
	$('#attic optgroup[label="<?= __('Liability') ?>"]').clone().appendTo('<?= h($credit_id) ?>');
});

$('#category-filter-btn-all').click(function() {
	$('<?= h($debit_id) ?> optgroup').remove();
	$('#attic optgroup').clone().appendTo('<?= h($debit_id) ?>');

	$('<?= h($credit_id) ?> optgroup').remove();
	$('#attic optgroup').clone().appendTo('<?= h($credit_id) ?>');
});

function category_filter_reset() {
	$('#category-filter button').removeClass('active');
	$('#category-filter-btn-all').addClass('active');

	$('<?= h($debit_id) ?> optgroup').remove();
	$('#attic optgroup').clone().appendTo('<?= h($debit_id) ?>');

	$('<?= h($credit_id) ?> optgroup').remove();
	$('#attic optgroup').clone().appendTo('<?= h($credit_id) ?>');
}

<?php $this->Html->scriptEnd(); ?>

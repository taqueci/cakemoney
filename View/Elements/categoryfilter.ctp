<div id="category-filter" class="btn-group" role="group" aria-label="Category filter">
  <button id="category-filter-btn-outgoings" type="button" class="btn btn-default"><?php echo __('Outgoings'); ?></button>
  <button id="category-filter-btn-incomings" type="button" class="btn btn-default"><?php echo __('Incomings'); ?></button>
  <button id="category-filter-btn-all" type="button" class="btn btn-default active"><?php echo __('All'); ?></button>
</div>

<script type="text/javascript">
$(function() {
	$('body').after('<select id="attic"></select>');
	$('#attic').hide();
	$('<?php echo $debit; ?> optgroup').clone().appendTo('#attic');
});

$('#category-filter button').click(function() {
	$('#category-filter button').removeClass('active');
	$(this).addClass('active');
});

$('#category-filter-btn-outgoings').click(function() {
	$('<?php echo $debit; ?> optgroup').remove();
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_EXPENSE]; ?>"]').clone().appendTo('<?php echo $debit; ?>');

	$('<?php echo $credit; ?> optgroup').remove();
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_ASSET]; ?>"]').clone().appendTo('<?php echo $credit; ?>');
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_LIABILITY]; ?>"]').clone().appendTo('<?php echo $credit; ?>');
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_INCOME]; ?>"]').clone().appendTo('<?php echo $credit; ?>');
});

$('#category-filter-btn-incomings').click(function() {
	$('<?php echo $debit; ?> optgroup').remove();
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_ASSET]; ?>"]').clone().appendTo('<?php echo $debit; ?>');
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_LIABILITY]; ?>"]').clone().appendTo('<?php echo $debit; ?>');
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_EXPENSE]; ?>"]').clone().appendTo('<?php echo $debit; ?>');

	$('<?php echo $credit; ?> optgroup').remove();
	$('#attic optgroup[label="<?php echo $account[ACCOUNT_INCOME]; ?>"]').clone().appendTo('<?php echo $credit; ?>');
});

$('#category-filter-btn-all').click(function() {
	$('<?php echo $debit; ?> optgroup').remove();
	$('#attic optgroup').clone().appendTo('<?php echo $debit; ?>');

	$('<?php echo $credit; ?> optgroup').remove();
	$('#attic optgroup').clone().appendTo('<?php echo $credit; ?>');
});
</script>

<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-9">
    <?= $this->Form->create($journal) ?>
	<fieldset>
	  <legend><?= __('Edit Journal'); ?></legend>
	  <div class="form-group" align="right">
		<div id="category-filter" class="btn-group" role="group" aria-label="Category filter">
		  <button id="category-filter-btn-outgoings" type="button" class="btn btn-default"><?= __('Outgoings') ?></button>
		  <button id="category-filter-btn-incomings" type="button" class="btn btn-default"><?= __('Incomings') ?></button>
		  <button id="category-filter-btn-all" type="button" class="btn btn-default"><?= __('Other') ?></button>
		</div>
		<div class="btn-group">
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?= __('Popular selections') ?> <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
			<?php foreach ($selections as $x): ?>
			<li><a href="#" onClick="setCategory(<?= $x->debit_id ?>, <?= $x->credit_id ?>)"><?= h($x->debit->name) ?> / <?= h($x->credit->name) ?></a></li>
			<?php endforeach; ?>
		  </ul>
		</div>
	  </div>
	  <?= $this->Form->input('id') ?>
	  <?= $this->Form->input('debit_id', ['label' => __('Debit'), 'showParents' => true]) ?>
	  <?= $this->Form->input('credit_id', ['label' => __('Credit'), 'showParents' => true]) ?>
	  <?= $this->Form->input('date', ['label' => __('Date'), 'type'=>'text', 'append' => '<button id="datepicker" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>']) ?>
	  <?= $this->Form->input('amount', ['label' => __('Amount')]) ?>
	  <?= $this->Form->input('summary', ['label' => __('Summary')]) ?>
	  <?= $this->Form->input('description', ['label' => __('Description'), 'type' => 'textarea']) ?>
	</fieldset>
	<div class="form-group">
	  <?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-primary']) ?>
	</div>
	<?= $this->Form->end() ?>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Journals'), ['action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>
</div>

<?php
$this->prepend('css', $this->Html->css([Configure::read('Css.bootstrapDatepicker')]));
$this->prepend('script', $this->Html->script([Configure::read('Js.bootstrapDatepicker')]));
?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(function() {
    $('#datepicker').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
    });
	$('#datepicker').on("changeDate", function() {
		$('#date').val($('#datepicker').datepicker('getFormattedDate'));
	});
});

$(function() {
	$('body').after('<select id="attic"></select>');
	$('#attic').hide();
	$('#debit-id optgroup').clone().appendTo('#attic');

	$('#category-filter-btn-all').addClass('active');
});

$('#category-filter button').click(function() {
	$('#category-filter button').removeClass('active');
	$(this).addClass('active');
});

$('#category-filter-btn-outgoings').click(function() {
	$('#debit-id optgroup').remove();
	$('#attic optgroup[label="<?= __('Expense') ?>"]').clone().appendTo('#debit-id');

	$('#credit-id optgroup').remove();
	$('#attic optgroup[label="<?= __('Asset') ?>"]').clone().appendTo('#credit-id');
	$('#attic optgroup[label="<?= __('Liability') ?>"]').clone().appendTo('#credit-id');
	$('#attic optgroup[label="<?= __('Income') ?>"]').clone().appendTo('#credit-id');
});

$('#category-filter-btn-incomings').click(function() {
	$('#debit-id optgroup').remove();
	$('#attic optgroup[label="<?= __('Asset') ?>"]').clone().appendTo('#debit-id');
	$('#attic optgroup[label="<?= __('Liability') ?>"]').clone().appendTo('#debit-id');
	$('#attic optgroup[label="<?= __('Expense') ?>"]').clone().appendTo('#debit-id');

	$('#credit-id optgroup').remove();
	$('#attic optgroup[label="<?= __('Income') ?>"]').clone().appendTo('#credit-id');
});

$('#category-filter-btn-all').click(function() {
	$('#debit-id optgroup').remove();
	$('#attic optgroup').clone().appendTo('#debit-id');

	$('#credit-id optgroup').remove();
	$('#attic optgroup').clone().appendTo('#credit-id');
});

function setCategory(did, cid) {
	$('#category-filter button').removeClass('active');
	$('#category-filter-btn-all').addClass('active');

	$('#debit-id optgroup').remove();
	$('#attic optgroup').clone().appendTo('#debit-id');

	$('#credit-id optgroup').remove();
	$('#attic optgroup').clone().appendTo('#credit-id');

	$('#debit-id').val(did);
	$('#credit-id').val(cid);
}
<?php $this->Html->scriptEnd(); ?>

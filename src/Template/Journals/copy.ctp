<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-9 has-margin-bottom">
    <?= $this->Form->create($journal) ?>
	<fieldset>
	  <legend><?= __('Copy Journal') ?></legend>
	  <div class="has-margin-bottom" align="right">
		<?= $this->element('Category/filter', ['debit_id' => '#debit-id', 'credit_id' => '#credit-id']) ?>
		<div class="btn-group">
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?= __('Popular selections') ?> <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu dropdown-menu-right">
			<?php foreach ($selections as $x): ?>
			<li><a href="#" onClick="setCategory(<?= $x->debit_id ?>, <?= $x->credit_id ?>)"><?= h($x->debit->name) ?> / <?= h($x->credit->name) ?></a></li>
			<?php endforeach; ?>
		  </ul>
		</div>
	  </div>
	  <?= $this->Form->input('debit_id', ['label' => __('Debit'), 'showParents' => true]) ?>
	  <?= $this->Form->input('credit_id', ['label' => __('Credit'), 'showParents' => true]) ?>
	  <?= $this->Form->input('date', ['label' => __('Date'), 'type'=>'text', 'append' => '<button id="datepicker" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>', 'value' => date('Y-m-d')]) ?>
	  <?= $this->Form->input('amount', ['label' => __('Amount')]) ?>
	  <?= $this->Form->input('summary', ['label' => __('Summary')]) ?>
	  <?= $this->Form->input('description', ['label' => __('Description'), 'type' => 'textarea']) ?>
	</fieldset>
	<?= $this->Form->button('<i class="fa fa-check" aria-hidden="true"></i> ' . __('Submit'), ['class' => 'btn btn-primary', 'type' => 'submit', 'espace' => false]) ?>
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

function setCategory(did, cid) {
	category_filter_reset();

	$('#debit-id').val(did);
	$('#credit-id').val(cid);
}
<?php $this->Html->scriptEnd(); ?>

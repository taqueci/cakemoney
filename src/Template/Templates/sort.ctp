<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;

$css = <<<CSS
<style>
.list-group-no-radius .list-group-item:first-child {
  border-top-right-radius: 0px;
  border-top-left-radius: 0px;
}

.list-group-no-radius .list-group-item:last-child {
  border-bottom-right-radius: 0px;
  border-bottom-left-radius: 0px;
}
</style>
CSS;
$this->append('css', $css);
?>
<div class="row">
  <div class="col-md-9 has-margin-bottom">
  	<?= $this->Form->create(null, ['id' => 'form']) ?>
	<?= $this->Form->hidden('position', ['id' => 'position']) ?>
	<fieldset>
	  <legend><?= __('Sort Templates') ?></legend>
	  <div class="list-group list-group-no-radius sortable">
		<?php foreach ($templates as $x): ?>
		<a id="<?= $x->id ?>" class="list-group-item">
		  <i class="fas fa-arrows-v" aria-hidden="true"></i>
		  &nbsp;
		  <?= $x->name ?>
		</a>
		<?php endforeach; ?>
	  </div>
	</fieldset>
	<?= $this->Form->button('<i class="fas fa-check" aria-hidden="true"></i> ' . __('Submit'), ['class' => 'btn btn-primary', 'type' => 'submit', 'espace' => false]) ?>
	<?= $this->Form->end() ?>
  </div>
  <div class="col-md-3">
	<div class="list-group">
	  <?= $this->Html->link('<i class="fas fa-list" aria-hidden="true"></i> ' . __('List Templates'), ['action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
  </div>
</div>

<?= $this->fetch('postLink') ?>

<?php
$this->prepend('script', $this->Html->script([Configure::read('Js.jqueryui')]));

$this->Html->scriptStart(['block' => true]);
?>
$(function() {
	$('.sortable').sortable({
		axis: 'y',
		cursor: 'move',
		opacity: 0.7
	});

	$('#form').submit(function() {
		var data = [];
		$('.sortable a').each(function() {
			data.push($(this).attr('id'));
		});
		$('#position').val(data.join(','));
	});
});

<?php
$this->Html->scriptEnd();

<?php
/**
  * @var \App\View\AppView $this
  */

use Cake\Core\Configure;
?>
<div class="row">
  <div class="col-md-12">
	<h2><?= __('Dashboard') ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="visible-xs">
	  <div class="row">
		<div class="col-md-12">
		  <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add'], ['class' => 'btn btn-default', 'escape' => false]) ?>
		  <?= $this->Html->link('<i class="fa fa-bar-chart" aria-hidden="true"></i> ' . __('Report'), ['controller' => 'reports', 'action' => 'view'], ['class' => 'btn btn-default', 'escape' => false]) ?>
		  <a href="#q" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Search') ?></a>
		</div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-6">
		<h3><?= __('Summary') ?></h3>
		<table>
		  <tr>
			<td align="center"><small><span class="label label-default"><?= __('Incomings') ?></span></small></td>
			<td>&emsp;&emsp;</td>
			<td align="center"><small><span class="label label-default"><?= __('Outgoings') ?></span></small></td>
			<td>&emsp;&emsp;</td>
			<td align="center"><small><span class="label label-default"><?= __('Balance') ?></span></small></td>
		  </tr>
		  <tr>
			<td align="center"><span class="font-large"><?= number_format($sum->income) ?></span></td>
			<td align="center"><tt>-</tt></td>
			<td align="center"><span class="font-large"><?= number_format($sum->expense) ?></span></td>
			<td align="center"><tt>=</tt></td>
			<td align="center"><span class="font-xlarge"><?= $this->element('Format/numberWithStatus', ['value' => $sum->income - $sum->expense]) ?></span></td>
		  </tr>
		</table>
		<h3><?= __('Outgoings') ?></h3>
		<div id="outgoings-chart">
		  <canvas id="outgoings-canvas" width="400" height="400"></canvas>
		</div>
	  </div>
	  <div class="col-md-6">
		<h3><?= __('Recent Journals') ?></h3>
		<ul class="list-group">
		  <?php foreach ($journals as $x): ?>
		  <li class="list-group-item">
			<span class="badge"><?= number_format($x->amount) ?></span>
			<h4 class="list-group-item-heading"><?= h($x->date) ?></h4>
			<p><?= h($x->summary) ?></p>
			<p><?= h($x->debit->name) . ' / ' . h($x->credit->name) ?>
			  <span class="xs-icon" style="float: right">
				<?= $this->Html->link('<i class="fa fa-list-alt" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'view', $x->id], ['escape' => false]) ?>
				&nbsp;
				<?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['controller' => 'journals', 'action' => 'edit', $x->id], ['escape' => false]) ?>
			  </span>
			</p>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  </div>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
		<?= $this->Html->link('<i class="fa fa-bar-chart" aria-hidden="true"></i> ' . __('View Report'), ['controller' => 'reports', 'action' => 'view'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
	<div class="list-group">
	  <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('List Journals'), ['controller' => 'journals', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
		<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('New Journal'), ['controller' => 'journals', 'action' => 'add'], ['class' => 'list-group-item', 'escape' => false]) ?>
		<?= $this->Html->link('<i class="fa fa-list-ol" aria-hidden="true"></i> ' . __('List Reports'), ['controller' => 'reports', 'action' => 'index'], ['class' => 'list-group-item', 'escape' => false]) ?>
	</div>
    <?= $this->Form->create(null, ['url' => ['controller' => 'journals', 'action' => 'index']]) ?>
	<fieldset>
	  <?= $this->Form->input('q', ['label' => false, 'placeholder' => __('Search'), 'append' => '<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>']) ?>
	</fieldset>
	<?= $this->Form->end() ?>
  </div>	
</div>

<?= $this->fetch('postLink') ?>

<?php $this->prepend('script', $this->Html->script([Configure::read('Js.chartjs')])) ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
<?= $this->element('Chart/doughnut', ['id' => 'outgoings-canvas', 'data' => $expense]) ?>
<?php $this->Html->scriptEnd(); ?>

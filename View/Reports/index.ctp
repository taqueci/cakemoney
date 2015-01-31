<div class="row">
  <div class="col-md-12">
	<h2><?php echo __('Reports'); ?></h2>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
	<div class="hidden-xs">
	  <table class="table table-striped">
		<thead>
		  <tr>
			<th><?php echo $this->Paginator->sort('term', __('Term')); ?></th>
			<th><?php echo $this->Paginator->sort('income', __('Income')); ?></th>
			<th><?php echo $this->Paginator->sort('expense', __('Expense')); ?></th>
			<th><?php echo $this->Paginator->sort('balance', __('Blance')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php foreach ($reports as $r): ?>
		  <tr>
			<td><?php echo h($r['Journal']['term']); ?></td>
			<td align="right"><?php echo number_format($r['Journal']['income_sum']); ?></td>
			<td align="right"><?php echo number_format($r['Journal']['expense_sum']); ?></td>
			<td align="right"><?php echo number_format($r['Journal']['balance']); ?></td>
			<td class="actions">
			  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'stats')), array('action' => 'view', $format, $r['Journal']['term']), array('escape' => false)); ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
		</tbody>
	  </table>
	</div>
	<div class="visible-xs">
	  <ul class="list-group">
		<?php foreach ($reports as $r): ?>
		<li class="list-group-item">
		  <span class="badge"><?php echo number_format($r['Journal']['balance']); ?></span>
		  <h4 class="list-group-item-heading"><?php echo h($r['Journal']['term']); ?></h4>
		  <p>
			<?php echo __('Incomes'); ?>
			<small><?php echo number_format($r['Journal']['income_sum']); ?></small> -
			<?php echo __('Expenses'); ?>
			<small><?php echo number_format($r['Journal']['expense_sum']); ?></small>
			<span style="float: right">
			  <?php echo $this->Html->link($this->element('glyphicon', array('name' => 'stats')), array('action' => 'view', $format, $r['Journal']['term']), array('escape' => false)); ?>
			</span>
		  </p>
		</li>
		<?php endforeach; ?>
	  </ul>
	</div>
  </div>
  <div class="col-md-3">
	<div class="list-group">
		<?php echo $this->Html->link($this->element('glyphicon', array('name' => 'dashboard')) . ' ' . __('Overall Report'), array('action' => 'view'), array('class' => 'list-group-item', 'escape' => false)); ?>
		<?php echo $this->Html->link($this->element('glyphicon', array('name' => 'zoom-in')) . ' ' . __('Monthly Report'), array('_Y-_m'), array('class' => 'list-group-item', 'escape' => false)); ?>
		<?php echo $this->Html->link($this->element('glyphicon', array('name' => 'zoom-out')) . ' ' . __('Annual Report'), array('_Y'), array('class' => 'list-group-item', 'escape' => false)); ?>
	</div>
  </div>

</div>

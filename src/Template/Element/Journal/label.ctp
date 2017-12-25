<?php if ($debit == ACCOUNT_EXPENSE): ?>
<span class="label label-danger"><?= __('Outgoing') ?></span>
<?php elseif ($credit == ACCOUNT_INCOME): ?>
<span class="label label-success"><?= __('Incoming') ?></span>
<?php elseif ($debit == ACCOUNT_LIABILITY): ?>
<span class="label label-warning"><?= __('Repayment') ?></span>
<?php endif ?>

<?php
App::uses('Component', 'Controller');

class AccountComponent extends Component {
	public function name($id) {
		$names = $this->names();

		return $names[$id];
	}

	public function names() {
		return array(
			ACCOUNT_ASSET     => __('Asset'),
			ACCOUNT_LIABILITY => __('Liability'),
			ACCOUNT_INCOME    => __('Income'),
			ACCOUNT_EXPENSE   => __('Expense'),
			ACCOUNT_EQUITY    => __('Equity')
		);
	}
}

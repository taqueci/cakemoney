<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Account component
 */
class AccountComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

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

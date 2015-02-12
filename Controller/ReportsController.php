<?php
App::uses('AppController', 'Controller');
/**
 * Reports Controller
 *
 * @property Report $Report
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ReportsController extends AppController {
	public $uses = array('Journal', 'Category');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Search.Prg');
	public $presetVars = true;

/**
 * index method
 *
 * @return void
 */
	public function index($format = '_Y-_m') {
		$f = str_replace('_', '%', $format);

		$this->Journal->recursive = 0;
		$this->Journal->order = 'Journal.date DESC';

		$this->Journal->virtualFields['term'] = "DATE_FORMAT(date, '$f')";
		$this->Journal->virtualFields['income_sum'] = 'SUM(income)';
		$this->Journal->virtualFields['expense_sum'] = 'SUM(expense)';
		$this->Journal->virtualFields['balance'] = 'SUM(income)-SUM(expense)';

		$this->Prg->commonProcess();
		$this->paginate = array(
			'fields' => array(
				"DATE_FORMAT(date, '$f') AS Journal__term",
				'SUM(income) AS Journal__income_sum',
				'SUM(expense) AS Journal__expense_sum',
				'SUM(income) - SUM(expense) AS Journal__balance',
			),
			'limit' => 10,
			'conditions' => $this->Journal->parseCriteria($this->passedArgs),
			'group' => array('Journal__term')
		);

		$this->set('format', $format);
		$this->set('reports', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @param string $y
 * @param string $m
 * @return void
 */
	public function view($format = 0, $date = 0) {
		$f = str_replace('_', '%', $format);

		$this->set('format', $format);
		$this->set('date', $date);

		$this->set('display', ($format === 0) ? __('Overall') : $date);
		$this->set('next', $this->date_arg($format, $date, 1));
		$this->set('prev', $this->date_arg($format, $date, -1));

		$this->set('total', $this->amount_total($f, $date));
		$this->set('data', $this->category_sum($f, $date));
	}

	private function date_arg($format, $date, $sign) {
		if ($format === 0) return null;

		$f = str_replace('_', '', $format);
		$p = ($sign > 0) ? 'next' : 'last';

		if (strstr($format, 'd')) {
			$u = 'day';
		}
		else if (strstr($format, 'm')) {
			$u = 'month';
		}
		else {
			$date .= '-01';
			$u = 'year';
		}

		return date($f, strtotime("$date $p $u"));
	}

	private function amount_total($format, $date) {
		$this->Journal->virtualFields['asset_sum'] = 0;
		$this->Journal->virtualFields['liability_sum'] = 0;
		$this->Journal->virtualFields['income_sum'] = 0;
		$this->Journal->virtualFields['expense_sum'] = 0;
		$this->Journal->virtualFields['equity_sum'] = 0;

		$options = array(
			'fields' => array(
				'SUM(asset) AS Journal__asset_sum',
				'SUM(liability) AS Journal__liability_sum',
				'SUM(income) AS Journal__income_sum',
				'SUM(expense) AS Journal__expense_sum',
				'SUM(equity) AS Journal__equity_sum'
			),
			'conditions' => array(
				"DATE_FORMAT(Journal.date, '$format')" => $date
			),
		);

		$data = $this->Journal->find('first', $options);

		return array(
			ACCOUNT_ASSET     => $data['Journal']['asset_sum'],
			ACCOUNT_LIABILITY => $data['Journal']['liability_sum'],
			ACCOUNT_INCOME    => $data['Journal']['income_sum'],
			ACCOUNT_EXPENSE   => $data['Journal']['expense_sum'],
			ACCOUNT_EQUITY    => $data['Journal']['equity_sum']
		);
	}

	private function category_sum($format, $date) {
		$this->Category->virtualFields['sum'] = 0;

		$sql = <<<END_OF_SQL
SELECT
	Category.id,
	Category.account_id,
	Category.name,
	SUM(Journal.amount) AS Category__sum

FROM (
	SELECT
		Journal.credit_id AS category_id,
		Journal.amount
	FROM journals AS Journal
	WHERE DATE_FORMAT(Journal.date, '$format') = '$date'

	UNION ALL

	SELECT
		Journal.debit_id AS category_id,
		-1 * Journal.amount
	FROM journals AS Journal
	WHERE DATE_FORMAT(Journal.date, '$format') = '$date'
) AS Journal

LEFT JOIN categories AS Category ON (Journal.category_id = Category.id) 

GROUP BY Category.id
END_OF_SQL;

		$sum = $this->Journal->query($sql);

		$data = array();

		foreach ($sum as $s) {
			$c = $s['Category'];
			$id = $c['account_id'];

			$s = (($id == ACCOUNT_ASSET) || ($id == ACCOUNT_EXPENSE)) ? -1 : 1;

			$data[$id][] = array($c['name'], $s * $c['sum']);
		}

		foreach (array(ACCOUNT_ASSET, ACCOUNT_LIABILITY, ACCOUNT_INCOME,
					   ACCOUNT_EXPENSE, ACCOUNT_EQUITY) as $x) {
			if (!isset($data[$x])) $data[$x][] = array('-', 0);
		}

		return $data;
	}
}

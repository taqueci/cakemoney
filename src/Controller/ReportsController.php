<?php
namespace App\Controller;

use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 */
class ReportsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Category');
        $this->Journals = TableRegistry::get('Journals');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $start = '1970-01-01';
        $end   = date('Y-12-31');

		$this->set('past', $this->past_sums());

		$this->set('summary', [
            'daily' => $this
                ->query_sum_group($start, $end, ['year', 'month', 'day'])
                ->order(['year' => 'DESC', 'month' => 'DESC', 'day' => 'DESC'])
                ->limit(REPORT_SUMMARY_NUM),
            'weekly' => $this
                ->query_sum_group($start, $end, ['year', 'week'])
                ->order(['year' => 'DESC', 'week' => 'DESC'])
                ->limit(REPORT_SUMMARY_NUM),
            'monthly' => $this
                ->query_sum_group($start, $end, ['year', 'month'])
                ->order(['year' => 'DESC', 'month' => 'DESC'])
                ->limit(REPORT_SUMMARY_NUM),
            'annual' => $this
                ->query_sum_group($start, $end, ['year'])
                ->order(['year' => 'DESC'])
                ->limit(REPORT_SUMMARY_NUM)
        ]);

        $this->set('back', urlencode(Router::reverse($this->request, true)));

        $this->set('_serialize', ['summary']);
    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $start = $this->param_date($this->request->getQuery('s'), date('Y-m-01'));
        $end = $this->param_date($this->request->getQuery('e'), date('Y-m-t'));

        $sum = $this->query_sum($start, $end)->first();

        $income  = $this->query_income($start, $end)->order(['sum' => 'DESC']);
        $expense = $this->query_expense($start, $end)->order(['sum' => 'DESC']);

        $this->set('page', $this->page_next_prev($start, $end));

        $this->set(compact('start', 'end'));
        $this->set(compact('sum', 'income', 'expense'));

        $this->set('chart', $this->chart_data($start, $end));

        $this->set('back', urlencode(Router::reverse($this->request, true)));

        $this->set('_serialize', ['sum', 'income', 'expense', 'balance']);
    }

    public function display()
    {
        $start = date('Y-m-01');
        $end   = date('Y-m-t');

        $sum = $this->query_sum($start, $end)->first();

        $expense = $this->query_expense($start, $end)->order(['sum' => 'DESC']);

        $journals = $this->Journals
            ->find()
            ->contain(['Debits', 'Credits'])
            ->order(['Journals.id' => 'DESC'])
            ->limit(REPORT_RECENT_NUM);

        $this->set(compact('start', 'end'));
        $this->set(compact('sum', 'expense', 'journals'));

        $this->set('account',  $this->Category->accounts());

        $this->set('back', urlencode(Router::reverse($this->request, true)));
    }

    private function past_sums()
    {
		$end = date('Y-m-d');
		$sum = [];

		foreach (['Week', 'Month', 'Year'] as $unit) {
			$start = date('Y-m-d', strtotime("$end - 1 $unit + 1 day"));

			$sum[$unit] = $this->query_sum($start, $end)->first();
			$sum[$unit]['start'] = $start;
			$sum[$unit]['end'] = $end;
		}

		return $sum;
	}

	private function query_sum($start, $end)
    {
        $q = $this->Journals->find();

        return $q
            ->select([
                'asset'     => $q->func()->sum('asset'),
                'liability' => $q->func()->sum('liability'),
                'income'    => $q->func()->sum('income'),
                'expense'   => $q->func()->sum('expense'),
                'equity'    => $q->func()->sum('equity')
            ])
            ->where(['date >=' => $start, 'date <=' => $end]);
    }

    private function query_sum_group($start, $end, $group)
    {
        return $this->query_sum($start, $end)->select($group)->group($group);
    }

    private function query_income($start, $end)
    {
        $q = $this->Journals->find();

        return $q
            ->select([
                'credit_id',
                'name' => 'Credits.name',
                'Credits.account',
                'sum' => $q->func()->sum('income')
            ])
            ->contain(['Credits'])
            ->where(['date >=' => $start, 'date <=' => $end,
            'Credits.account' => ACCOUNT_INCOME])
            ->group(['credit_id', 'name', 'Credits.account']);
    }

    private function query_income_group($start, $end, $group)
    {
        return $this
            ->query_income($start, $end)
            ->select($group)
            ->group($group);
    }

    private function query_expense($start, $end)
    {
        $q = $this->Journals->find();

        return $q
            ->select([
                'debit_id',
                'name' => 'Debits.name',
                'Debits.account',
                'sum' => $q->func()->sum('expense')
            ])
            ->contain(['Debits'])
            ->where(['date >=' => $start, 'date <=' => $end,
            'Debits.account' => ACCOUNT_EXPENSE])
            ->group(['debit_id', 'name', 'Debits.account']);
    }

    private function query_expense_group($start, $end, $group)
    {
        return $this
            ->query_expense($start, $end)
            ->select($group)
            ->group($group);
    }

    private function param_date($date, $default)
    {
        return ($date && ($date === date('Y-m-d', strtotime($date)))) ?
            $date : $default;
    }

    private function page_next_prev($start, $end)
    {
        $s = date_create($start);
        $e = date_create($end);

        $days = date_diff($s, $e)->days + 1;

        if ($days >= 365) {
            $unit = 'year';
            $num = intval($days / 365);
        }
        else if ($days >= 28) {
            $unit = 'month';
            $num = intval($days / 28);
        }
        else if ($days >= 7) {
            $unit = 'week';
            $num = intval($days / 7);
        }
        else {
            $unit = 'day';
            $num = $days;
        }

        return ($unit == 'month') ? [
            'next' => [
                'start' => $this->next_month($start, $num),
                'end'   => $this->next_month($end, $num),
            ],
            'prev' => [
                'start' => $this->prev_month($start, $num),
                'end'   => $this->prev_month($end, $num),
            ]
        ] : [
            'next' => [
                'start' => date('Y-m-d', strtotime("$start + $num $unit")),
                'end'   => date('Y-m-d', strtotime("$end   + $num $unit"))
            ],
            'prev' => [
                'start' => date('Y-m-d', strtotime("$start - $num $unit")),
                'end'   => date('Y-m-d', strtotime("$end   - $num $unit"))
            ]
        ];
    }

    private function next_month($date, $num)
    {
        if ($date === date('Y-m-t', strtotime($date))) {
            $first = date('Y-m-01', strtotime($date));

            return date("Y-m-t", strtotime("$first + $num month"));
        }
        else {
            return date('Y-m-d', strtotime("$date + $num month"));
        }
    }

    private function prev_month($date, $num)
    {
        if ($date === date('Y-m-t', strtotime($date))) {
            $first = date('Y-m-01', strtotime($date));

            return date('Y-m-t', strtotime("$first - $num month"));
        }
        else {
            return date('Y-m-d', strtotime("$date - $num month"));
        }
    }

    private function chart_data($start, $end)
    {
        $chart = [];

        $s = date_create($start);
        $e = date_create($end);

        $days = date_diff($s, $e)->days + 1;

        if ($days > 365) {
            $chart['Year']['sum'] = $this
                ->query_sum_group($start, $end, ['year'])
                ->order(['year' => 'ASC']);
            $chart['Year']['income'] = $this
                ->query_income_group($start, $end, ['year'])
                ->order(['year' => 'ASC']);
            $chart['Year']['expense'] = $this
                ->query_expense_group($start, $end, ['year'])
                ->order(['year' => 'ASC']);
        }

        if ($days > 28) {
            $chart['Month']['sum'] = $this
                ->query_sum_group($start, $end, ['year', 'month'])
                ->order(['year' => 'ASC', 'month' => 'ASC']);
            $chart['Month']['income'] = $this
                ->query_income_group($start, $end, ['year', 'month'])
                ->order(['year' => 'ASC', 'month' => 'ASC']);
            $chart['Month']['expense'] = $this
                ->query_expense_group($start, $end, ['year', 'month'])
                ->order(['year' => 'ASC', 'month' => 'ASC']);
        }

        if (($days > 7) && ($days <= 365 * 5)) {
            $chart['Week']['sum'] = $this
                ->query_sum_group($start, $end, ['year', 'week'])
                ->order(['year' => 'ASC', 'week' => 'ASC']);
            $chart['Week']['income'] = $this
                ->query_income_group($start, $end, ['year', 'week'])
                ->order(['year' => 'ASC', 'week' => 'ASC']);
            $chart['Week']['expense'] = $this
                ->query_expense_group($start, $end, ['year', 'week'])
                ->order(['year' => 'ASC', 'week' => 'ASC']);
        }

        if ($days <= 365) {
            $chart['Day']['sum'] = $this
                ->query_sum_group($start, $end, ['year', 'month', 'day'])
                ->order(['year' => 'ASC', 'month' => 'ASC', 'day' => 'ASC']);
            $chart['Day']['income'] = $this
                ->query_income_group($start, $end, ['year', 'month', 'day'])
                ->order(['year' => 'ASC', 'month' => 'ASC', 'day' => 'ASC']);
            $chart['Day']['expense'] = $this
                ->query_expense_group($start, $end, ['year', 'month', 'day'])
                ->order(['year' => 'ASC', 'month' => 'ASC', 'day' => 'ASC']);
        }

        return $chart;
    }
}

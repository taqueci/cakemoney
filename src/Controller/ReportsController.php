<?php
namespace App\Controller;

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

        $daily = $this
            ->query_sum_group($start, $end, ['year', 'month', 'day'])
            ->order(['year' => 'DESC', 'month' => 'DESC', 'day' => 'DESC'])
            ->limit(REPORT_SUMMARY_NUM);

        $weekly = $this
            ->query_sum_group($start, $end, ['year', 'week'])
            ->order(['year' => 'DESC', 'week' => 'DESC'])
            ->limit(REPORT_SUMMARY_NUM);

        $monthly = $this
            ->query_sum_group($start, $end, ['year', 'month'])
            ->order(['year' => 'DESC', 'month' => 'DESC'])
            ->limit(REPORT_SUMMARY_NUM);

        $annual = $this
            ->query_sum_group($start, $end, ['year'])
            ->order(['year' => 'DESC'])
            ->limit(REPORT_SUMMARY_NUM);

        $this->set(compact('daily', 'weekly', 'monthly', 'annual'));

        $this->set('_serialize', ['daily', 'weekly', 'monthly', 'annual']);
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
        list($start, $end) = $this->date_start_end(
            $this->request->getQuery('s'),
            $this->request->getQuery('e')
        );

        $sum = $this->query_sum($start, $end)->first();

        $income  = $this->query_income($start, $end)->order(['sum' => 'DESC']);
        $expense = $this->query_expense($start, $end)->order(['sum' => 'DESC']);

        $daily = $this
            ->query_sum_group($start, $end, ['year', 'month', 'day'])
            ->order(['year' => 'ASC', 'month' => 'ASC', 'day' => 'ASC']);

        $weekly = $this
            ->query_sum_group($start, $end, ['year', 'week'])
            ->order(['year' => 'ASC', 'week' => 'ASC']);

        $monthly = $this
            ->query_sum_group($start, $end, ['year', 'month'])
            ->order(['year' => 'ASC', 'month' => 'ASC']);

        $annual = $this
            ->query_sum_group($start, $end, ['year'])
            ->order(['year' => 'ASC']);

        $report = $this->report_next_prev($start, $end);

        $this->set(compact('start', 'end'));
        $this->set(compact('sum', 'income', 'expense'));
        $this->set(compact('daily', 'weekly', 'monthly', 'annual'));
        $this->set(compact('report'));

        $this->set('_serialize', ['sum', 'income', 'expense', 'daily', 'weekly', 'monthly', 'annual']);
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

        $this->set(compact('sum', 'expense', 'journals'));
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
        $q = $this->Journals->find();

        return $q
            ->select(array_merge([
                'asset'     => $q->func()->sum('asset'),
                'liability' => $q->func()->sum('liability'),
                'income'    => $q->func()->sum('income'),
                'expense'   => $q->func()->sum('expense'),
                'equity'    => $q->func()->sum('equity')
            ], $group))
            ->where(['date >=' => $start, 'date <=' => $end])
            ->group($group);
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

    private function date_start_end($start, $end)
    {
        return [
            (($start && ($start === date('Y-m-d', strtotime($start)))) ?
            $start : date('Y-m-01')),
            (($end && ($end === date('Y-m-d', strtotime($end)))) ?
            $end : date('Y-m-t'))
        ];
    }

    private function report_next_prev($start, $end)
    {
        $s = date_create($start);
        $e = date_create($end);

        $days = date_diff($s, $e)->days + 1;

        if ($days >= 356) {
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
}

<?php
namespace App\Controller;

use Cake\Core\Configure;
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

        $this->set('daily', $daily);
        $this->set('weekly', $weekly);
        $this->set('monthly', $monthly);
        $this->set('annual', $annual);

        $this->set('_serialize', ['daily', 'weekly', 'monthly', 'annual']);

        $this->set('css', [Configure::read('Css.bootstrapDatepicker')]);
        $this->set('js', [Configure::read('Js.bootstrapDatepicker')]);
    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        list($start, $end) = $this->date_start_end(
            $this->request->getQuery('s'),
            $this->request->getQuery('e')
        );

        $sum = $this->query_sum($start, $end)->first();

        $income  = $this->query_income($start, $end)->order(['sum' => 'DESC']);
        $expense = $this->query_expense($start, $end)->order(['sum' => 'DESC']);

        $chart_daily = $this
            ->query_sum_group($start, $end, ['year', 'month', 'day'])
            ->order(['year' => 'ASC', 'month' => 'ASC', 'day' => 'ASC']);

        $chart_monthly = $this
            ->query_sum_group($start, $end, ['year', 'month'])
            ->order(['year' => 'ASC', 'month' => 'ASC']);

        $chart_annual = $this
            ->query_sum_group($start, $end, ['year'])
            ->order(['year' => 'ASC']);

        $this->set('start', $start);
        $this->set('end', $end);

        $this->set('sum', $sum);

        $this->set('income_sum', $income);
        $this->set('expense_sum', $expense);

        $this->set('chart_daily', $chart_daily);
        $this->set('chart_monthly', $chart_monthly);
        $this->set('chart_annual', $chart_annual);

        $this->set('css', [Configure::read('Css.bootstrapDatepicker')]);
        $this->set('js', [
            Configure::read('Js.bootstrapDatepicker'),
            Configure::read('Js.chartjs')
        ]);
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

        $this->set('sum', $sum);
        $this->set('expense_sum', $expense);
        $this->set(compact('journals'));

        $this->set('js', [Configure::read('Js.chartjs')]);
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
            ->group(['credit_id']);

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
            ->group(['debit_id']);
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
}

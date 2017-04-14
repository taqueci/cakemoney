<?php
namespace App\Controller;

use Cake\Routing\Router;
use App\Controller\AppController;

/**
 * Journals Controller
 *
 * @property \App\Model\Table\JournalsTable $Journals
 */
class JournalsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Category');
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $category = $this->Category->lists();

        $s = $this->param_date($this->request->getQuery('s'));
        $e = $this->param_date($this->request->getQuery('e'));

        $d = $this->param_category($category, $this->request->getQuery('d'));
        $c = $this->param_category($category, $this->request->getQuery('c'));

        $this->paginate = [
            'order' => ['date' => 'DESC', 'created' => 'DESC'],
            'contain' => ['Debits', 'Credits']
        ];

        $q = $this->Journals->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        if ($s) $q->where(['date >=' => $s]);
        if ($e) $q->where(['date <=' => $e]);

        if ($d) $q->where(['debit_id IN' => array_keys($d)]);
        if ($c) $q->where(['credit_id IN' => array_keys($c)]);

        $options = $this->Category->options();

        $this->set('journals', $this->paginate($q));

        $this->set('debits', $options);
        $this->set('credits', $options);

        $this->set('filter', [
            'start' => $s, 'end' => $e, 'debit' => $d, 'credit' => $c
        ]);

        $this->set('back', urlencode(Router::reverse($this->request, true)));

        $this->set('_serialize', ['journals']);
    }

    /**
     * View method
     *
     * @param string|null $id Journal id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $journal = $this->Journals->get($id, [
            'contain' => ['Debits', 'Credits']
        ]);

        $this->set(compact('journal'));

        $this->set('back', $this->request->getQuery('back'));

        $this->set('_serialize', ['journal']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $journal = $this->Journals->newEntity();

        if ($this->request->is('post')) {
            $journal = $this->Journals->patchEntity($journal, $this->request->data);

            $journal->set($this->journal_data(
                $journal->amount,
                $journal->debit_id,
                $journal->credit_id
            ));

            if ($this->Journals->save($journal)) {
                $this->Flash->success(__('The journal has been saved.'));

                return $this->redirect_back();
            }
            $this->Flash->error(__('The journal could not be saved. Please, try again.'));
        }

        $options = $this->Category->options();

        $this->set(compact('journal'));

        $this->set('debits', $options);
        $this->set('credits', $options);
        $this->set('selections', $this->popular_selections());

        $this->set('_serialize', ['journal']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Journal id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $journal = $this->Journals->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $journal = $this->Journals->patchEntity($journal, $this->request->data);

            $journal->set($this->journal_data(
                $journal->amount,
                $journal->debit_id,
                $journal->credit_id
            ));

            if ($this->Journals->save($journal)) {
                $this->Flash->success(__('The journal has been saved.'));

                return $this->redirect_back();
            }
            $this->Flash->error(__('The journal could not be saved. Please, try again.'));
        }

        $options = $this->Category->options();

        $this->set(compact('journal'));

        $this->set('debits', $options);
        $this->set('credits', $options);
        $this->set('selections', $this->popular_selections());

        $this->set('_serialize', ['journal']);
    }

    /**
     * Copy method
     *
     * @param string|null $id Journal id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function copy($id = null)
    {
        $journal = $this->Journals->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $journal = $this->Journals->patchEntity($journal, $this->request->data);

            $journal->set($this->journal_data(
                $journal->amount,
                $journal->debit_id,
                $journal->credit_id
            ));

            if ($this->Journals->save($journal)) {
                $this->Flash->success(__('The journal has been saved.'));

                return $this->redirect_back();
            }
            $this->Flash->error(__('The journal could not be saved. Please, try again.'));
        }

        $base = $this->Journals->get($id);

        $options = $this->Category->options();

        $this->set('journal', $base);

        $this->set('debits', $options);
        $this->set('credits', $options);
        $this->set('selections', $this->popular_selections());

        $this->set('_serialize', ['journal']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Journal id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $journal = $this->Journals->get($id);
        if ($this->Journals->delete($journal)) {
            $this->Flash->success(__('The journal has been deleted.'));
        } else {
            $this->Flash->error(__('The journal could not be deleted. Please, try again.'));
        }

        return $this->redirect_back();
    }

    private function redirect_back()
    {
        $back = $this->request->getQuery('back');

        $url = $back ? urldecode($back) : ['action' => 'index'];

        return $this->redirect($url);
    }

    private function popular_selections()
    {
        $q = $this->Journals->find();

        return $q
            ->contain(['Debits', 'Credits'])
            ->select(['debit_id', 'Debits.name', 'credit_id', 'Credits.name',
            'count' => $q->func()->count('*')])
            ->group(['debit_id', 'Debits.name', 'credit_id', 'Credits.name'])
            ->order(['count' => 'DESC'])
            ->limit(JOURNAL_POPULAR_NUM);
    }

	private function journal_data($amount, $debit_id, $credit_id) {
		$d_id = $this->Category->account($debit_id);
		$c_id = $this->Category->account($credit_id);

        $data = array();

		$data['asset'] =
			(($d_id == ACCOUNT_ASSET) ? $amount : 0) -
			(($c_id == ACCOUNT_ASSET) ? $amount : 0);

		$data['liability'] =
			(($c_id == ACCOUNT_LIABILITY) ? $amount : 0) -
			(($d_id == ACCOUNT_LIABILITY) ? $amount : 0);

		$data['income'] =
			(($c_id == ACCOUNT_INCOME) ? $amount : 0) -
			(($d_id == ACCOUNT_INCOME) ? $amount : 0);

		$data['expense'] =
			(($d_id == ACCOUNT_EXPENSE) ? $amount : 0) -
			(($c_id == ACCOUNT_EXPENSE) ? $amount : 0);

		$data['equity'] =
			(($c_id == ACCOUNT_EQUITY) ? $amount : 0) -
			(($d_id == ACCOUNT_EQUITY) ? $amount : 0);

		return $data;
	}

    private function param_date($str)
    {
        return ($str && ($str === date('Y-m-d', strtotime($str)))) ?
            $str : null;
    }

    private function param_category($category, $ids)
    {
        if (!is_array($ids)) return [];

        $c = [];

        foreach ($ids as $id) {
            if (isset($category[$id])) {
                $c[$id] = $category[$id];
            }
        }

        return $c;
    }
}

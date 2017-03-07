<?php
namespace App\Controller;

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
        $this->loadComponent('Account');
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
        $this->paginate = [
            'order' => ['date' => 'DESC', 'created' => 'DESC'],
            'contain' => ['Debits', 'Credits']
        ];
        $journals = $this->paginate($this->Journals->find('search', [
            'search' => $this->request->query
        ]));

        $this->set(compact('journals'));

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

        $this->set('journal', $journal);
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

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The journal could not be saved. Please, try again.'));
        }

        $category = $this->find_category();

        $this->set('journal', $journal);
        $this->set('debits', $category);
        $this->set('credits', $category);

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
        $journal = $this->Journals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $journal = $this->Journals->patchEntity($journal, $this->request->data);

            $journal->set($this->journal_data(
                $journal->amount,
                $journal->debit_id,
                $journal->credit_id
            ));

            if ($this->Journals->save($journal)) {
                $this->Flash->success(__('The journal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The journal could not be saved. Please, try again.'));
        }

        $category = $this->find_category();

        $this->set('journal', $journal);
        $this->set('debits', $category);
        $this->set('credits', $category);

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

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The journal could not be saved. Please, try again.'));
        }

        $base = $this->Journals->get($id, [
            'contain' => []
        ]);

        $category = $this->find_category();

        $this->set('journal', $base);
        $this->set('debits', $category);
        $this->set('credits', $category);

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

        return $this->redirect(['action' => 'index']);
    }

    private function find_category() {
        $categories = $this->Journals->Debits
            ->find()->select(['id', 'name', 'account'])->toArray();

        $c = array();

        foreach ($categories as $x) {
            $c[$this->Account->name($x['account'])][$x['id']] = $x['name'];
        }

        return $c;
    }

    private function popular_selections()
    {
        $q = $this->Journals->find();

        return $q
            ->contain(['Debits', 'Credits'])
            ->select(['debit_id', 'Debits.name', 'credit_id', 'Credits.name',
            'count' => $q->func()->count('*')])
            ->group(['debit_id', 'credit_id'])
            ->order(['count' => 'DESC'])
            ->limit(JOURNAL_POPULAR_NUM);
    }

	private function account_id($category_id) {
        $q = $this->Journals->Debits->find();

        $a = $q->where(['Debits.id =' => $category_id])->first();

        return $a->account;
	}

	private function journal_data($amount, $debit_id, $credit_id) {
		$d_id = $this->account_id($debit_id);
		$c_id = $this->account_id($credit_id);

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
}

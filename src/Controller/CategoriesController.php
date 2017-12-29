<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
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
        $categories = $this->paginate($this->Categories->find('search', [
            'search' => $this->request->query
        ]));

        $this->set(compact('categories'));
		$this->set('account', $this->Account->names());

        $this->set('_serialize', ['categories']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
		$this->set('accounts', $this->Account->names());
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
		$this->set('accounts', $this->Account->names());
    }

    public function sort()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
			$nerr = 0;
			$n = 1;

			foreach (explode(',', $this->request->data['position']) as $p) {
				$c = $this->Categories->get($p);
				$c->set('position', $n);

				if (! $this->Categories->save($c)) $nerr++;

				$n++;
			}

			if ($nerr == 0) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

		$this->set('asset',     $this->category(ACCOUNT_ASSET));
		$this->set('liability', $this->category(ACCOUNT_LIABILITY));
		$this->set('income',    $this->category(ACCOUNT_INCOME));
		$this->set('expense',   $this->category(ACCOUNT_EXPENSE));
		$this->set('equity',    $this->category(ACCOUNT_EQUITY));
    }

	private function category($account) {
		return $this->Categories
			->find()
			->where(['account' => $account])
			->order(['position' => 'ASC']);
	}
}

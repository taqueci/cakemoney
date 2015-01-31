<?php
App::uses('AppController', 'Controller');
/**
 * Journals Controller
 *
 * @property Journal $Journal
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class JournalsController extends AppController {
	public $uses = array('Journal', 'Category');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Search.Prg', 'Account');
	public $presetVars = true;

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Journal->recursive = 0;
		$this->Journal->order = 'Journal.id desc';

		$this->Prg->commonProcess();
		$this->paginate = array(
			'limit' => 10,
			'conditions' => $this->Journal->parseCriteria($this->passedArgs)
		);

		$this->set('journals', $this->Paginator->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Journal->create();

			if ($this->Journal->save($this->journal_data())) {
				$this->Session->setFlash(__('The journal has been saved.'),
										 'alert', array(
											 'plugin' => 'BoostCake',
											 'class' => 'alert-success'
										 )
				);

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The journal could not be saved. Please, try again.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}

		$category = $this->find_category();

		$this->set('debits', $category);
		$this->set('credits', $category);

		$this->set('account', $this->Account->names());
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Journal->exists($id)) {
			throw new NotFoundException(__('Invalid journal'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Journal->save($this->journal_data())) {
				$this->Session->setFlash(__('The journal has been saved.'),
										 'alert', array(
											 'plugin' => 'BoostCake',
											 'class' => 'alert-success'
										 )
				);

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The journal could not be saved. Please, try again.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		} else {
			$options = array('conditions' => array(
				'Journal.' . $this->Journal->primaryKey => $id)
			);

			$this->request->data = $this->Journal->find('first', $options);
		}

		$category = $this->find_category();

		$this->set('debits', $category);
		$this->set('credits', $category);

		$this->set('account', $this->Account->names());
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Journal->id = $id;
		if (!$this->Journal->exists()) {
			throw new NotFoundException(__('Invalid journal'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Journal->delete()) {
			$this->Session->setFlash(__('The journal has been deleted.'),
									 'alert', array(
										 'plugin' => 'BoostCake',
										 'class' => 'alert-success'
									 )
			);
		} else {
			$this->Session->setFlash(__('The journal could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
		}

		return $this->redirect(array('action' => 'index'));
	}

	private function journal_data() {
		$data = $this->request->data;

		$amount = $data['Journal']['amount'];

		$d_id = $this->account_id($data['Journal']['debit_id']);
		$c_id = $this->account_id($data['Journal']['credit_id']);

		$data['Journal']['asset'] =
			(($d_id == ACCOUNT_ASSET) ? $amount : 0) -
			(($c_id == ACCOUNT_ASSET) ? $amount : 0);

		$data['Journal']['liability'] =
			(($c_id == ACCOUNT_LIABILITY) ? $amount : 0) -
			(($d_id == ACCOUNT_LIABILITY) ? $amount : 0);

		$data['Journal']['income'] =
			(($c_id == ACCOUNT_INCOME) ? $amount : 0) -
			(($d_id == ACCOUNT_INCOME) ? $amount : 0);

		$data['Journal']['expense'] =
			(($d_id == ACCOUNT_EXPENSE) ? $amount : 0) -
			(($c_id == ACCOUNT_EXPENSE) ? $amount : 0);

		$data['Journal']['equity'] =
			(($c_id == ACCOUNT_EQUITY) ? $amount : 0) -
			(($d_id == ACCOUNT_EQUITY) ? $amount : 0);

		return $data;
	}

	private function account_id($category_id) {
		$options = array('conditions' => array('Category.id' => $category_id));
		$category = $this->Category->find('first', $options);

		return $category['Category']['account_id'];
	}

	private function find_category() {
		$list = $this->Category->find('list', array(
			'fields' => array('id', 'name', 'account_id')
		));

		$c = array();

		foreach (array_keys($list) as $key) {
			$c[$this->Account->name($key)] = $list[$key];
		}

		return $c;
	}
}

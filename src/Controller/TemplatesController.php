<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Templates Controller
 *
 * @property \App\Model\Table\TemplatesTable $Templates
 */
class TemplatesController extends AppController
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
        $this->paginate = [
            'contain' => ['Debits', 'Credits']
        ];
        $templates = $this->paginate($this->Templates);

        $this->set(compact('templates'));
        $this->set('_serialize', ['templates']);
    }

    /**
     * View method
     *
     * @param string|null $id Template id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $template = $this->Templates->get($id, [
            'contain' => ['Debits', 'Credits']
        ]);

        $this->set('template', $template);
        $this->set('_serialize', ['template']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $template = $this->Templates->newEntity();

        if ($this->request->is('post')) {
            $template = $this->Templates->patchEntity($template, $this->request->getData());
            if ($this->Templates->save($template)) {
                $this->Flash->success(__('The template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The template could not be saved. Please, try again.'));
        }

        $options = $this->Category->options();

        $this->set('debits', $options);
        $this->set('credits', $options);

        $this->set(compact('template'));

        $this->set('_serialize', ['template']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Template id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $template = $this->Templates->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $template = $this->Templates->patchEntity($template, $this->request->getData());
            if ($this->Templates->save($template)) {
                $this->Flash->success(__('The template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The template could not be saved. Please, try again.'));
        }

        $options = $this->Category->options();

        $this->set('debits', $options);
        $this->set('credits', $options);

        $this->set(compact('template'));

        $this->set('_serialize', ['template']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Template id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $template = $this->Templates->get($id);
        if ($this->Templates->delete($template)) {
            $this->Flash->success(__('The template has been deleted.'));
        } else {
            $this->Flash->error(__('The template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

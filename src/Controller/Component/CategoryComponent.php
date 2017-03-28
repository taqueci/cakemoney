<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Category component
 */
class CategoryComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ['Account'];

    public function options()
    {
        $this->Categories = TableRegistry::get('Categories');

        $categories = $this->Categories
            ->find()->select(['id', 'name', 'account'])->toArray();

        $c = [];

        foreach ($categories as $x) {
            $c[$this->Account->name($x['account'])][$x['id']] = $x['name'];
        }

        return $c;
    }

    public function account($id)
    {
        $this->Categories = TableRegistry::get('Categories');

        return $this->Categories->get($id)->account;
    }

    public function lists()
    {
        $this->Categories = TableRegistry::get('Categories');

        return $this->Categories->find('list')->toArray();
    }
}

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Templates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Debits
 * @property \Cake\ORM\Association\BelongsTo $Credits
 *
 * @method \App\Model\Entity\Template get($primaryKey, $options = [])
 * @method \App\Model\Entity\Template newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Template[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Template|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Template patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Template[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Template findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TemplatesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('templates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Debits', [
            'className' => 'Categories',
            'foreignKey' => 'debit_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Credits', [
            'className' => 'Categories',
            'foreignKey' => 'credit_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('amount')
            ->allowEmpty('amount');

        $validator
            ->allowEmpty('summary');

        $validator
            ->allowEmpty('description');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['debit_id'], 'Debits'));
        $rules->add($rules->existsIn(['credit_id'], 'Credits'));

        return $rules;
    }
}

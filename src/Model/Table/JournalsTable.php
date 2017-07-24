<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Journals Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Debits
 * @property \Cake\ORM\Association\BelongsTo $Credits
 *
 * @method \App\Model\Entity\Journal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Journal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Journal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Journal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Journal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Journal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Journal findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JournalsTable extends Table
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

        $this->addBehavior('Search.Search');

        $this->searchManager()
             ->add('q', 'Search.Finder', ['finder' => 'keyword']);

        $this->table('journals');
        $this->displayField('id');
        $this->primaryKey('id');

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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('summary', 'create')
            ->notEmpty('summary');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('asset')
            ->requirePresence('asset', 'create')
            ->notEmpty('asset');

        $validator
            ->integer('liability')
            ->requirePresence('liability', 'create')
            ->notEmpty('liability');

        $validator
            ->integer('income')
            ->requirePresence('income', 'create')
            ->notEmpty('income');

        $validator
            ->integer('expense')
            ->requirePresence('expense', 'create')
            ->notEmpty('expense');

        $validator
            ->integer('equity')
            ->requirePresence('equity', 'create')
            ->notEmpty('equity');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['debit_id'], 'Debits'));
        $rules->add($rules->existsIn(['credit_id'], 'Credits'));

        return $rules;
    }

    public function findKeyword(Query $query, array $options)
    {
        $fields = [
            'Journals.summary',
            'Journals.description',
            'Debits.name',
            'Credits.name'
        ];

        $keywords = preg_split('/\s+/', $options['q']);

        foreach ($keywords as $k) {
            $exp = [];

            foreach ($fields as $f) {
                $exp[] = ["$f LIKE" => "%$k%"];
            }

            $query->where(['OR' => $exp]);
        }

        return $query;
    }
}

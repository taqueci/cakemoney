<?php
App::uses('AppModel', 'Model');
/**
 * Journal Model
 *
 * @property Debit $Debit
 * @property Credit $Credit
 */
class Journal extends AppModel {
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		'keyword' => array('type' => 'like',
						   'field' => array('Debit.name',
											'Credit.name',
											'Journal.description'),
						   'connectorAnd' => ' ',
						   'connectorOr' => ',')
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'money' => array(
				'rule' => array('money'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Debit' => array(
			'className' => 'Category',
			'foreignKey' => 'debit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Credit' => array(
			'className' => 'Category',
			'foreignKey' => 'credit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}

<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Account $Account
 */
class Category extends AppModel {
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		'keyword' => array('type' => 'like',
						   'field' => array('Category.name'),
						   'connectorAnd' => ' ',
						   'connectorOr' => ',')
	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'account_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Debit' => array(
			'className' => 'Journal',
			'foreignKey' => 'debit_id',
		),
		'Credit' => array(
			'className' => 'Journal',
			'foreignKey' => 'credit_id',
		)
	);

}

<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Journal Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $date
 * @property int $debit_id
 * @property int $credit_id
 * @property int $amount
 * @property string $summary
 * @property string $description
 * @property int $asset
 * @property int $liability
 * @property int $income
 * @property int $expense
 * @property int $equity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Debit $debit
 * @property \App\Model\Entity\Credit $credit
 */
class Journal extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}

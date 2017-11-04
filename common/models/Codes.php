<?php namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "codes".
 *
 * @property integer $id
 * @property string $name
 * @property double $customer_reward
 * @property integer $status
 * @property string $tariff_zone
 * @property string $start_date
 * @property string $end_date
 *
 * @property CodeHasUser[] $codeHasUsers
 */
class Codes extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'codes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start_date', 'end_date', 'customer_reward', 'tariff_zone'], 'required'],
            [['customer_reward'], 'number'],
            [['status'], 'integer'],
            [['name', 'tariff_zone'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['start_date', 'end_date'], 'validateDate', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'customer_reward' => 'Customer Reward',
            'status' => 'Status',
            'tariff_zone' => 'Tariff Zone',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    public function validateDate($attribute, $param)
    {
        $result = strtotime($this->start_date) < strtotime($this->end_date);
        if (!$result) {
            $this->addError('start_date', 'The start date must be greater than the end date');
        }
    }

    public static function statuses () {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public function getStatusString () {
        if (isset(self::statuses()[$this->status])) {
            return self::statuses()[$this->status];
        }
        return self::statuses()[self::STATUS_INACTIVE];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodeHasUsers()
    {
        return $this->hasMany(CodeHasUser::className(), ['code_id' => 'id']);
    }
}

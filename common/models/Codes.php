<?php namespace common\models;

use Carbon\Carbon;
use Faker\Provider\DateTime;
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

    public function activate ($token) {
        if ($this->isActive()) {
            if (!CodeHasUser::checkUserToken($token, $this->id)) {
                if ($this->checkDate()) {
                    $code_has_user = new CodeHasUser();
                    $code_has_user->user_token = $token;
                    $code_has_user->code_id = $this->id;
                    if ($code_has_user->save()) {
                        return ['code' => 200, 'message' => 'Code successfully activated'];
                    }
                }
                return ['code' => 500, 'message' => 'Code is not active'];
            }
            return ['code' => 500, 'message' => 'You have already activated this code'];
        }
        return ['code' => 500, 'message' => 'Code is not active'];
    }

    public function checkDate () {
        $now = strtotime(Carbon::now()->format("Y-m-d"));
        $start = strtotime($this->start_date);
        $end = strtotime($this->end_date);
        return $start < $now && $end > $now;
    }

    public function isActive () {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodeHasUsers()
    {
        return $this->hasMany(CodeHasUser::className(), ['code_id' => 'id']);
    }
}

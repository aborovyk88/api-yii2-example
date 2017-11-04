<?php namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "code_has_user".
 *
 * @property integer $id
 * @property integer $code_id
 * @property string $user_token
 *
 * @property Codes $code
 */
class CodeHasUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code_has_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_id', 'user_token'], 'required'],
            [['code_id'], 'integer'],
            [['user_token'], 'string', 'max' => 255],
            [['code_id'], 'exist', 'skipOnError' => true, 'targetClass' => Codes::className(), 'targetAttribute' => ['code_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_id' => 'Code ID',
            'user_token' => 'User Token',
        ];
    }

    public static function checkUserToken ($token) {
        $model = self::findOne(['user_token' => $token]);
        return $model instanceof self;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(Codes::className(), ['id' => 'code_id']);
    }
}

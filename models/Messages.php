<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $text
 * @property string $user
 * @property int|null $spam
 * @property string $created_at
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'user', 'created_at'], 'required'],
            [['text'], 'string'],
            [['spam'], 'integer'],
            [['created_at'], 'safe'],
            [['user'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'user' => 'User',
            'spam' => 'Spam',
            'created_at' => 'Created At',
        ];
    }
    
    public function getRole(){
        $user = \app\models\User::findOne(['username'=>$this->user]);
        return $user->role;
    }
}

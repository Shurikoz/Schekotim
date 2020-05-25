<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 25.05.2020
 * Time: 9:25
 */
namespace mdm\admin\models\form;
namespace backend\models;

use mdm\admin\models\form\Signup;
use Yii;
use mdm\admin\components\UserStatus;
use mdm\admin\models\User;
use yii\helpers\ArrayHelper;

class SignupUser extends Signup
{
    public $city;
    public $address_point;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match', 'pattern' => '/^([a-zA-Z0-9]+)$/u', 'message' => 'Разрешено вводить только латинские символы'],


            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],

            [['city', 'address_point'], 'required'],
            ['city', 'integer', 'min' => '1', 'tooSmall' => 'Город не выбран!'],

            [['city', 'address_point'], 'required'],
            ['address_point', 'integer', 'min' => '1', 'tooSmall' => 'Точка не выбрана!'],

        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
            $user = new $class();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->city = City::find()->where(['id' => $this->city])->one()->name;
            $user->address_point = AddressPoint::find()->where(['city_id' => $this->city])->one()->address_point;
            $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}
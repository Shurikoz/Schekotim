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
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $class, 'message' => 'Это имя уже занято.'],
            ['username', 'string', 'min' => 4, 'max' => 25],
            ['username', 'match', 'pattern' => '/^([a-zA-Z0-9]+)$/u', 'message' => 'Разрешено вводить только латинские символы'],

            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^([а-яА-ЯЁё\.\s]+)$/u', 'message' => 'Разрешено вводить только киррилические символы, точки и пробелы'],


            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $class, 'message' => 'Этот email уже используется другим пользователем.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],

            [['city', 'address_point'], 'required'],
            ['city', 'integer', 'min' => '1', 'tooSmall' => 'Город не выбран!'],

            [['city', 'address_point'], 'required'],
            ['address_point', 'integer', 'min' => '1', 'tooSmall' => 'Адрес не выбран!', 'message' => 'Выберите город'],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city' => 'Город',
            'address_point' => 'Адрес',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'retypePassword' => 'Повторите пароль',
            'name' => 'Имя пользователя'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
            $user = new $class();
            $user->name = $this->name;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->city_id = $this->city;
            $user->address_point_id = $this->address_point;
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
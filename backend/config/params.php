<?php
return [
    // email адреса
    'adminEmail' => 'admin@schekotim.ru',
    'supportEmail' => 'admin@schekotim.ru',
    'feedbackEmail' => 'shurikoz@narod.ru',

    // время на редактирование посещения
    'editVisitTime' => 60 * 60 * 24 * 2,

    //максимальное количество пользователей
    'maxUsers' => 10,

    //лимит количества обращений / лимит за определенное время
    'rateLimit' => 10,
    'rateTimeLimit' => 50,

    // доступ по ip: true - включен, false - отключен
    'ipAccessСondition' => false,
    // пул адресов
    'ipAddress' => [
        '127.0.0.1',
        '127.0.0.2',
        ],
];

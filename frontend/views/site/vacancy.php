<?php

use yii\helpers\Html;

$this->title = 'Вакансии';
$header = 'Вакансии';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Вакансии'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
    <h3>Мастер</h3>
    <ul>
        <li>Опыт работы от 1 года</li>
        <li>Знание строения эпидермиса и ногтевой пластины</li>
        <li>Серьёзное отношение к дезинфекции и стерилизации</li>
        <li>Владение техникой аппаратного и комбинированного маникюра и педикюра</li>
        <li>Высокая скорость выполнения процедур без потери качества работы</li>
        <li>Коммуникабельность, презентабельность, культурная речь</li>
        <li>Стремление к самосовершенствованию и отсутствие вредных привычек, как большой плюс</li>
    </ul>
    <ul>
        <li>График 3\2, 4\2, 2\2, индивидуальный в отдельных случаях</li>
        <li>Комфортные условия труда</li>
        <li>Оборудованное просторное служебное помещение</li>
        <li>Прозрачная система начисления и регулярная выплата заработной платы</li>
        <li>Гарантия выхода</li>
    </ul>
    <p>Напишите о Вашем желании работать у нас на <a href="mailto:info@schekotim.ru">info@schekotim.ru</a>.<br>
        Обязательно прикрепите к письму несколько фото с Вашими любимыми работами, и напишите пару слов о себе.
        А в теме письма укажите - <b>вакансия Мастер</b>.
    </p>
    <hr>

<?php if (false) {?>
    <hr>
    <h3>Мастер-стажёр</h3>
    <ul>
        <li>Без опыта работы</li>
        <li>Обучение на базе Центра подологии</li>
        <li>Коммуникабельность, презентабельность, культурная речь</li>
        <li>Стремление к самосовершенствованию и отсутствие вредных привычек, как большой плюс</li>
    </ul>
    <ul>
        <li>график 3\2, 4\2, 2\2, индивидуальный в отдельных случаях</li>
        <li>комфортные условия труда</li>
        <li>оборудованное просторное служебное помещение</li>
        <li>прозрачная система начисления и регулярная выплата заработной платы</li>
    </ul>
    <p>Напишите о Вашем желании работать у нас на <a href="mailto:info@schekotim.ru">info@schekotim.ru</a>.<br>
        Обязательно напишите пару слов о себе, а в теме письма укажите - <b>вакансия Мастер-стажёр</b>.
    </p>
    <h3>Администратор</h3>
    <ul>
        <li>Грамотная письменная и устная речь</li>
        <li>Клиентоориентированность</li>
        <li>Умение работать в режиме многозадачности</li>
        <li>Стрессоустойчивость</li>
        <li>Возраст от 20 до 45 лет</li>
        <li>Аналогичный опыт (клиника, салон красоты), отсутствие вредных привычек и стремление развиваться как большой плюс</li>
    </ul>
    <ul>
        <li>График 2/2/3</li>
        <li>Комфортные условия труда</li>
        <li>Оборудованное просторное служебное помещение</li>
        <li>Прозрачная система начисления и регулярная выплата заработной платы</li>
        <li>Фикс + % с продаж</li>
    </ul>
    <p>Напишите о Вашем желании работать у нас на <a href="mailto:info@schekotim.ru">info@schekotim.ru</a>.<br>
        Обязательно напишите пару слов о себе, а в теме письма укажите - <b>вакансия Администратор</b>.
    </p>
    <hr>
    <h3>Подолог</h3>
    <ul>
        <li>Опыт работы в сфере ногтевого сервиса не менее 2х лет</li>
        <li>Знание строения эпидермиса и ногтевой пластины</li>
        <li>Понимание нормы и отклонения от нормы</li>
        <li>Серьёзное отношение к дезинфекции и стерилизации</li>
        <li>Владение техникой аппаратного и комбинированного маникюра и педикюра</li>
        <li>Коммуникабельность, презентабельность, культурная речь</li>
        <li>Стремление к самосовершенствованию и отсутствие вредных привычек, как большой плюс</li>
    </ul>
    <ul>
        <li>График 3\2, 4\2, 2\2, индивидуальный в отдельных случаях</li>
        <li>Наставничество и поддержка в обучении Главным подологом Центра</li>
        <li>Комфортные условия труда</li>
        <li>Оборудованное просторное служебное помещение</li>
        <li>Прозрачная система начисления и регулярная выплата заработной платы</li>
    </ul>
    <p>Напишите о Вашем желании работать у нас на <a href="mailto:info@schekotim.ru">info@schekotim.ru</a>.<br>
        Обязательно прикрепите к письму несколько фото с Вашими любимыми работами, и напишите пару слов о себе. А в теме письма укажите - <b>вакансия Подолог</b>.
    </p>
    <hr>
    <h3>Администратор</h3>
    <ul>
        <li>Грамотная письменная и устная речь</li>
        <li>Клиентоориентированность</li>
        <li>Умение работать в режиме многозадачности</li>
        <li>Стрессоустойчивость</li>
        <li>Возраст от 20 до 45 лет</li>
        <li>Аналогичный опыт (клиника, салон красоты), отсутствие вредных привычек и стремление развиваться как большой плюс</li>
    </ul>
    <ul>
        <li>График 2/2/3</li>
        <li>Комфортные условия труда</li>
        <li>Оборудованное просторное служебное помещение</li>
        <li>Прозрачная система начисления и регулярная выплата заработной платы</li>
        <li>Фикс + % с продаж</li>
    </ul>
    <p>Напишите о Вашем желании работать у нас на <a href="mailto:info@schekotim.ru">info@schekotim.ru</a>.<br>
        Обязательно напишите пару слов о себе, а в теме письма укажите - <b>вакансия Администратор</b>.
    </p>
<?php } ?>
</section>

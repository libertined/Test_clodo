<?php 
$configRoot = $_SERVER["DOCUMENT_ROOT"].'/system';
require_once($configRoot.'/users.php');
$users = new Users();
$arResult["USERS"] = $users->getList();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Тестовое задание Аникеевой Дианы</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="css/normalize.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    </head>
    <body>
        <div class="layoutCenterWrapper">
            <nav class="menu-top">
                <ul class="menu-top__list clearfix">
                    <li class="menu-top__item menu-top__item--active"><a href="">Список пользователей</a></li>
                </ul>
            </nav>
            <div class="main-part clearfix">
                <div class="filter col-xs-3">
                    <form class="filter__form" name="filter-form" action="/ajax/filter_result.php" method="post" id="filter_form">
                        <div class="filter__item">
                            <p class="filter__item-title">ФИО</p>
                            <input class="filter__text-field" type="text" placeholder="Введите ФИО" value="" name="fio"/>
                        </div>
                        <div class="filter__item">
                            <label class="filter__item-title"><input class="filter__checkbox" type="checkbox" value="1" name="phone"/>
                                Наличие телефона</label>
                        </div>
                        <div class="filter__item">
                            <p class="filter__item-title">Баланс</p>
                            <label class="filter__item-title filter__item-title--left">
                                <input class="filter__radio" type="radio" value="more" name="balance_marg" checked/>
                                <span>&lt;</span>
                            </label>
                            <input class="filter__text-field filter__text-field--small" type="text" placeholder="Введите Баланс" value=""
                                   name="balance"/>
                            <label class="filter__item-title filter__item-title--right">
                                <span>&gt;</span>
                                <input class="filter__radio" type="radio" value="less" name="balance_marg"/>
                            </label>
                        </div>
                        <div class="filter__item">
                            <p class="filter__item-title">Зарегистрирован в период</p>
                            <label class="filter__item-title"><span>С</span> <input class="filter__text-field filter__text-field--double datepicker" type="text" placeholder="Дата" value="" name="date_from"/></label>
                            <label class="filter__item-title filter__item-title--right"><span>По</span> <input class="filter__text-field filter__text-field--double datepicker" type="text" placeholder="Дата" value="" name="date_to"/></label>
                        </div>
                        <div class="filter__item">
                            <p class="filter__item-title">Средний платеж (за весь период) </p>
                            <label class="filter__item-title"><span>От</span> <input class="filter__text-field filter__text-field--double" type="text" placeholder="Сумма" value="" name="payment_from"/></label>
                            <label class="filter__item-title filter__item-title--right"><span>До</span> <input class="filter__text-field filter__text-field--double" type="text" placeholder="Сумма" value="" name="payment_to"/></label>
                        </div>
                        <input class="filter__send" type="submit" value="Применить" name="filter-send">
                    </form>
                </div>
                <div class="content col-xs-9">
                    <h1 class="main-title">Пользователи</h1>
                    <table class="users-table" width="100%">
                        <tr class="users-table__head">
                            <th>ФИО</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Баланс</th>
                        </tr>
                        <?
                        /*Выводим результаты*/
                        foreach ($arResult["USERS"] as $key => $itemUser) {
                            ?>
                            <tr class="users-table__row" data-user="<?=$itemUser["id"]?>">
                                <td class="users-table__fio"><?=$itemUser["NAME"]?></td>
                                <td class="users-table__email"><?=$itemUser["EMAIL"]?></td>
                                <td class="users-table__phone"><?if($itemUser["PHONE"] != ""):?>
                                        <?=$itemUser["PHONE"]?>
                                    <?else:?>
                                        <button class="js-btn-email" name="send_email">Послать сообщение</button>
                                    <?endif;?>
                                </td>
                                <td class="users-table__balance"><?=$itemUser["BALANCE"]?></td>
                            </tr>
                        <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div id="js-modal" class="modal"><!-- Само окно -->
            <span class="modal__close">X</span> <!-- Кнопка закрыть -->
            <form action="/ajax/sendEmail.php" class="modal__form" method="post">
                <input type="hidden" name="email" value="0" class="js-email"/>
                <p class="modal__msg modal__msg--error js-msg"></p>
                <p class="modal__text">Введите текст сообщения, которое вы хотите отправить Пользователю <span class="js-fio">Имя</span></p>
                <textarea class="modal__text-field js-comment" name="comment"></textarea>
                <button type="submit" name="send" value="send">Отправить</button>
            </form>
        </div>
        <div id="overlay" class="overlay"></div><!-- Подложка -->
        <script type="text/javascript" src="/js/script.js"></script>
    </body>
</html>
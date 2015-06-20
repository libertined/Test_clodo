<?php 
    $configRoot = $_SERVER["DOCUMENT_ROOT"].'/system';    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Тестовое задание Аникеевой Дианы</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="css/normalize.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
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
                        <tr class="users-table__row" data-user="0">
                            <td>Иванов Иван</td>
                            <td>test@yandex.ru</td>
                            <td><button name="send_email">Послать сообщение</button></td>
                            <td>100,53</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </body>
</html>
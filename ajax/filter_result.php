<?php
$configRoot = $_SERVER["DOCUMENT_ROOT"].'/system';
require_once($configRoot.'/users.php');
$users = new Users();
$arResult["USERS"] = $users->getFilteredlist($_REQUEST);
?>
<h1 class="main-title">Пользователи</h1>
<?if(empty($arResult["USERS"])):?>
    <p>Заданным условиям поиска не соответствует ни один пользователь. Пожалуйста, измените параметры фильтрации.</p>
<?else:?>
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
<?endif;?>

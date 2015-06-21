<?php
$dataFiles = array("error" => "", "text" => "");
if(empty($_REQUEST["email"])){
    $dataFiles["error"] = "Внутренняя оибка, не задан EMAIL пользователя, обратитесь, пожалуйста к администратору";
}
elseif(empty($_REQUEST["comment"]))
    $dataFiles["error"] = "Введите, пожалуйста, сообщение";
else{
    if(mail($_REQUEST["email"], "Сообщение с сата Clodo", $_REQUEST["comment"])){
        $dataFiles["text"] = "Сообщение успешно отправллено";
    }
    else
        $dataFiles["error"] = "Не удалось отправить сообщение, попробуйте еще раз";
}
echo json_encode($dataFiles);
?>
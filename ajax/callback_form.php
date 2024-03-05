<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');


use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Server,
    Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$values = $request->getPostList();

//получаем данные формы и раскидываем по переменным
$user_fio = $request->get("USER_FIO");
$user_phone = $request->get("USER_PHONE");
$user_email = $request->get("USER_EMAIL");
$user_question = $request->get("USER_QUESTION");

if (isset($user_fio) && (isset($user_phone) || isset($user_email))) {
    Loader::includeModule("highloadblock");
    $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_ORDER_FORM)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $data = array(
        "UF_USER_FIO" => $user_fio,
        "UF_USER_PHONE" => $user_phone,
        "UF_USER_EMAIL" => $user_email,
        "UF_USER_QUESTION" => $user_question,
    );

    //добавляем запись в hl блок
    $result = $entity_data_class::add($data);

    if ($result->isSuccess()) {
        //если успех
        echo json_encode([
            'success' => true,
            'msg' => "Ваша заявка успешно принята! Наш менеджер свяжется с Вами в ближайшее время."
        ]);
        unset($hlblock, $entity, $entity_data_class, $data);

        //отправляем почтовый шаблон
        \Bitrix\Main\Mail\Event::send(array(
            "EVENT_NAME" => "CALLBACK_FORM",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL" => ADMIN_EMAIL,
                "USER_FIO" => $user_fio,
                "USER_PHONE" => $user_phone,
                "USER_EMAIL" => $user_email,
                "USER_QUESTION" => $user_question,
            ),
        ));

    } else {
        echo json_encode([
            'success' => false,
            'msg' => "Ошибка отправки заявки, попробуйте в другое время!"
        ]);
    }
} else {
    echo false;
}
<?
// при изменений пароля
AddEventHandler("main", "OnAfterUserUpdate", Array("SendPassword", "onBeforeUserChangePassword"));
class PasswordUpdater 
{
    function onBeforeUserChangePassword($arParams)
    {
        $res_dump = print_r ($arParams, 1);
        // TODO
    }
}

// закрыть сайт для всех кроме определенных групп пользователей
AddEventHandler("main", "OnProlog", "CloseAccessForGroup");
function CloseAccessForGroup()
{
    global $USER, $APPLICATION;
    $mas = $USER->GetUserGroupArray();
    $id = $USER->GetID();
    if(($id != 1 && $id != 2) && $APPLICATION->GetCurPage(false) != '/bitrix/admin/') {
        require($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/s1/site_closed.php");
        die;
    }
}

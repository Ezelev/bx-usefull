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

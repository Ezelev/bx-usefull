<?php
IncludeModuleLangFile(__FILE__);

Class Lingua_params extends CModule
{
    var $MODULE_ID = "your.module";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;

    function __construct ()
    {
        include("version.php");
        $this->MODULE_VERSION      = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->PARTNER_NAME        = GetMessage("PARTNER_NAME");
        $this->PARTNER_URI         = GetMessage("PARTNER_URI");
        $this->MODULE_NAME         = GetMessage("MODULE_NAME_NEW");
        $this->MODULE_DESCRIPTION  = GetMessage("MODULE_DESC");

    }

    function DoInstall ()
    {
        $this->installRule();
        RegisterModule($this->MODULE_ID);
        echo CAdminMessage::ShowNote("Модуль установлен");
    }

    public function installRule ()
    {
        if ( ! CUrlRewriter::GetList(array("ID" => "local:" . $this->MODULE_ID))) {

            //проверка
            CUrlRewriter::Add(array(
                "CONDITION" => "#^/bitrix/admin/params.php#",
                "PATH"      => '/local/modules/' . $this->MODULE_ID . '/admin/params.php',
                "ID"        => 'local:' . $this->MODULE_ID,
            ));
        }
    }

    function DoUninstall ()
    {
        $this->uninstallRule();
        UnRegisterModule($this->MODULE_ID);
        echo CAdminMessage::ShowNote("Модуль успешно удален из системы");
    }

    public function uninstallRule ()
    {
        if (CUrlRewriter::GetList(array("ID" => "local:" . $this->MODULE_ID))) {
            CUrlRewriter::Delete(array(
                "ID" => 'local:' . $this->MODULE_ID,
            ));
        }
    }

}

?>
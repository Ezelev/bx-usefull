<?php
$aTabs = array(
    array(
        'DIV' => 'your_class',
        'TAB' => "Настройки",
        'OPTIONS' => array(
            array('PARAM_1_NAME',
            'Parameter name',
                null,
                array('text', 52), // parameter type 
            ),
        )
    )
);



if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_REQUEST['save']) > 0 && check_bitrix_sessid())
{
    foreach ($aTabs as $aTab)
    {
        __AdmSettingsSaveOptions("your.module", $aTab['OPTIONS']);
    }

    LocalRedirect($APPLICATION->GetCurPage() . '?lang=' . LANGUAGE_ID . '&mid_menu=1&mid=' . urlencode("lingua.params") .
        '&tabControl_active_tab=' . urlencode($_REQUEST['tabControl_active_tab']) . '&sid=' . urlencode("e1"));
}
?>
<?
$tabControl = new CAdminTabControl('tabControl', $aTabs);
?>
    <form method='post' action='' name='bootstrap'>
        <? $tabControl->Begin();

        foreach ($aTabs as $aTab)
        {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList("lingua.params", $aTab['OPTIONS']);
        }

        $tabControl->Buttons(array('btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false)); ?>

        <?= bitrix_sessid_post(); ?>
        <? $tabControl->End(); ?>
    </form>
<?
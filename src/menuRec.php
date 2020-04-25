/* TODO recursive bitrix tree menu */
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?>

<?

CModule::IncludeModule("iblock");
$iblockId = "xxx";

$arFilter = Array('IBLOCK_ID'=>$iblockId);
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
while($arSect = $db_list->GetNext())
{
    // echo $arSect['ID'].' '.$arSect['NAME'].': '.$arSect['ELEMENT_CNT'].'<br>';
}

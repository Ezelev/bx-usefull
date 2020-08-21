<?php

/**
 * HelperBX class
 */
class HelperBX {
    

    /**
     * getSectionSeoProperties
     * Возвращает SEO-теги раздела по id ифноблока и id раздела
     * 
     * @param  mixed $iblockId
     * @param  mixed $sectionId
     *
     * @return void
     */
    public static function getSectionSeoProperties($iblockId, $sectionId){
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($iblockId,$sectionId);
        $seoProps  = $ipropValues->getValues();
        return $seoProps;
    }

    /**
     * setSectionSeoProperties
     * Устанавливает SEO-теги раздела по id ифноблока и id раздела
     * 
     * @param  mixed $iblockId
     * @param  mixed $sectionId
     *
     * @return void
     */
    public static function setSectionSeoProperties($iblockId, $sectionId){
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($iblockId, $sectionId);
        $seoProps  = $ipropValues->getValues();

        if ($IPROPERTY['SECTION_META_TITLE']) {
            $APPLICATION->SetPageProperty("title", $seoProps['SECTION_META_TITLE']);
            $APPLICATION->SetTitle($seoProps['SECTION_META_TITLE']);
        }

        if ($seoProps['SECTION_META_KEYWORDS']) {
            $APPLICATION->SetPageProperty("keywords", $seoProps['SECTION_META_KEYWORDS']);
        }
        if ($IPROPERTY['SECTION_META_DESCRIPTION']) {
            $APPLICATION->SetPageProperty("description", $seoProps['SECTION_META_DESCRIPTION']);
        }
    }
    
    public static function getELementsByDate() {
        $i = 1; // за сколько дней вывести данные

        $s1 = strtotime("-$i day");
        $s2 = strtotime("today");

        echo("от " . date('d.m.Y', $s1)."\n");
        echo("до " . date('d.m.Y  H:i:s', $s2)."\n");

        $filter = array(
            //"ID"=> 22515,
           ">UF_PASS_CHANGE_DATE" => date('d.m.Y', $s1),
           "ACTIVE" => 'Y',
        );

        $elementsResult = CUser::GetList(($by="ID"), ($order="ASC"), $filter,array("SELECT"=>array(
            "UF_PASS_REAL", 
            "UF_PASS_CHANGE_DATE")
            ));
        while ($rsUser = $elementsResult->Fetch()) 
        {
            echo $rsUser["ID"] . " - " . $rsUser["LOGIN"] . " - " . $rsUser["UF_PASS_CHANGE_DATE"] . "\n";
        }
    }
    
    function getIBlockIdByCode($sIBlockCode, $bRefreshCache = false)
{

	$arIblocks = array();

	if (array_key_exists($sIBlockCode, $arIblocks)) {
		return $arIblocks[$sIBlockCode];
	}


	$obCache = new CPHPCache;
	$iReturnId = 0;
	$CACHE_ID = 'getIBlockIdByCode' . $sIBlockCode . '_______';
	$iCacheTime = 10800; //3 часа

	if ($obCache->StartDataCache($iCacheTime, $CACHE_ID)):

		if (CModule::IncludeModule('iblock')) {
			$arFilter = array(
				'CODE' => $sIBlockCode,
				'ACTIVE' => 'Y',
				'CHECK_PERMISSIONS' => 'N'
			);
			$dbItems = CIBlock::GetList(array('ID' => 'ASC'), $arFilter, false);
			if ($arItem = $dbItems->Fetch()) {
				$iReturnId = intval($arItem['ID']);
			}
		}

		$obCache->EndDataCache($iReturnId);
	else:
		$iReturnId = $obCache->GetVars();
	endif;
	unset($obCache);
	return $iReturnId;
}
	
	function getElementFilledProps() {
		CModule::IncludeModule("iblock");
		$IBLOCK_ID = "some id";
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM");
		$arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
		while($ob = $res->GetNextElement())
		{ 
		$arProps = $ob->GetProperties();
		foreach($arProps as $key=>$value) {
			if(empty($value["VALUE"])) {
					unset($arProps[$key]);
				}
			}
		}

		return $arProps;
	}
	public static function getPayerEmailFromOrders(){
		CModule::IncludeModule("sale");
		$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"));
		$payerEmails = [];
		while ($arSales = $rsSales->Fetch())
		{
			$res = CSaleOrderPropsValue::GetOrderProps($arSales["ID"]);
			while ($row = $res->fetch()) {
				if ($row['IS_EMAIL']=='Y' && check_email($row['VALUE'])) {
					$payerEmails[] = $row['VALUE'];
				}
			}
		}

		return $payerEmails;
	}
?>

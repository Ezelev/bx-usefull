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
}

?>

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
}

?>

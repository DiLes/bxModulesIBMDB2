<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 300;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"])<=0)
	$arParams["IBLOCK_TYPE"] = "news";
if($arParams["IBLOCK_TYPE"]=="-")
	$arParams["IBLOCK_TYPE"] = "";

if(!is_array($arParams["IBLOCKS"]))
	$arParams["IBLOCKS"] = array($arParams["IBLOCKS"]);
foreach($arParams["IBLOCKS"] as $k=>$v)
	if(!$v)
		unset($arParams["IBLOCKS"][$k]);

if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = array();
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);

$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if(strlen($arParams["SORT_BY1"])<=0)
	$arParams["SORT_BY1"] = "ACTIVE_FROM";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
	$arParams["SORT_ORDER1"]="DESC";

if(strlen($arParams["SORT_BY2"])<=0)
	$arParams["SORT_BY2"] = "SORT";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"]))
	$arParams["SORT_ORDER2"]="ASC";

$arParams["NEWS_COUNT"] = intval($arParams["NEWS_COUNT"]);
if($arParams["NEWS_COUNT"]<=0)
	$arParams["NEWS_COUNT"] = 20;

$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

$arParams["ACTIVE_DATE_FORMAT"] = trim($arParams["ACTIVE_DATE_FORMAT"]);
if(strlen($arParams["ACTIVE_DATE_FORMAT"])<=0)
	$arParams["ACTIVE_DATE_FORMAT"] = $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));

if($this->startResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
    // Добавляем свойству для файла
    $forFileProperty = "PROPERTY_FILE"/* . $arParams["PROPERTY_FOR_FILE"]*/;
    $fileFor = array($forFileProperty);
	$arSelect = array_merge($arParams["FIELD_CODE"], array(
		"ID",
		"IBLOCK_ID",
		"ACTIVE_FROM",
		"DETAIL_PAGE_URL",
		"NAME",
	));
	$arFilter = array (
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"=> $arParams["IBLOCKS"],
		"ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
	);
	$arOrder = array(
		$arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
		$arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
	);
	if(!array_key_exists("ID", $arOrder))
		$arOrder["ID"] = "DESC";
	$arResult=array(
		"ITEMS"=>array(),
	);
	$rsItems = CIBlockElement::GetList($arOrder, $arFilter, false, array("nTopCount"=>$arParams["NEWS_COUNT"]), $arSelect);
	$rsItems->SetUrlTemplates($arParams["DETAIL_URL"]);
	while($arItem = $rsItems->GetNext())
	{

        // Показать отдел
        if ($arParams['SHOW_DEPARTMENT'] == "Y"){
            $arItem['DEPS'] = $arItem['PROPERTY_DEPARTMENT_VALUE'];
        }
        // PROPERTY_CODE_VALUE
        $fulNF = $forFileProperty . "_VALUE";
        // Берем файла
        if (isset($arItem[$fulNF])){
            $file = CFile::GetFileArray($arItem[$fulNF]);
            $arItem['FILE']['SRC'] = $file['SRC'];

            // Показать размер файла
            if ($arParams['SHOW_FILE_SIZE'] == "Y") {
                if ($file['FILE_SIZE'] > 1024){
                    $fileSize = round($file['FILE_SIZE'] / 1024) . " KB";
                } elseif ($file['FILE_SIZE'] > 1024 * 1024){
                    $fileSize = round($file['FILE_SIZE'] / (1024 * 1024)) . " MB";
                } else {
                    $fileSize = $file['FILE_SIZE'] . " B";
                }
                $arItem['FILE']['SIZE'] = $fileSize;
            }

            // Показать тип файла
            if ($arParams['SHOW_FILE_TYPE'] == "Y") {
                $fileTempName = explode('.', $file['ORIGINAL_NAME']);
                $fileTempCount = count($fileTempName);
                $arItem['FILE']['TYPE'] = $fileTempName[$fileTempCount - 1];
            }

            // Показать дату обновления
            if ($arParams['SHOW_FILE_UPDATE'] == "Y") {
                $fileDate = explode(" ", $file['TIMESTAMP_X']);
                $arItem['FILE']['UPDATED'] = $fileDate[0];
            }
        }

		$arButtons = CIBlock::GetPanelButtons(
			$arItem["IBLOCK_ID"],
			$arItem["ID"],
			0,
			array("SECTION_BUTTONS"=>false, "SESSID"=>false)
		);
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

		if(strlen($arItem["ACTIVE_FROM"])>0)
			$arItem["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()));
		else
			$arItem["DISPLAY_ACTIVE_FROM"] = "";

		Iblock\InheritedProperty\ElementValues::queue($arItem["IBLOCK_ID"], $arItem["ID"]);

		$arResult["ITEMS"][]=$arItem;
		$arResult["LAST_ITEM_IBLOCK_ID"]=$arItem["IBLOCK_ID"];
	}

	foreach ($arResult["ITEMS"] as &$arItem)
	{
		$ipropValues = new Iblock\InheritedProperty\ElementValues($arItem["IBLOCK_ID"], $arItem["ID"]);
		$arItem["IPROPERTY_VALUES"] = $ipropValues->getValues();
		Iblock\Component\Tools::getFieldImageData(
			$arItem,
			array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
			Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
			'IPROPERTY_VALUES'
		);
	}
	unset($arItem);

	$this->setResultCacheKeys(array(
		"LAST_ITEM_IBLOCK_ID",
	));
	$this->includeComponentTemplate();
}

if(
	$arResult["LAST_ITEM_IBLOCK_ID"] > 0
	&& $USER->IsAuthorized()
	&& $APPLICATION->GetShowIncludeAreas()
	&& CModule::IncludeModule("iblock")
)
{
	$arButtons = CIBlock::GetPanelButtons($arResult["LAST_ITEM_IBLOCK_ID"], 0, 0, array("SECTION_BUTTONS"=>false));
	$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
}

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);


$arComponentDescription = array(
    "NAME" => Loc::getMessage('NIHOL_IBMDB2_COMPONENT_NAME'),
    "DESCRIPTION" => Loc::getMessage('NIHOL_IBMDB2_COMPONENT_DESCRIPTION'),
    "ICON" => "/images/news_all.gif",
    "COMPLEX" => "Y",
    "PATH" => array(
        "ID" => "Nihol",
        "CHILD" => array(
            "ID" => "ibmdb2",
            "NAME" => Loc::getMessage("NIHOL_IBMDB2_COMPONENT_DESC")
        ),
    ),
);

?>
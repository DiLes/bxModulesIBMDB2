<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Configuration;
//use \Bitrix\Main\CAdminMessage;

global $APPLICATION;
Loc::loadMessages(__FILE__);

if(!check_bitrix_sessid())
{
    return;
}
// работа с .settings.php
$install_count = Configuration::getInstance()->get('nihol_ibmdb2');
$cache_type = Configuration::getInstance()->get('cache');
// работа с .settings.php


if($ex = $APPLICATION->GetException())
{
    echo CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => Loc::getMessage("MOD_INST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
}
else
{
    echo CAdminMessage::ShowNote(Loc::getMessage("MOD_INST_OK"));
}

// работа с .settings.php
echo CAdminMessage::ShowMessage(array("MESSAGE" => Loc::getMessage("NIHOL_IBMDB2_INSTALL_COUNT") . $install_count["install"], "TYPE" => "OK"));

if (!$cache_type["type"] || $cache_type["type"] == "none")
{
    echo CAdminMessage::ShowMessage(array("MESSAGE" => Loc::getMessage("NIHOL_IBMDB2_NO_CACHE"), "TYPE" => "ERROR"));
}
// работа с .settings.php

?>

<form action="<?=$APPLICATION->GetCurPage();?>">
    <input type="hidden" name="lang" value="<?=LANGUAGE_ID;?>">
    <input type="submit" name="" value="<?=Loc::getMessage("MOD_BACK");?>">
</form>
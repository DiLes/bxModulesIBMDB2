<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use \Bitrix\Main\HttpApplication;

$module_id = "nihol.ibmdb2";
Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/options.php");
Loc::loadMessages(__FILE__);
if ($APPLICATION->GetGroupRight($module_id) < "S") {
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}
\Bitrix\Main\Loader::includeModule($module_id);
$request = HttpApplication::getInstance()->getContext()->getRequest();
# Описание опций
$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("NIHOL_IBMDB2_TAB_COMMON_SETTINGS"),
        "OPTIONS" => array(
            array(
                "NIHOL_IBMDB2_FEED_NOTIFIES_COUNT",
                Loc::getMessage("NIHOL_IBMDB2_FEED_NOTIFIES_COUNT"),
                "30",
                array("text", 50)
            ),
            array(
                "NIHOL_IBMDB2_AGENT_ID",
                Loc::getMessage("NIHOL_IBMDB2_AGENT_ID"),
                "",
                array("text", 50)
            ),
        )
    ),
    array(
        "DIV" => "edit2",
        "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS")
    ),
);
# Описание опций
$customOptions = array(
//	array(
//		"STATR_DATE_ACTION",
//	),
//	array(
//		"END_DATE_ACTION",
//	),
);
# Сохранение
if ($request->isPost() && $request["Update"] && check_bitrix_sessid()) {
    foreach ($aTabs as $aTab) {
        // Или можно использовать __AdmSettingsSaveOptions($MODULE_ID, $arOptions);
        foreach ($aTab["OPTIONS"] as $arOption) {
            if (!is_array($arOption)) // Строка с подсветкой. Используется для разделения настроек в одной вкладке
                continue;
            if ($arOption["note"]) // Уведомление с подсветкой
                continue;
            $optionName = $arOption[0];
            $optionValue = $request->getPost($optionName);
            Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue): $optionValue);
        }
    }
    //поля с датой и временем не рендерятся __AdmSettingsSaveOptions
    foreach ($customOptions as $arOption) {
        if (!is_array($arOption))
            continue;
        if ($arOption["note"])
            continue;
        $optionName = $arOption[0];
        $optionValue = $request->getPost($optionName);
        Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue): $optionValue);
    }
    LocalRedirect($APPLICATION->GetCurPage() . "?lang=" . LANGUAGE_ID . "&mid_menu=1&mid=" . urlencode($module_id) .
        "&tabControl_active_tab=" . urlencode($request["tabControl_active_tab"]));
}
# Визуальный вывод
$tabControl = new CAdminTabControl("tabControl", $aTabs);
?>
<? $tabControl->Begin(); ?>
    <form method="post" action="<?= $APPLICATION->GetCurPage()?>?mid=<?= htmlspecialcharsbx($request["mid"])?>&amp;lang=<?= $request["lang"]?>"
          name="esd_core_settings">
        <? echo bitrix_sessid_post(); ?>



        <? $tabCount = 1;
        foreach ($aTabs as $aTab):
            if ($aTab["OPTIONS"]): ?>
                <? $tabControl->BeginNextTab(); ?>

                <!--			--><?// if ($tabCount === 1) : ?>
                <!---->
                <!--				<tr>-->
                <!--					<td>--><?//=Loc::getMessage("ESD_CORE_STATR_DATE")?><!--</td>-->
                <!--					<td>--><?//=CAdminCalendar::CalendarDate("STATR_DATE_ACTION", Option::get($module_id, "STATR_DATE_ACTION"), 18, true)?><!--</td>-->
                <!---->
                <!--				</tr>-->
                <!--				<tr>-->
                <!--					<td>--><?//=Loc::getMessage("ESD_CORE_END_DATE")?><!--</td>-->
                <!--					<td>--><?//=CAdminCalendar::CalendarDate("END_DATE_ACTION", Option::get($module_id, "END_DATE_ACTION"), 18, true)?><!--</td>-->
                <!--				</tr>-->
                <!---->
                <!--			--><?// endif; ?>

                <? __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]); ?>
            <?endif;
        endforeach; ?>

        <?
        $tabControl->BeginNextTab();
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");
        $tabControl->Buttons(); ?>

        <input type="submit" name="Update" value="<?= GetMessage("MAIN_SAVE")?>">
        <input type="reset" name="reset" value="<?= GetMessage("MAIN_RESET")?>">

    </form>
<? $tabControl->End(); ?>
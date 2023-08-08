<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");
Loc::loadMessages(__FILE__);

$module_id = "nihol.ibmdb2";
CModule::IncludeModule($module_id);

$MOD_RIGHT = $APPLICATION->GetGroupRight($module_id);
if ( $MOD_RIGHT < "S") {
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}
else {
    $arAllOptions =	Array(
        Array(
            "opt_hostname",
            Loc::getMessage("NIHOL_IBMDB2_OPTION_HOSTNAME"),
            "hostname",
            Array("text")
        ),
        Array(
            "opt_username",
            Loc::getMessage("NIHOL_IBMDB2_OPTION_USERNAME"),
            "username",
            Array("text")
        ),
        Array(
            "opt_password",
            Loc::getMessage("NIHOL_IBMDB2_OPTION_PASSWORD"),
            "",
            Array("password")
        ),
        Array(
            "opt_database",
            Loc::getMessage("NIHOL_IBMDB2_OPTION_DATABASE"),
            "database",
            Array("text", 20)
        ),
        Array(
            "opt_schema",
            Loc::getMessage("NIHOL_IBMDB2_OPTION_SCHEMA"),
            "schema",
            Array("text")
        ),
        Array(
            "opt_table",
            Loc::getMessage("NIHOL_IBMDB2_OPTION_TABLE"),
            "table",
            Array("text")
        ),
    );

    $aTabs = array(
        array(
            "DIV" => "edit1",
            "TAB" => Loc::getMessage("NIHOL_IBMDB2_OPTION_COMMON_SETTINGS"),
            "ICON" => "ibmdb2_settings",
            "TITLE" => Loc::getMessage("NIHOL_IBMDB2_OPTION_COMMON_SETTINGS")
        ),
        array(
            "DIV" => "edit2",
            "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
            "ICON" => "ibmdb2_settings",
            "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS")
        ),
    );
    $tabControl = new CAdminTabControl("tabControl", $aTabs);

    $tabControl->Begin();
    ?>
    <form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>" name="ibmdb2_settings">
        <?$tabControl->BeginNextTab();?>
        <?__AdmSettingsDrawList("nihol.ibmdb2", $arAllOptions);?>
        <?$tabControl->BeginNextTab();?>
        <?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
        <?$tabControl->Buttons();?>
        <script language="JavaScript">
            function RestoreDefaults()
            {
                if(confirm('<?echo AddSlashes(Loc::GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
                    window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?echo LANG?>&mid=<?echo urlencode($mid)."&".bitrix_sessid_get();?>";
            }
        </script>
        <input type="submit" name="Update" <?if ($MOD_RIGHT<"S") echo "disabled" ?> value="<?=Loc::GetMessage("NIHOL_IBMDB2_OPTIONS_SAVE")?>">
        <input type="reset" name="reset" value="<?=Loc::GetMessage("NIHOL_IBMDB2_OPTIONS_RESET")?>">
        <input type="hidden" name="Update" value="Y">
        <?=bitrix_sessid_post();?>
        <input type="button" <?if ($MOD_RIGHT<"S") echo "disabled" ?> title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="RestoreDefaults();" value="<?=Loc::GetMessage("MAIN_RESTORE_DEFAULTS")?>">
        <?$tabControl->End();?>
    </form>
<?}?>


<?
echo BeginNote();
echo Loc::GetMessage("NIHOL_IBMDB2_OPTIONS_USE_MSG");
echo EndNote();
?>
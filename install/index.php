<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\ModuleManager;
use \Bitrix\Main\Config as Conf;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;
use \Bitrix\Main\Component;
use \Bitrix\Main\EventManager;
use \Nihol\Ibmdb2\ClientsTable;
use \Nihol\Ibmdb2\UserFields;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

//global $APPLICATION;

class nihol_ibmdb2 extends CModule
{
    //var $CONSTANTS;

    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__."/version.php");

        $this->MODULE_ID = "nihol.ibmdb2";
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("NIHOL_IBMDB2_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("NIHOL_IBMDB2_MODULE_DESCRIPTION");

        $this->PARTNER_NAME = Loc::getMessage("NIHOL_IBMDB2_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("NIHOL_IBMDB2_PARTNER_URI");

        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = "Y";
        $this->MODULE_GROUP_RIGHTS = "Y";
    }

    public function isVersionD7()
    {
        return CheckVersion(ModuleManager::getVersion("main"), "14.00.00");
    }

    public function getPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(), "", dirname(__DIR__));
        else
            return dirname(__DIR__);
    }
    
    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        //Добавление UF поля для контактов
        Nihol\Ibmdb2\UserFields::addUfFieldContactIbmdb2ID(); //Добавление UF поля IBMDB2_ID
        Nihol\Ibmdb2\UserFields::addUfFieldContactInn(); //Добавление UF поля INN
        Nihol\Ibmdb2\UserFields::addUfFieldContactDmodified(); //Добавление UF поля DMODIFIED

        //Добавление UF поля для компании
        Nihol\Ibmdb2\UserFields::addUfFieldCompanyIbmdb2ID(); //Добавление UF поля IBMDB2_ID
        Nihol\Ibmdb2\UserFields::addUfFieldCompanyInn(); //Добавление UF поля INN
        Nihol\Ibmdb2\UserFields::addUfFieldCompanyDmodified(); //Добавление UF поля DMODIFIED

        //Добавление UF поля для лидов
        Nihol\Ibmdb2\UserFields::addUfFieldMainSection(); //Добавление UF поля Основной раздел (Main Section)

        if(!Application::getConnection(Nihol\Ibmdb2\ClientsTable::getConnectionName())->isTableExists(
            Base::getInstance('Nihol\Ibmdb2\ClientsTable')->getDBTableName()
            )
        )
        {
            Base::getInstance('Nihol\Ibmdb2\ClientsTable')->createDbTable();
        }
    }

    function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        //Удаление UF поля для контактов
        Nihol\Ibmdb2\UserFields::deleteUfFieldContactIbmdb2ID(); //Удаление UF поля IBMDB2_ID
        Nihol\Ibmdb2\UserFields::deleteUfFieldContactInn(); //Удаление UF поля INN
        Nihol\Ibmdb2\UserFields::deleteUfFieldContactDmodified(); //Удаление UF поля DMODIFIED

        //Удаление UF поля для компании
        Nihol\Ibmdb2\UserFields::deleteUfFieldCompanyIbmdb2ID(); //Удаление UF поля IBMDB2_ID
        Nihol\Ibmdb2\UserFields::deleteUfFieldCompanyInn(); //Удаление UF поля INN
        Nihol\Ibmdb2\UserFields::deleteUfFieldCompanyDmodified(); //Удаление UF поля DMODIFIED

        //Удаление UF поля для лидов
        Nihol\Ibmdb2\UserFields::deleteUfFieldMainSection(); //Удаление UF поля Основной раздел (Main Section)UF поля DMODIFIED

        Application::getConnection(ClientsTable::getConnectionName())->
            queryExecute('drop table if exists '.Base::getInstance('\Nihol\Ibmdb2\ClientsTable')->getDBTableName());
        Option::delete($this->MODULE_ID);


    }

    function InstallEvents()
    {
        EventManager::getInstance()->registerEventHandler($this->MODULE_ID, 'MyClass', $this->MODULE_ID, '\Nihol\Ibmdb2\Events', 'eventHandler');
    }
    function UnInstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler($this->MODULE_ID, 'MyClass', $this->MODULE_ID, '\Nihol\Ibmdb2\Events', 'eventHandler');
    }

    function InstallFiles()
    {
        $path = $this->GetPath()."/install/components";
        if(\Bitrix\Main\IO\Directory::isDirectoryExists($path))
        {
            CopyDirFiles($path, $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
        }
        else
        {
            throw new \Bitrix\Main\IO\InvalidPathException($path);
        }
    }

    function UnInstallFiles()
    {
        \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . "/components");
    }

   /* public function SetOptions($arModuleOption)
    {
        foreach ($arModuleOption as $optionName => $optionValue) {
            Option::set($this->MODULE_ID, $optionName, $optionValue);
        }
    }
    public function UnsetOptions()
    {
        Option::delete($this->MODULE_ID);
    }*/

    function DoInstall()
    {

        global $APPLICATION;
        if($this->isVersionD7())
        {
            ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();

            // работа с .setting.php
            $configuration = Conf\Configuration::getInstance();
            $nihol_ibmdb2 = $configuration->get('nihol_ibmdb2');
            $nihol_ibmdb2['install'] = $nihol_ibmdb2['install'] + 1;
            $configuration->add('nihol_ibmdb2',$nihol_ibmdb2);
            $configuration->saveConfiguration();
            // работа с .setting.php
        }
        else
        {
            $APPLICATION->ThrowException(Loc::getMessage("NIHOL_IBMDB2_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("NIHOL_IBMDB2_INSTALL_TITLE"), $this->GetPath()."/install/step.php");

    }

    function DoUnInstall()
    {
        global $APPLICATION;
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        if($request["step"] < 2){
            $APPLICATION->IncludeAdminFile(Loc::getMessage("NIHOL_IBMDB2_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep1.php");
        }
        elseif($request["step"] == 2)
        {
            $this->UnInstallFiles();
            $this->UnInstallEvents();

            if($request["savedata"] != "Y")
            {
                $this->UnInstallDB();
            }

            ModuleManager::unRegisterModule($this->MODULE_ID);

            // работа с .setting.php
            $configuration = Conf\Configuration::getInstance();
            $nihol_ibmdb2 = $configuration->get('nihol_ibmdb2');
            $nihol_ibmdb2['uninstall'] = $nihol_ibmdb2['uninstall'] + 1;
            $configuration->add('nihol_ibmdb2',$nihol_ibmdb2);
            $configuration->saveConfiguration();
            // работа с .setting.php

            $APPLICATION->IncludeAdminFile(Loc::getMessage("NIHOL_IBMDB2_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep2.php");
        }

    }

    function GetModuleRightList()
    {
        return array(
            "reference_id" => array("D", "K", "S", "W"),
            "reference" => array(
                "[D] ".Loc::getMessage("NIHOL_IBMDB2_DENIED"),
                "[K] ".Loc::getMessage("NIHOL_IBMDB2_READ_COMPONENT"),
                "[S] ".Loc::getMessage("NIHOL_IBMDB2_WRITE_SETTINGS"),
                "[W] ".Loc::getMessage("NIHOL_IBMDB2_FULL")

            )
        );
    }


}
?>
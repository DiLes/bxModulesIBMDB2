<?

namespace Nihol\Ibmdb2;

use Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

class Ibmdb2 extends CBitrixComponent
{

    protected function checkModules()
    {
        if(!Loader::includeModule('nihol.ibmdb2'))
        {
            ShowError(Loc::getMessage('NIHOL_IBMDB2_MODULE_NOT_INSTALLED'));
            return false;
        }

        return true;

    }

    function var1()
    {
        $arResult = "У Вас есть доступ к компоненту и здесь может быть Ваш исполняемый код";
        return $arResult;
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $this->includeComponentLang('class.php');

        $this->checkModules();

        if($APPLICATION->GetGroupRight("nihol.ibmdb2") < "K")
        {
            ShowError(Loc::getMessage("ACCESS_DENIED"));
        }
        else
        {
            $this -> arResult = $this -> var1();
        }

        if($this->checkModules())
        {
            /* КОД*/
            $this->includeComponentTemplate();
        }

    }
}

?>

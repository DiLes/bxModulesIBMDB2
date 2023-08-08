<?
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Type;
use \Nihol\Ibmdb2\ClientsTable;


class Ibmdb2OrmDelete extends CBitrixComponent //Удаление
{
    //Проверяет подключение необходимы модулей
    protected function checkModules()
    {
        if(!Main\Loader::includeModule('nihol.ibmdb2'))
            throw new Main\LoaderException(Loc::getMessage('NIHOL_IBMDB2_MODULE_NOT_INSTALLED'));
    }

    //Удаление записи. Нужно указать верный ID
    function var1()
    {
        $result = ClientsTable::delete(1);

        return $result;
    }

    public function executeComponent()
    {
        $this->includeComponentLang('class.php');

        $this->checkModules();
        //все верно
        $result = $this->var1();

        //Не указал обязательное поле: название
        //$result = $this->var2();

        //Добавление исползуя поле по умолчанию.
        //$result = $this->var3();

        if($result->isSuccess())
        {
            $this->arResult = 'Запись удалена';

        }
        else
        {
            $error = $result->getErrorMessages();
            $this->arResult = 'Произошла ошибка при удалении: <pre>'.var_export($error, true).'</pre>';
        }

        $this->includeComponentTemplate();
    }
}
?>
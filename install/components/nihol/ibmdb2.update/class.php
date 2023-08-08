<?
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Type;
use \Nihol\Ibmdb2\ClientsTable;


class Ibmdb2OrmUpdate extends CBitrixComponent //Обновление
{
    //Проверяет подключение необходимы модулей
    protected function checkModules()
    {
        if(!Main\Loader::includeModule('nihol.ibmdb2'))
            throw new Main\LoaderException(Loc::getMessage('NIHOL_IBMDB2_MODULE_NOT_INSTALLED'));
    }

    //Обновление записи. Обновляется только C_MOBILE_PHONE. Нужно указать верный ID
    function var1()
    {
        $result = ClientsTable::update(array(
            'C_MOBILE_PHONE' => '+998901180103'
        ));

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
            $id = $result->getId();
            $this->arResult = 'Запись обновлена id: '.$id;

        }
        else
        {
            $error = $result->getErrorMessages();
            $this->arResult = 'Произошла ошибка при обновлении: <pre>'.var_export($error, true).'</pre>';
        }

        $this->includeComponentTemplate();
    }
}
?>
<?
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Type;
use \Nihol\Ibmdb2\ClientsTable;

class Ibmdb2OrmAdd extends CBitrixComponent //Добавление
{
    //Проверяет подключение необходимы модулей
    protected function checkModules()
    {
        if(!Main\Loader::includeModule('nihol.ibmdb2'))
            throw new Main\LoaderException(Loc::getMessage('NIHOL_IBMDB2_MODULE_NOT_INSTALLED'));
    }

    //Корректное добавление записи
    function var1()
    {
        $result = ClientsTable::add(array(
            'C_PHONE' => '+998981230103',
            'C_LNAME' => 'Иванов',
            'C_NAME' => 'Иван',
            'C_MNAME' => 'Иванович',
            'C_ADRESS' => 'Москва, Ленинградская, 44',
            'C_EMAIL' => 'ivanovs@mail.ru',
            'C_INN' => '300400600',
            'C_MOBILE_PHONE' => '+998981230103'
        ));

        return $result;
    }

    //Добавление записи без обязательного поля "Телефон"
    function var2()
    {
        $result = ClientsTable::add(array(
            'C_LNAME' => 'Иванов',
            'C_NAME' => 'Иван',
            'C_MNAME' => 'Иванович',
            'C_ADRESS' => 'Москва, Ленинградская, 44',
            'C_EMAIL' => 'ivanovs@mail.ru',
            'C_INN' => '300400600',
            'C_MOBILE_PHONE' => '+998981230103'
        ));

        return $result;
    }

    //Добавление записи без указания поля, для которого установлено значение по умолчанию
    function var3()
    {
        $result = ClientsTable::add(array(
            'C_PHONE' => '+998981230103',
            'C_LNAME' => 'Иванов',
            'C_NAME' => 'Иван',
            'C_MNAME' => 'Иванович',
            'C_ADRESS' => 'Москва, Ленинградская, 44',
            'C_EMAIL' => 'ivanovs@mail.ru',
            'C_INN' => '300400600',
            'C_MOBILE_PHONE' => '+998981230103'
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
            $this->arResult = 'Запись добавлена с id: '.$id;

        }
        else
        {
            $error = $result->getErrorMessages();
            $this->arResult = 'Произошла ошибка при добавлении: <pre>'.var_export($error, true).'</pre>';
        }

        $this->includeComponentTemplate();
    }
}
?>
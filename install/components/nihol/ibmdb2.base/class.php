<?
use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

class Ibmdb2 extends CBitrixComponent
{
    var $test;

    protected function checkModules()
    {
        if(!Loader::includeModule('nihol.ibmdb2'))
        {
            ShowError(Loc::getMessage('NIHOL_IBMDB2_MODULE_NOT_INSTALLED'));
            return false;
        }

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

class Ibmdb2OrmValidator extends CBitrixComponent //Валидация
{
    //Проверяет подключение необходимы модулей
    protected function checkModules()
    {
        if(!Main\Loader::includeModule('nihol.ibmdb2'))
            throw new Main\LoaderException(Loc::getMessage('NIHOL_IBMDB2_MODULE_NOT_INSTALLED'));
    }

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
            'C_MOBILE_PHONE' => '+998981230103, +998998460103'
        ));

        return $result;
    }
}
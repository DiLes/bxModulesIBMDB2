<?
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Type;
use \Nihol\Ibmdb2\ClientsTable;

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
?>
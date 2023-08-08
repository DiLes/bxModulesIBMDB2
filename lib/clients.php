<?

namespace Nihol\Ibmdb2;

use CUserTypeEntity;
use Bitrix\Main\Entity;

class ClientsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'nihol_ibmdb2_contact_company_db2';
    }

    /*public static function getUfId()
    {
        return 'UF_IBMDB2_ID';
    }*/

    /*public static function getConnectionName()
    {
        return 'ibmbd2';
    }*/

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
            )),
            // ID контакта
            new Entity\IntegerField('CONTACT_ID', array(
                'required' => true,
            )),
            // ID компании
            new Entity\IntegerField('COMPANY_ID', array(
                'required' => true,
            )),
            // ID IBMSB2
            new Entity\IntegerField('IBMDB2_ID', array(
                'required' => true,
            )),

        );
    }

}

class UserFields extends Entity\DataManager
{
    public static function addUfFieldContactIbmdb2ID()
    {
        $oUserTypeEntity = CUserTypeEntity::GetList(
            array("ID" => "DESC"),
            array('FIELD_NAME' => 'UF_CRM_CNT_DB2ID'))
            ->Fetch();
        if(!$oUserTypeEntity){
            $oUserTypeEntity  = new CUserTypeEntity();

            $aUserFields = array(
                /*
                *  Идентификатор сущности, к которой будет привязано свойство.
                * Для секция формат следующий - CRM_CONTACT
                */
                'ENTITY_ID'         => 'CRM_CONTACT',
                /* Код поля. Всегда должно начинаться с UF_ */
                'FIELD_NAME'        => 'UF_CRM_CNT_DB2ID',
                /* Указываем, что тип нового пользовательского свойства строка */
                'USER_TYPE_ID'      => 'integer',
                /*
                * XML_ID пользовательского свойства.
                * Используется при выгрузке в качестве названия поля
                */
                'XML_ID'            => 'XML_ID_CRM_CONTACT_IBMDB2_ID',
                /* Сортировка */
                'SORT'              => 100,
                /* Является поле множественным или нет */
                'MULTIPLE'          => 'N',
                /* Обязательное или нет свойство */
                'MANDATORY'         => 'N',
                /*
                * Показывать в фильтре списка. Возможные значения:
                * не показывать = N, точное совпадение = I,
                * поиск по маске = E, поиск по подстроке = S
                */
                'SHOW_FILTER'       => 'Y',
                /*
                * Не показывать в списке. Если передать какое-либо значение,
                * то будет считаться, что флаг выставлен.
                */
                'SHOW_IN_LIST'      => 'Y',
                /*
                * Пустая строка разрешает редактирование.
                * Если передать какое-либо значение, то будет считаться,
                * что флаг выставлен.

                */
                'EDIT_IN_LIST'      => 'Y',
                /* Значения поля участвуют в поиске */
                'IS_SEARCHABLE'     => 'Y',
                /*
            * Дополнительные настройки поля (зависят от типа).
            * В нашем случае для типа string
            */
                'SETTINGS'          => array(
                    /* Значение по умолчанию */
                    'DEFAULT_VALUE' => '',
                    /* Размер поля ввода для отображения */
                    'SIZE'          => '20',
                    /* Количество строчек поля ввода */
                    'ROWS'          => '1',
                    /* Минимальная длина строки (0 - не проверять) */
                    'MIN_LENGTH'    => '0',
                    /* Максимальная длина строки (0 - не проверять) */
                    'MAX_LENGTH'    => '0',
                    /* Регулярное выражение для проверки */
                    'REGEXP'        => '',
                ),
                /* Подпись в форме редактирования */
                'EDIT_FORM_LABEL'   => array(
                    'ru'    => 'IBMDB2 ID Поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Заголовок в списке */
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'IBMDB2 ID Поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Подпись фильтра в списке */
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'IBMDB2 ID Поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Сообщение об ошибке (не обязательное) */
                'ERROR_MESSAGE'     => array(
                    'ru'    => 'Ошибка при заполнении пользовательского свойства',
                    'en'    => 'An error in completing the user field',
                ),
                /* Помощь */
                'HELP_MESSAGE'      => array(
                    'ru'    => '',
                    'en'    => '',
                ),
            );

            $iUserFieldId   = $oUserTypeEntity->Add($aUserFields); // int

            return $iUserFieldId;
        }
        else
        {
            echo "Такое поле существует!!!";
        }
    }

    public static function deleteUfFieldContactIbmdb2ID()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_CONTACT", "FIELD_NAME" => "UF_CRM_CNT_DB2ID");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }
    /*
        public static function deleteUfFieldContact()
        {
            if(!$oUserTypeEntity){
                $oUserTypeEntity  = new CUserTypeEntity();
            $oUserTypeEntity->Delete( $iUserFieldId );   // CDBResult
        }
    */
    public static function addUfFieldContactInn()
    {
        $oUserTypeEntity = CUserTypeEntity::GetList(
            array("ID" => "DESC"),
            array('FIELD_NAME' => 'UF_CRM_CNT_INN'))
            ->Fetch();
        if(!$oUserTypeEntity){
            $oUserTypeEntity  = new CUserTypeEntity();

            $aUserFields = array(
                /*
                *  Идентификатор сущности, к которой будет привязано свойство.
                * Для секция формат следующий - CRM_CONTACT
                */
                'ENTITY_ID'         => 'CRM_CONTACT',
                /* Код поля. Всегда должно начинаться с UF_ */
                'FIELD_NAME'        => 'UF_CRM_CNT_INN',
                /* Указываем, что тип нового пользовательского свойства строка */
                'USER_TYPE_ID'      => 'string',
                /*
                * XML_ID пользовательского свойства.
                * Используется при выгрузке в качестве названия поля
                */
                'XML_ID'            => 'XML_ID_CRM_CONTACT_INN',
                /* Сортировка */
                'SORT'              => 100,
                /* Является поле множественным или нет */
                'MULTIPLE'          => 'N',
                /* Обязательное или нет свойство */
                'MANDATORY'         => 'N',
                /*
                * Показывать в фильтре списка. Возможные значения:
                * не показывать = N, точное совпадение = I,
                * поиск по маске = E, поиск по подстроке = S
                */
                'SHOW_FILTER'       => 'Y',
                /*
                * Не показывать в списке. Если передать какое-либо значение,
                * то будет считаться, что флаг выставлен.
                */
                'SHOW_IN_LIST'      => 'Y',
                /*
                * Пустая строка разрешает редактирование.
                * Если передать какое-либо значение, то будет считаться,
                * что флаг выставлен.

                */
                'EDIT_IN_LIST'      => 'Y',
                /* Значения поля участвуют в поиске */
                'IS_SEARCHABLE'     => 'Y',
                /*
            * Дополнительные настройки поля (зависят от типа).
            * В нашем случае для типа string
            */
                'SETTINGS'          => array(
                    /* Значение по умолчанию */
                    'DEFAULT_VALUE' => '',
                    /* Размер поля ввода для отображения */
                    'SIZE'          => '20',
                    /* Количество строчек поля ввода */
                    'ROWS'          => '1',
                    /* Минимальная длина строки (0 - не проверять) */
                    'MIN_LENGTH'    => '0',
                    /* Максимальная длина строки (0 - не проверять) */
                    'MAX_LENGTH'    => '0',
                    /* Регулярное выражение для проверки */
                    'REGEXP'        => '',
                ),
                /* Подпись в форме редактирования */
                'EDIT_FORM_LABEL'   => array(
                    'ru'    => 'ИНН поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Заголовок в списке */
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'ИНН поля',
                    'en'    => 'INN',
                ),
                /* Подпись фильтра в списке */
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'ИНН поля',
                    'en'    => 'INN',
                ),
                /* Сообщение об ошибке (не обязательное) */
                'ERROR_MESSAGE'     => array(
                    'ru'    => 'Ошибка при заполнении пользовательского свойства',
                    'en'    => 'An error in completing the user field',
                ),
                /* Помощь */
                'HELP_MESSAGE'      => array(
                    'ru'    => '',
                    'en'    => '',
                ),
            );

            $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields ); // int

            return $iUserFieldId;
        }
    }

    public static function deleteUfFieldContactInn()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_CONTACT", "FIELD_NAME" => "UF_CRM_CNT_INN");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }

    public static function addUfFieldContactDmodified()
    {
        $oUserTypeEntity = CUserTypeEntity::GetList(
            array("ID" => "DESC"),
            array('FIELD_NAME' => 'UF_CRM_CNT_DMODIFIED'))
            ->Fetch();
        if(!$oUserTypeEntity){
            $oUserTypeEntity  = new CUserTypeEntity();

            $aUserFields = array(
                /*
                *  Идентификатор сущности, к которой будет привязано свойство.
                * Для секция формат следующий - CRM_CONTACT
                */
                'ENTITY_ID'         => 'CRM_CONTACT',
                /* Код поля. Всегда должно начинаться с UF_ */
                'FIELD_NAME'        => 'UF_CRM_CNT_DMODIFIED',
                /* Указываем, что тип нового пользовательского свойства строка */
                'USER_TYPE_ID'      => 'string',
                /*
                * XML_ID пользовательского свойства.
                * Используется при выгрузке в качестве названия поля
                */
                'XML_ID'            => 'XML_ID_CRM_CONTACT_DMODIFIED',
                /* Сортировка */
                'SORT'              => 100,
                /* Является поле множественным или нет */
                'MULTIPLE'          => 'N',
                /* Обязательное или нет свойство */
                'MANDATORY'         => 'N',
                /*
                * Показывать в фильтре списка. Возможные значения:
                * не показывать = N, точное совпадение = I,
                * поиск по маске = E, поиск по подстроке = S
                */
                'SHOW_FILTER'       => 'Y',
                /*
                * Не показывать в списке. Если передать какое-либо значение,
                * то будет считаться, что флаг выставлен.
                */
                'SHOW_IN_LIST'      => 'Y',
                /*
                * Пустая строка разрешает редактирование.
                * Если передать какое-либо значение, то будет считаться,
                * что флаг выставлен.

                */
                'EDIT_IN_LIST'      => 'Y',
                /* Значения поля участвуют в поиске */
                'IS_SEARCHABLE'     => 'Y',
                /*
            * Дополнительные настройки поля (зависят от типа).
            * В нашем случае для типа string
            */
                'SETTINGS'          => array(
                    /* Значение по умолчанию */
                    'DEFAULT_VALUE' => '',
                    /* Размер поля ввода для отображения */
                    'SIZE'          => '20',
                    /* Количество строчек поля ввода */
                    'ROWS'          => '1',
                    /* Минимальная длина строки (0 - не проверять) */
                    'MIN_LENGTH'    => '0',
                    /* Максимальная длина строки (0 - не проверять) */
                    'MAX_LENGTH'    => '0',
                    /* Регулярное выражение для проверки */
                    'REGEXP'        => '',
                ),
                /* Подпись в форме редактирования */
                'EDIT_FORM_LABEL'   => array(
                    'ru'    => 'DMODIFIED поля',
                    'en'    => 'DMODIFIED',
                ),
                /* Заголовок в списке */
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'DMODIFIED поля',
                    'en'    => 'DMODIFIED',
                ),
                /* Подпись фильтра в списке */
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'DMODIFIED поля',
                    'en'    => 'DMODIFIED',
                ),
                /* Сообщение об ошибке (не обязательное) */
                'ERROR_MESSAGE'     => array(
                    'ru'    => 'Ошибка при заполнении пользовательского свойства',
                    'en'    => 'An error in completing the user field',
                ),
                /* Помощь */
                'HELP_MESSAGE'      => array(
                    'ru'    => '',
                    'en'    => '',
                ),
            );

            $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields ); // int

            return $iUserFieldId;
        }
    }

    public static function deleteUfFieldContactDmodified()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_CONTACT", "FIELD_NAME" => "UF_CRM_CNT_DMODIFIED");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }

    public static function addUfFieldCompanyIbmdb2ID()
    {
        $oUserTypeEntity = CUserTypeEntity::GetList(
            array("ID" => "DESC"),
            array('FIELD_NAME' => 'UF_CRM_CMP_DB2ID'))
            ->Fetch();
        if(!$oUserTypeEntity){
            $oUserTypeEntity  = new CUserTypeEntity();

            $aUserFields = array(
                /*
                *  Идентификатор сущности, к которой будет привязано свойство.
                * Для секция формат следующий - CRM_CONTACT
                */
                'ENTITY_ID'         => 'CRM_COMPANY',
                /* Код поля. Всегда должно начинаться с UF_ */
                'FIELD_NAME'        => 'UF_CRM_CMP_DB2ID',
                /* Указываем, что тип нового пользовательского свойства строка */
                'USER_TYPE_ID'      => 'integer',
                /*
                * XML_ID пользовательского свойства.
                * Используется при выгрузке в качестве названия поля
                */
                'XML_ID'            => 'XML_ID_CRM_COMPANY_IBMDB2_ID',
                /* Сортировка */
                'SORT'              => 100,
                /* Является поле множественным или нет */
                'MULTIPLE'          => 'N',
                /* Обязательное или нет свойство */
                'MANDATORY'         => 'N',
                /*
                * Показывать в фильтре списка. Возможные значения:
                * не показывать = N, точное совпадение = I,
                * поиск по маске = E, поиск по подстроке = S
                */
                'SHOW_FILTER'       => 'Y',
                /*
                * Не показывать в списке. Если передать какое-либо значение,
                * то будет считаться, что флаг выставлен.
                */
                'SHOW_IN_LIST'      => 'Y',
                /*
                * Пустая строка разрешает редактирование.
                * Если передать какое-либо значение, то будет считаться,
                * что флаг выставлен.

                */
                'EDIT_IN_LIST'      => 'Y',
                /* Значения поля участвуют в поиске */
                'IS_SEARCHABLE'     => 'Y',
                /*
            * Дополнительные настройки поля (зависят от типа).
            * В нашем случае для типа string
            */
                'SETTINGS'          => array(
                    /* Значение по умолчанию */
                    'DEFAULT_VALUE' => '',
                    /* Размер поля ввода для отображения */
                    'SIZE'          => '20',
                    /* Количество строчек поля ввода */
                    'ROWS'          => '1',
                    /* Минимальная длина строки (0 - не проверять) */
                    'MIN_LENGTH'    => '0',
                    /* Максимальная длина строки (0 - не проверять) */
                    'MAX_LENGTH'    => '0',
                    /* Регулярное выражение для проверки */
                    'REGEXP'        => '',
                ),
                /* Подпись в форме редактирования */
                'EDIT_FORM_LABEL'   => array(
                    'ru'    => 'IBMDB2 ID Поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Заголовок в списке */
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'IBMDB2 ID Поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Подпись фильтра в списке */
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'IBMDB2 ID Поля',
                    'en'    => 'IBMDB2 ID',
                ),
                /* Сообщение об ошибке (не обязательное) */
                'ERROR_MESSAGE'     => array(
                    'ru'    => 'Ошибка при заполнении пользовательского свойства',
                    'en'    => 'An error in completing the user field',
                ),
                /* Помощь */
                'HELP_MESSAGE'      => array(
                    'ru'    => '',
                    'en'    => '',
                ),
            );

            $iUserFieldId   = $oUserTypeEntity->Add($aUserFields); // int

            return $iUserFieldId;
        }
        else
        {
            echo "Такое поле существует!!!";
        }
    }

    public static function deleteUfFieldCompanyIbmdb2ID()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_COMPANY", "FIELD_NAME" => "UF_CRM_CMP_DB2ID");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }

    public static function addUfFieldCompanyInn()
    {
        $oUserTypeEntity = CUserTypeEntity::GetList(
            array("ID" => "DESC"),
            array('FIELD_NAME' => 'UF_CRM_CMP_INN'))
            ->Fetch();
        if(!$oUserTypeEntity){
            $oUserTypeEntity  = new CUserTypeEntity();

            $aUserFields = array(
                /*
                *  Идентификатор сущности, к которой будет привязано свойство.
                * Для секция формат следующий - CRM_CONTACT
                */
                'ENTITY_ID'         => 'CRM_COMPANY',
                /* Код поля. Всегда должно начинаться с UF_ */
                'FIELD_NAME'        => 'UF_CRM_CMP_INN',
                /* Указываем, что тип нового пользовательского свойства строка */
                'USER_TYPE_ID'      => 'string',
                /*
                * XML_ID пользовательского свойства.
                * Используется при выгрузке в качестве названия поля
                */
                'XML_ID'            => 'XML_ID_CRM_COMPANY_INN',
                /* Сортировка */
                'SORT'              => 100,
                /* Является поле множественным или нет */
                'MULTIPLE'          => 'N',
                /* Обязательное или нет свойство */
                'MANDATORY'         => 'N',
                /*
                * Показывать в фильтре списка. Возможные значения:
                * не показывать = N, точное совпадение = I,
                * поиск по маске = E, поиск по подстроке = S
                */
                'SHOW_FILTER'       => 'Y',
                /*
                * Не показывать в списке. Если передать какое-либо значение,
                * то будет считаться, что флаг выставлен.
                */
                'SHOW_IN_LIST'      => 'Y',
                /*
                * Пустая строка разрешает редактирование.
                * Если передать какое-либо значение, то будет считаться,
                * что флаг выставлен.

                */
                'EDIT_IN_LIST'      => 'Y',
                /* Значения поля участвуют в поиске */
                'IS_SEARCHABLE'     => 'Y',
                /*
            * Дополнительные настройки поля (зависят от типа).
            * В нашем случае для типа string
            */
                'SETTINGS'          => array(
                    /* Значение по умолчанию */
                    'DEFAULT_VALUE' => '',
                    /* Размер поля ввода для отображения */
                    'SIZE'          => '20',
                    /* Количество строчек поля ввода */
                    'ROWS'          => '1',
                    /* Минимальная длина строки (0 - не проверять) */
                    'MIN_LENGTH'    => '0',
                    /* Максимальная длина строки (0 - не проверять) */
                    'MAX_LENGTH'    => '0',
                    /* Регулярное выражение для проверки */
                    'REGEXP'        => '',
                ),
                /* Подпись в форме редактирования */
                'EDIT_FORM_LABEL'   => array(
                    'ru'    => 'ИНН поля',
                    'en'    => 'INN',
                ),
                /* Заголовок в списке */
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'ИНН поля',
                    'en'    => 'INN',
                ),
                /* Подпись фильтра в списке */
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'ИНН поля',
                    'en'    => 'INN',
                ),
                /* Сообщение об ошибке (не обязательное) */
                'ERROR_MESSAGE'     => array(
                    'ru'    => 'Ошибка при заполнении пользовательского свойства',
                    'en'    => 'An error in completing the user field',
                ),
                /* Помощь */
                'HELP_MESSAGE'      => array(
                    'ru'    => '',
                    'en'    => '',
                ),
            );

            $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields ); // int

            return $iUserFieldId;
        }
    }

    public static function deleteUfFieldCompanyInn()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_COMPANY", "FIELD_NAME" => "UF_CRM_CMP_INN");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }

    public static function addUfFieldCompanyDmodified()
    {
        $oUserTypeEntity = CUserTypeEntity::GetList(
            array("ID" => "DESC"),
            array('FIELD_NAME' => 'UF_CRM_CMP_DMODIFIED'))
            ->Fetch();
        if(!$oUserTypeEntity){
            $oUserTypeEntity  = new CUserTypeEntity();

            $aUserFields = array(
                /*
                *  Идентификатор сущности, к которой будет привязано свойство.
                * Для секция формат следующий - CRM_CONTACT
                */
                'ENTITY_ID'         => 'CRM_COMPANY',
                /* Код поля. Всегда должно начинаться с UF_ */
                'FIELD_NAME'        => 'UF_CRM_CMP_DMODIFIED',
                /* Указываем, что тип нового пользовательского свойства строка */
                'USER_TYPE_ID'      => 'string',
                /*
                * XML_ID пользовательского свойства.
                * Используется при выгрузке в качестве названия поля
                */
                'XML_ID'            => 'XML_ID_CRM_COMPANY_DMODIFIED',
                /* Сортировка */
                'SORT'              => 100,
                /* Является поле множественным или нет */
                'MULTIPLE'          => 'N',
                /* Обязательное или нет свойство */
                'MANDATORY'         => 'N',
                /*
                * Показывать в фильтре списка. Возможные значения:
                * не показывать = N, точное совпадение = I,
                * поиск по маске = E, поиск по подстроке = S
                */
                'SHOW_FILTER'       => 'Y',
                /*
                * Не показывать в списке. Если передать какое-либо значение,
                * то будет считаться, что флаг выставлен.
                */
                'SHOW_IN_LIST'      => 'Y',
                /*
                * Пустая строка разрешает редактирование.
                * Если передать какое-либо значение, то будет считаться,
                * что флаг выставлен.

                */
                'EDIT_IN_LIST'      => 'Y',
                /* Значения поля участвуют в поиске */
                'IS_SEARCHABLE'     => 'Y',
                /*
            * Дополнительные настройки поля (зависят от типа).
            * В нашем случае для типа string
            */
                'SETTINGS'          => array(
                    /* Значение по умолчанию */
                    'DEFAULT_VALUE' => '',
                    /* Размер поля ввода для отображения */
                    'SIZE'          => '20',
                    /* Количество строчек поля ввода */
                    'ROWS'          => '1',
                    /* Минимальная длина строки (0 - не проверять) */
                    'MIN_LENGTH'    => '0',
                    /* Максимальная длина строки (0 - не проверять) */
                    'MAX_LENGTH'    => '0',
                    /* Регулярное выражение для проверки */
                    'REGEXP'        => '',
                ),
                /* Подпись в форме редактирования */
                'EDIT_FORM_LABEL'   => array(
                    'ru'    => 'DMODIFIED поля',
                    'en'    => 'DMODIFIED',
                ),
                /* Заголовок в списке */
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'DMODIFIED поля',
                    'en'    => 'DMODIFIED',
                ),
                /* Подпись фильтра в списке */
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'DMODIFIED поля',
                    'en'    => 'DMODIFIED',
                ),
                /* Сообщение об ошибке (не обязательное) */
                'ERROR_MESSAGE'     => array(
                    'ru'    => 'Ошибка при заполнении пользовательского свойства',
                    'en'    => 'An error in completing the user field',
                ),
                /* Помощь */
                'HELP_MESSAGE'      => array(
                    'ru'    => '',
                    'en'    => '',
                ),
            );

            $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields ); // int

            return $iUserFieldId;
        }
    }

    public static function deleteUfFieldCompanyDmodified()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_COMPANY", "FIELD_NAME" => "UF_CRM_CMP_DMODIFIED");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }

    public static function addUfFieldMainSection()
    {
    $oUserTypeEntity = CUserTypeEntity::GetList(
        array("ID" => "DESC"),
        array('FIELD_NAME' => 'UF_CRM_MAIN_SECTION'))
        ->Fetch();
    if(!$oUserTypeEntity){
        $oUserTypeEntity  = new CUserTypeEntity();

        $aUserFields = array(
            /*
            *  Идентификатор сущности, к которой будет привязано свойство.
            * Для секция формат следующий - CRM_CONTACT
            */
            'ENTITY_ID'         => 'CRM_LEAD',
            /* Код поля. Всегда должно начинаться с UF_ */
            'FIELD_NAME'        => 'UF_CRM_MAIN_SECTION',
            /* Указываем, что тип нового пользовательского свойства строка */
            'USER_TYPE_ID'      => 'iblock_section',
            /*
            * XML_ID пользовательского свойства.
            * Используется при выгрузке в качестве названия поля
            */
            'XML_ID'            => 'XML_ID_CRM_MAIN_SECTION',
            /* Сортировка */
            'SORT'              => 100,
            /* Является поле множественным или нет */
            'MULTIPLE'          => 'N',
            /* Обязательное или нет свойство */
            'MANDATORY'         => 'N',
            /*
            * Показывать в фильтре списка. Возможные значения:
            * не показывать = N, точное совпадение = I,
            * поиск по маске = E, поиск по подстроке = S
            */
            'SHOW_FILTER'       => 'Y',
            /*
            * Не показывать в списке. Если передать какое-либо значение,
            * то будет считаться, что флаг выставлен.
            */
            'SHOW_IN_LIST'      => 'Y',
            /*
            * Пустая строка разрешает редактирование.
            * Если передать какое-либо значение, то будет считаться,
            * что флаг выставлен.

            */
            'EDIT_IN_LIST'      => 'Y',
            /* Значения поля участвуют в поиске */
            'IS_SEARCHABLE'     => 'Y',
            /*
        * Дополнительные настройки поля (зависят от типа).
        * В нашем случае для типа string
        */
            'SETTINGS'          => array(
                'DISPLAY'   => 'LIST',
                'LIST_HEIGHT'   => 1,
                'IBLOCK_ID'     => 31,
                'DEFAULT_VALUE' => '',
                'ACTIVE_FILTER' => 'Y',
            ),
            /* Подпись в форме редактирования */
            'EDIT_FORM_LABEL'   => array(
                'ru'    => 'Основной раздел',
                'en'    => 'Main Section',
            ),
            /* Заголовок в списке */
            'LIST_COLUMN_LABEL' => array(
                'ru'    => 'Основной раздел',
                'en'    => 'Main Section',
            ),
            /* Подпись фильтра в списке */
            'LIST_FILTER_LABEL' => array(
                'ru'    => 'Основной раздел',
                'en'    => 'Main Section',
            ),
            /* Сообщение об ошибке (не обязательное) */
            'ERROR_MESSAGE'     => array(
                'ru'    => 'Ошибка при заполнении пользовательского свойства',
                'en'    => 'An error in completing the user field',
            ),
            /* Помощь */
            'HELP_MESSAGE'      => array(
                'ru'    => '',
                'en'    => '',
            ),
        );

        $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields ); // int

        return $iUserFieldId;
    }
}

    public static function deleteUfFieldMainSection()
    {
        $oUserTypeEntity  = new CUserTypeEntity();
        $Order = array("ID" => "DESC");
        $Filter = array("ENTITY_ID" => "CRM_LEAD", "FIELD_NAME" => "UF_CRM_MAIN_SECTION");
        while ($aUserTypeEntity = CUserTypeEntity::GetList($Order,$Filter)->Fetch())
        {
            $dUserFieldId = $oUserTypeEntity->Delete($aUserTypeEntity["ID"]);
        }

        return $dUserFieldId;
    }
}
?>
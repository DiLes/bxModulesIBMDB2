<?php
CModule::AddAutoloadClasses(
    'nihol.ibmdb2',
    array(
        '\Nihol\Ibmdb2' => 'lib/class.php',
        '\Nihol\Ibmdb2\Db2Connect' => 'lib/db2_connect.php',
        '\Nihol\Ibmdb2\Clients' => 'lib/clients.php',
        '\Nihol\Ibmdb2\ClientsTable' => 'lib/clients.php',
        '\Nihol\Ibmdb2\UserFields' => 'lib/clients.php',
        '\Nihol\Ibmdb2\Events' => 'lib/events.php'
        )
);
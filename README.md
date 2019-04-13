# autoapiserver
Automated API CRUD Server (Laravel Passport Friendly)

Installation:

composer require entelodon/autoapiserver

Create a directory with name "Configs" in your app "folder"
inside it create a file named "Tables.php" with the following contents:

<?php
namespace App\Configs;

class Tables
{
    protected static function getTablesConfiguration()
    {
        $configuration = [];
        
        return $configuration;
    }
}

Register the routes with the following line in your "api.php" file located in the "routes" folder of your project:

AutoApiServer\Api\ApiServer\Auto\ApiAuto::setRoutes();

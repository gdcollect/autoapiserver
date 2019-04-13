<?php

namespace AutoApiServer\Api\ApiServer;


use AutoApiServer\Api\ApiServer\Configs\Tables;

class ConfigurationChecks extends Tables
{
    private function __construct()
    {
    }

    private static $configuration = [];

    public static function setTablesConfiguration()
    {
        self::$configuration = parent::getTablesConfiguration();
    }

    public static function getAccessibleTables()
    {
        return self::$configuration;
    }

    public static function isTablesConfigurationSet()
    {
        return count(self::$configuration) > 0;
    }

    public static function areTablePropertiesSet(string $table)
    {
        return array_key_exists($table, self::$configuration);
    }

    public static function getTableProperties(string $table)
    {
        return self::$configuration[$table];
    }

    public static function areAllowedActionsSet(string $table)
    {
        return array_key_exists('allowedActions', self::getTableProperties($table));
    }

    public static function getAllowedActions(string $table)
    {
        return self::getTableProperties($table)['allowedActions'];
    }

    public static function isActionAllowed(string $table, string $action)
    {
        return in_array($action, self::getAllowedActions($table));
    }

    public static function areHiddenFieldsSet(string $table)
    {
        return array_key_exists('hiddenFields', self::getTableProperties($table));
    }

    public static function getHiddenFields(string $table)
    {
        return self::getTableProperties($table)['hiddenFields'];
    }

    public static function areGuardedFieldsSet(string $table)
    {
        return array_key_exists('guardedFields', self::getTableProperties($table));
    }

    public static function getGuardedFields(string $table)
    {
        return self::getTableProperties($table)['guardedFields'];
    }

    public static function areValidationRulesSet(string $table, string $type)
    {
        return array_key_exists('validation', self::getTableProperties($table)) && array_key_exists($type, self::getTableProperties($table)['validation']);
    }

    public static function getValidationRules(string $table, string $type)
    {
        return self::getTableProperties($table)['validation'][$type];
    }

    public static function isMiddlewareSet(string $table, string $type)
    {
        return array_key_exists('middleware', self::getTableProperties($table)) && array_key_exists($type, self::getTableProperties($table)['middleware']);
    }

    public static function getMiddleware(string $table, string $type)
    {
        return self::getTableProperties($table)['middleware'][$type];
    }
}

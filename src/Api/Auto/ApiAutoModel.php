<?php

namespace AutoApiServer\Api\Auto;

use AutoApiServer\Api\ApiServer\Auto\Registry;
use AutoApiServer\Api\ApiServer\ConfigurationChecks;
use Illuminate\Database\Eloquent\Model;

class ApiAutoModel extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = Registry::getValue('table');

        if (ConfigurationChecks::isTablesConfigurationSet() && ConfigurationChecks::areTablePropertiesSet($this->table)) {
            if (ConfigurationChecks::areHiddenFieldsSet($this->table)) {
                $this->hidden = ConfigurationChecks::getHiddenFields($this->table);
            }

            if (ConfigurationChecks::areGuardedFieldsSet($this->table)) {
                $this->guarded = ConfigurationChecks::getGuardedFields($this->table);
            }
        }

        parent::__construct($attributes);
    }
}

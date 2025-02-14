<?php

return [
    'authorities' => [
        'user' => [
            'user_show',
            'user_create',
            'user_update',
            'user_delete',
        ],
        'role' => [
            'role_show',
            'role_create',
            'role_update',
            'role_delete',
        ],
        'setting_app' => [
            'setting_app_show',
            'setting_app_update',
        ],
        'device' => [
            'device_show',
            'device_create',
            'device_update',
            'device_delete',
            'device_sign'
        ],
        'province' => [
            'province_show',
            'province_create',
            'province_update',
            'province_delete',
        ],
        'city' => [
            'city_show',
            'city_create',
            'city_update',
            'city_delete',
        ],
        'district' => [
            'district_show',
            'district_create',
            'district_update',
            'district_delete',
        ],
        'village' => [
            'village_show',
            'village_create',
            'village_update',
            'village_delete',
        ],
        'instance' => [
            'instance_show',
            'instance_create',
            'instance_update',
            'instance_delete'
        ],
        'subinstance' => [
            'subinstance_show',
            'subinstance_create',
            'subinstance_update',
            'subinstance_delete'
        ],
        'cluster' => [
            'cluster_show',
            'cluster_create',
            'cluster_update',
            'cluster_delete'
        ],
        'bussiness' => [
            'bussiness_show',
            'bussiness_create',
            'bussiness_edit',
            'bussiness_update',
            'bussiness_delete'
        ],
        'subnet' => [
            'subnet_show',
            'subnet_create',
            'subnet_update',
            'subnet_delete'
        ],
        'ticket' => [
            'ticket_show',
            'ticket_detail',
            'ticket_create',
            'ticket_update',
            'ticket_delete'
        ],
        'billing' => [
            'billing_show',
            'billing_detail',
            'edit_variable'
        ],
        'gateway' => [
            'gateway_show',
            'gateway_detail',
            'gateway_report',
        ],
        'activity_log' => [
            'activity_log_show',
        ],
        'report_log' => [
            'report_gateway_log',
            'report_device_log',
        ],
        'raw_data' => [
            'raw_data_show'
        ],
        'parsed_wm' => [
            'parsed_wm_show'
        ],
        'parsed_gm' => [
            'parsed_gm_show'
        ],
        'parsed_pm' => [
            'parsed_pm_show'
        ],
        'master_water_meter' => [
            'master_water_meter_show',
        ],
        'master_power_meter' => [
            'master_power_meter_show',
        ],
        'master_gas_meter' => [
            'master_gas_meter_show',
        ]
    ],

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Change this if you want to name the related pivots other than defaults
         */
        'role_pivot_key' => null, //default 'role_id',
        'permission_pivot_key' => null, //default 'permission_id',

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Change this if you want to use the teams feature and your related model's
         * foreign key is other than `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * Set this to false, if you want to implement custom logic for checking permissions.
     */

    'register_permission_check_method' => true,

    /*
     * When set to true the package implements teams using the 'team_foreign_key'. If you want
     * the migrations to register the 'team_foreign_key', you must set this to true
     * before doing the migration. If you already did the migration then you must make a new
     * migration to also add 'team_foreign_key' to 'roles', 'model_has_roles', and
     * 'model_has_permissions'(view the latest version of package's migration file)
     */

    'teams' => false,

    /*
     * When set to true, the required permission names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    /*
     * When set to true, the required role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_role_in_exception' => false,

    /*
     * By default wildcard permission lookups are disabled.
     */

    'enable_wildcard_permission' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],
];

<?php

$project = 'Fortress-Micro';

return [

    /**
     * default application namespace
     */
    'namespace'          => 'App',

    /**
     * Virtual Admin path -> Real location
     * Dynamic admin control panel location
     */
    'admin_directory'    => 'bridge',

    /**
     * Vendor locations
     */
    'local_vendor'       => '../../' . $project . '/vendor/',
    'global_vendor'      => '../../vendor/',

    /**
     * Base paths
     */
    'base_path'          => rtrim( dirname( dirname( $_SERVER['SCRIPT_NAME'] ) ) , '/' ) . '/' ,
    'root_path'          => $project . '/',
    'app_root'           => $project . '/app/',

    /**
     * App paths
     */
    'app_path'           => 'app/',
    'cache'              => 'app/cache/',
    'config'             => 'app/config/',
    'firewall'           => 'app/config/firewall/',
    'redirects'          => 'app/config/redirects/',
    'controllers'        => 'app/controllers/',
    'modules'            => 'app/modules/',
    'models'             => 'app/models/',
    'kernel'             => 'app/kernel/',
    'views'              => 'app/views/',
    'layouts'            => 'app/views/layouts/',
    'pages'              => 'app/views/pages/',
    'partials'           => 'app/views/partials/',
    'articles'           => 'app/views/pages/articles/',

    /**
     * Public themes / assets
     */
    'public'             => 'public/',
    'assets'             => 'public/assets/',
    'themes'             => 'public/themes/',

    /**
     * Tmp dir
     */
    'tmp'                => 'app/tmp/',
    'logs'               => 'app/tmp/logs/',
    'errors'             => 'app/tmp/errors/',
    'session_save'       => 'app/tmp/session/',

    /**
     * Audit logs
     */
    'audit'              => 'app/tmp/audit/',
    'attempt_login'      => 'app/tmp/audit/login/attempt/',
    'failed_login'       => 'app/tmp/audit/login/fail/',
    'last_login'         => 'app/tmp/audit/login/last/',
    'locked_login'       => 'app/tmp/audit/login/locked/',
    'locked_history'     => 'app/tmp/audit/login/locked/history/',
];
<?php

/**
 * Fortified CMS Application Routes
 * NinjaSentry.com 2016
 */

return [

    /**
     * Short Routes
     * ( request method @ module::controller/method
     */
    'home'    => 'get@home::index',
    'privacy' => 'get@home::index/privacy',

    'about'   => 'get@about::index',
    'contact' => 'get@contact::index',
    'logout'  => 'get@logout::index',


    /**
     * Contact form processing page
     */
    'contact/send'  => [
        'method'          => 'post',
        'module'          => 'contact',
        'controller'      => 'send',
    ],

    /**
     * Sign In form view page
     */
    'sign-in'             => [
        'method'          => 'get',
        'module'          => 'login',
        'controller'      => 'index',
        'action'          => 'index',
    ],

    /**
     * Sign in form processing page
     */
    'login'       => [
        'method'          => 'post',
        'module'          => 'login',
        'controller'      => 'attempt',
        'action'          => 'index',
    ],

    'sign-out'             => [
        'method'           => 'get',
        'module'           => 'logout',
        'controller'       => 'index',
        'action'           => 'index',
    ],

    'signed-out'           => [
        'method'           => 'get',
        'module'           => 'logout',
        'controller'       => 'index',
        'action'           => 'loggedOut',
    ],

    /**
     * Site offline status page
     */
    'status'               => [
        'method'           => 'get',
        'module'           => 'home',
        'controller'       => 'offline',
        'action'           => 'index',
    ],

    /**
     * Article routes
     */
    ':article'            => [
        'method'          => 'get',
        'module'          => 'articles',
        'controller'      => 'index',
        'action'          =>  1,
    ],

    /**
     * Regex Routes
     */
    ':module/:controller/:action/:param/:arg' => [
        'method'          => 'get',
        'module'          => 1,
        'controller'      => 2,
        'action'          => 3,
        'param'           => 4
    ],

];
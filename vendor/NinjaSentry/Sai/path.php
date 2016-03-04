<?php
namespace NinjaSentry\Sai;
use NinjaSentry\Sai\Config;

/**
 * Class Path
 * @package NinjaSentry\Sai
 */
class Path
{
    const DOCUMENT_ROOT    = 'doc_root';
    const APPLICATION_ROOT = 'base_path';

    /**
     * Application path map
     * @var
     */
    private $map;

    /**
     * Domain / Server name
     * @var
     */
    private $domain;

    /**
     * @param Config $config
     * @param Config $paths
     * @param string $mode
     */
    public function __construct( Config $config, Config $paths, $mode = '' )
    {
        $this->config  = $config->get( $mode );
        $this->domain  = $this->config->server_name;
        $this->map     = $paths;
    }

    /**
     * Get application base HTTP path
     *
     * @param bool|false $ssl
     * @return string
     */
    public function http( $ssl = false )
    {
        $protocol = empty( $ssl )
            ? 'http'
            : 'https';

        $http_path  = $protocol . '://' . $this->domain;
        $http_path .= $this->appRoot();

        if( substr( $http_path, -1 ) !== '/' ) {
            $http_path .= '/';
        }

        return $http_path;
    }

    /**
     * Get application directory path
     *
     * windows:
     * $path->app('kernel') === C:/wamp/www/git/fortress/app/kernel/
     *
     * Linux:
     * $path->app('kernel') === /var/www/git/fortress/app/kernel/
     *
     * @param string $path
     * @return string
     * @throws \Exception
     */
    public function app( $path = self::APPLICATION_ROOT )
    {
        $docRoot = $this->documentRoot();

        if( substr( $docRoot, -1 ) !== '/' ) {
            $docRoot .= '/';
        }

        if( $path === self::DOCUMENT_ROOT ) {
            return $docRoot;
        }

        if( $this->map->has( $path ) ) {
            $value = $docRoot . $this->map->get( $path );
            return $value;
        }

        throw new \Exception(
            'Path Error :: Not found ( ' . escaped( $path ) .  ' )'
        );
    }

    /**
     * Get application root path set in app/config/env.php
     * Used for building internal application path
     *
     * @return mixed
     * @throws \Exception
     */
    private function documentRoot()
    {
        if( empty( $this->config->document_root ) )
        {
            throw new \Exception(
                'Path Error :: Expected "document_root" setting not found.'
                . 'Please check your /app/config/env.php file for more details'
            );
        }

        return $this->config->document_root;
    }

    /**
     * Get application base path for building a HTTP path
     *
     * Remove the basePath ( real document root )
     * D:/wamp/www
     *
     * from the document root path ( relative to application )
     * D:/wamp/www/git/fortress/
     *
     * to isolate the application (sub)directory root path
     * /git/fortress/
     *
     * @return mixed
     * @throws \Exception
     */
    private function appRoot()
    {
        if( ! empty( $_SERVER['DOCUMENT_ROOT'] ) ) {
            $basePath = $_SERVER['DOCUMENT_ROOT'];
        } else {
            // todo :: calculate sub directory depth
            $basePath = dirname( dirname( $_SERVER['SCRIPT_NAME'] ) );
        }

        if( empty( $basePath ) )
        {
            throw new \Exception(
                'Path Error :: Application base path not found'
            );
        }

        return str_replace( $basePath, '', $this->documentRoot() );
    }
}

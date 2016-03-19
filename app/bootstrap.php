<?php
namespace App;

use NinjaSentry\Sai\Application;
use NinjaSentry\Sai\Tools\Timer;

/**
 * Core Functions
 */
require '../../vendor/NinjaSentry/Sai/Functions/global.php';

/**
 * Class Bootstrap
 */
final class Bootstrap
{
    /**
     * Bootstrap Constructor
     * Register Class AutoLoader
     */
    public function __construct() {
        spl_autoload_register([ $this, 'classLoader' ]);
    }

    /**
     * Invoke Application
     */
    public function __invoke()
    {
        try{

            ob_start([ $this, 'stats' ]);

            Timer::start();

            $app = new Application;

            $app->foundation()
                ->secure()
                ->request();

            echo $app->dispatch()
                ->getContent();

            ob_get_flush();

        }
        catch( \Exception $ex )
        {
            pre( $ex->getMessage() );
            pre( $ex->getCode() );
            pre( $ex->getTraceAsString() );
            exit;
        }
    }

    /**
     * @param $className
     * @return bool|mixed
     * @throws \Exception
     */
    public function classLoader( $className = '' )
    {
        if( ! empty( $className ) && is_string( $className ) )
        {
            $finder    = [ chr(0), '\\', 'App/'];
            $replacer  = [ '' ,  '/', 'app/' ];
            $classFile = str_replace( $finder, $replacer, $className ) . '.php';
            $path      = '../' . $classFile;

            if( mb_strpos( $classFile, 'app/') === false ) {
                $path = '../../vendor/' . $classFile;
            }

            if( is_readable( $path ) ) {
                return require $path;
            }
        }
    }

    /**
     * Content output buffer rewrite wrapper
     * replace timer tags with timer output
     * replace memory tags with memory output
     *
     * @param $buffer
     * @return mixed
     * @throws \Exception
     */
    public function stats( $buffer )
    {
        $memory = memory_peak();
        $timer  = Timer::end();

        return str_replace(
            [ "{%TIMER%}", "{%MEMORY%}" ]
            , [ $timer, $memory ]
            , $buffer
        );
    }
}

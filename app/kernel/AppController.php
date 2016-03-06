<?php
namespace App\Kernel;
use NinjaSentry\Sai\Response;

/**
 * Class AppController
 * @package App\Kernel
 */
abstract class AppController
{
    /**
     * @var
     */
    public $httpPath;

    /**
     * @var
     */
    public $route;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var
     */
    public $siteName;

    /**
     * @var
     */
    public $themePath;

    /**
     * @var
     */
    public $themeDir;

    /**
     * @var
     */
    public $themeName;

    /**
     * @param Response $response
     * @throws \Exception
     */
    public function __construct( Response $response )
    {
        if( ! $response instanceof Response )
        {
            throw new \Exception(
                'AppController Error :: Expected instance of Sai/Response not found'
            );
        }

        $this->response = $response;

        $this->auth     = $response->auth;
        $this->config   = $response->config;
        $this->path     = $response->path;
        $this->route    = $response->route;
        $this->session  = $response->auth->session;

        $this->setupTheme();
    }

    /**
     * @return mixed
     */
    abstract public function getIndex();

    /**
     * Display content
     * @param string $path
     * @throws \Exception
     */
    public function display( $path = '' ){
        $this->response->render( $path );
    }

    /**
     * Load Theme settings
     * @throws \Exception
     */
    public function setupTheme()
    {
        /**
         * Load default $page view skeleton data ( Global html page meta data )
         * This data will be displayed when no specific page data is provided
         *
         * User provided Page data will automatically override any of
         * the corresponding default values when set with the same data key name
         *
         * Eg : content( Data Key 'string', Data Value '(array|std_class obj)' )
         */
        $page = $this->config->default_page;
        // $pageData = new Response\Model\Page();

        /**
         * Add base href & canonical url to page object
         */
        $page->base_href = $this->route->getBaseHref();
        $page->canonical = $this->route->getCanonical();

        /**
         * Set response content - add $page
         */
        $this->response->content( 'page', $page );

        /**
         * Global Default Top Menu
         * loaded from app/views/partials/menu
         */
        $menu = 'menu/top-menu';

        /**
         * Bridge Admin Top Menu
         * loaded from views/partials/menu
         */
        if( $this->route->module === 'bridge' ) {
            $menu = 'menu/bridge-top-menu';
        }

        /**
         * Load compiled html menu fragment
         * Assigning top_menu into response content scope
         */
        $this->response->content( 'top_menu'
            , $this->response->fragment( $menu )
        );

        /**
         * Globalise application Site Name
         * can be appended to page titles etc ( article title - site name )
         */
        $this->siteName = $page->site_name;

        /**
         * Base Http Path
         */
        $this->httpPath = $this->path->http();

        /**
         * Load Theme settings
         */
        $this->themeDir  = $this->path->app('themes');
        $this->themeName = $this->config->theme_name;
        $this->themePath = $this->themeDir . $this->themeName;

        /**
         * Load Theme functions
         */
        $this->getThemeFunctions();
    }

    /**
     * Load theme helper functions into scope
     *
     * @throws \Exception
     */
    private function getThemeFunctions()
    {
        $functions = $this->themePath . '/functions/';

        $di = new \DirectoryIterator( $functions );

        foreach( $di as $file )
        {
            if( $file->isFile() )
            {
                $fileName = str_replace( '\\', '/', $file->getPathname() );

                if( ! is_readable( $fileName ) )
                {
                    throw new \Exception(
                        'AppController Error :: Required theme functions file is unreadable'
                        . ' ( ' . escaped( $fileName ) . ' ) '
                    );
                }

                /**
                 * Load .php files only
                 */
                if( mb_substr( $fileName, -4 ) === '.php' ) {
                    require $fileName;
                }
            }
        }
    }
}

<?php
namespace NinjaSentry\Sai;
use NinjaSentry\Katana\Http\Status;

/**
 * -----------------------------------
 * SAI Route - HTTP route management
 * -----------------------------------
 * Supported Route Commands
 * -----------------------------------
 * Segment Name | Segment Number
 * -----------------------------------
 * module/controller/action/param/arg/id/key/value
 * -----------------------------------
 * Module       - 1st array segment
 * Controller   - 2nd
 * Action       - 3rd
 * Param        - 4th
 * Arg          - 5th
 * Id           - 6th
 * Key          - 7th
 * Value        - 8th
 * -----------------------------------
 */

/**
 * Class Route
 *
 * @package NinjaSentry\Sai
 */
class Route
{
    /**
     * Route segment depth restriction
     */
    const SEGMENT_DEPTH_LIMIT = 5;

    /**
     * Allowed chars in route controller segments
     * Negative match - Accept only ( a-z 0-9 - )
     */
    const BLACKLIST_CONTROLLER_CHARS = '#(?P<deny>[^a-z0-9\-]+)#Ui';

    /**
     * Allowed chars in optional route segments
     * Negative match - Accept only ( a-z 0-9 . - )
     */
    const BLACKLIST_PARAM_CHARS = '#(?P<deny>[^a-z0-9\.\-]+)#Ui';

    /**
     * Default route segment keys
     */
    const DEFAULT_MODULE     = 'home';
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION     = 'index';

    /**
     * Absolute HTTP Path ( url )
     * @var
     */
    public $absolute_path;

    /**
     * Route Action segment
     * @var string
     */
    public $action = '';

    /**
     * Base HTTP path
     * @var
     */
    public $http_path = '';

    /**
     * Route Controller segment
     * @var string
     */
    public $controller = '';

    /**
     * Route Module segment
     * @var
     */
    public $module;

    /**
     * Full path
     * @var array
     */
    public $path = [];

    /**
     * Client request input
     * @var
     */
    private $request;

    /**
     * Application Uri
     * @var
     */
    public $uri;

    /**
     * @param array $request
     */
    public function __construct( $request = [] )
    {
        $this->http_path = $request['http_path'];
        $this->method    = $request['method'];
        $this->request   = $request['input'];
    }

    /**
     * Get Client request method
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Get Application Route path
     * @return mixed
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getRequest(){
        return $this->request;
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set( $key, $value ){
        $this->{$key} = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get( $key )
    {
        if( isset( $this->{$key} ) ) {
            return $this->{$key};
        }

        return '';
    }

    /**
     * Limit route segments ( array depth )
     * Automatically deny route requests exceeding the max segment limit
     * eg: site.com/catch/things/like/this/and/then/and/then/and/then/and/then/and/then/this/
     * @param array $segments
     * @throws \Exception
     */
    public function depthCheck( $segments = [] )
    {
        $count = count( $segments, true );

        if( $count > Route::SEGMENT_DEPTH_LIMIT )
        {
            throw new \Exception(
                'Route Error :: Route Segment Limit Exceeded ( ' . $count . ' )'
                , Status::BAD_REQUEST
            );
        }
    }

    /**
     * Build Application Route
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        if( empty( $this->request ) )
        {
            /**
             * Set default route segments when loading site root /
             * eg : index/index
             */
            $this->module     = Route::DEFAULT_MODULE;
            $this->controller = Route::DEFAULT_CONTROLLER;
            $this->action     = Route::DEFAULT_ACTION;

            /**
             * Set default route base path
             */
            $this->path = Route::DEFAULT_CONTROLLER . '/' . Route::DEFAULT_ACTION;

        } else {

            /**
             * Route Segments
             * break request input string into route segments
             * filter out empty array keys
             */
            $sg = array_filter( explode( '/', $this->request ) );

            /**
             * Enforce Route segment depth restrictions
             */
            $this->depthCheck( $sg );

            /**
             * Required routes
             * Assign 1st & 2nd segments ( eg : index/index/, home/index, category/news )
             * Module and controller route segments must never be empty
             */
            $this->module     = isset( $sg[0] ) ? $this->validateController( $sg[0] ) : Route::DEFAULT_MODULE;
            $this->controller = isset( $sg[1] ) ? $this->validateController( $sg[1] ) : Route::DEFAULT_CONTROLLER;

            /**
             * 3rd segment
             * Assign route action, if not empty ( eg : category/news/today )
             */
            if( isset( $sg[2] ) ) $this->action = $this->validateController( $sg[2] );

            /**
             * If param values are not empty
             * Assign optional named route segments via _set()
             */
            if( isset( $sg[3] ) ) $this->param = $this->validateParam( $sg[3] );
            if( isset( $sg[4] ) ) $this->arg   = $this->validateParam( $sg[4] );
            if( isset( $sg[5] ) ) $this->key   = $this->validateParam( $sg[5] );
            if( isset( $sg[6] ) ) $this->value = $this->validateParam( $sg[6] );
            if( isset( $sg[7] ) ) $this->id    = $this->validateParam( $sg[7] );

            /**
             * Get route uri
             */
            $this->path = $this->getUri();
        }

        /**
         * Get route url
         */
        $this->absolute_path = $this->getAbsolutePath();

        return $this;
    }

    /**
     * Strict validation for controller segments
     * @param string $input
     * @return string
     * @throws \Exception
     */
    public function validateController( $input = '' )
    {
        if( ! is_string( $input ) )
        {
            throw new \Exception(
                'Route Validation Error :: String type expected'
                . ' - Current type ( ' . gettype( $input ) . ' )'
                , Status::BAD_REQUEST
            );
        }

        if( mb_strlen( $input ) > 0 )
        {
            if( preg_match( Route::BLACKLIST_CONTROLLER_CHARS, $input, $matched ) === 0 ) {
                $input = trim( mb_strtolower( $input ) );
                return $input;
            }

            throw new \Exception(
                'Route Validation Error :: Input string failed validation'
                . ' - Invalid chars found ( ' . escaped( $matched['deny'] ) . ' )'
                , Status::BAD_REQUEST
            );
        }

        throw new \Exception(
            'Route Validation Error :: Input string failed validation [ No input ]'
            , Status::BAD_REQUEST
        );
    }

    /**
     * Validation for optional route param segments
     * @param string $input
     * @return string
     * @throws \Exception
     */
    public function validateParam( $input = '' )
    {
        if( ! is_string( $input ) )
        {
            throw new \Exception(
                'Route Validation Error :: String type value expected'
                . ' - Current type ( ' . gettype( $input ) . ' )'
                , Status::BAD_REQUEST
            );
        }

        if( mb_strlen( $input ) > 0 )
        {
            if( preg_match( Route::BLACKLIST_PARAM_CHARS, $input, $matched ) === 0 ) {
                $input = trim( mb_strtolower( $input ) );
                return $input;
            }

            throw new \Exception(
                'Route Validation Error :: Input string failed validation'
                . ' - Invalid chars found ( ' . escaped( $matched['deny'] ) . ' )'
                , Status::BAD_REQUEST
            );
        }

        throw new \Exception(
            'Route Validation Error :: Input string failed validation [ No input ]'
            , Status::BAD_REQUEST
        );
    }

    /**
     * Get relative URI route path
     * URI ( Universal Resource Indicator )
     * @param bool|false $trailing_slash
     * @return string
     */
    public function getUri( $trailing_slash = false )
    {
        $uri = ( ! empty( $this->module ) ? $this->module : '' );

        if( ! empty( $this->controller ) )
        {
            // exclude default controller from uri ( eg : index )
            if( $this->controller !== Route::DEFAULT_CONTROLLER ) {
                $uri .= '/' . $this->controller;
            }
        }

        if( ! empty( $this->action ) )
        {
            // exclude default action ( eg : index )
            if( $this->action !== Route::DEFAULT_ACTION ) {
                $uri .= '/' . $this->action;
            }
        }

        if( ! empty( $this->param ) )
        {
            // exclude index segment in route param
            if( $this->param !== 'index' ) {
                $uri .= '/' . $this->param;
            }
        }

        $uri .= ( ! empty( $this->arg )   ? '/' . $this->arg   : '' );
        $uri .= ( ! empty( $this->id )    ? '/' . $this->id    : '' );
        $uri .= ( ! empty( $this->key )   ? '/' . $this->key   : '' );
        $uri .= ( ! empty( $this->value ) ? '/' . $this->value : '' );

        /**
         * Append trailing slash to final uri
         */
        if( $trailing_slash ) {
            $uri .= '/';
        }

        /**
         * Save full uri
         */
        $this->uri = $uri;

        return $this->uri;
    }

    /**
     * Get absolute URL Path ( route )
     * URL ( Universal Resource Locator )
     * Append site host name to the current app Uri
     * @return string
     */
    public function getAbsolutePath()
    {
        $url = $this->http_path;
        $uri = $this->getUri();

        if( $uri !== 'index' )
        {
            if( substr( $url, -1 ) !== '/' ) {
                $url .= '/' . $uri;
            } else {
                $url .= $uri;
            }
        }

        return $url;
    }

    /**
     * Canonical URL
     *
     * Create a canonical URL in the template html document head section
     * Value is based on the current application route
     *
     * http://en.wikipedia.org/wiki/Canonical_link_element
     * https://support.google.com/webmasters/answer/139066?hl=en&rd=1
     *
     * @return string
     */
    public function getCanonical()
    {
        $str = $this->http_path;

        if( ! empty( $this->uri ) && $this->uri !== 'index' ) {
            $str = $this->absolute_path;
        }

        return mb_strtolower( $str );
    }

    /**
     * Set base href + module route if set
     * @return string
     */
    public function getBaseHref()
    {
        $path = $this->http_path;

        if( ! empty( $this->module ) && $this->module !== 'index' )
        {
            if( substr( $path, -1 ) !== '/' ) {
                $path .= '/' . $this->module;
            } else {
                $path .= $this->module;
            }
        }

        return $path;
    }
}
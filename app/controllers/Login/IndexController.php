<?php
namespace App\Controllers\Login;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class IndexController
 * @package App\Controllers\Login
 */
final class IndexController extends AppController
{
    /**
     * @param \NinjaSentry\Sai\Response $response
     */
    public function __construct( Response $response ){
        parent::__construct( $response );
    }

    /**
     * @throws \Exception
     */
    public function getIndex()
    {
        /**
         * Prepare form token
         */
        $this->response->content( 'token', $this->getFormToken() );
        $this->response->content( 'secret', $this->session->appToken );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => 'Sign In | ' . $this->siteName,

            'meta'            => [
                'description' => 'Sign in page for registered members',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL
            ],

            'content'         => $this->response->wrap( 'Fortress Sign In'
                , $this->response->fetch( 'login/index' )
            )

        ]);

        $this->display();
    }
}

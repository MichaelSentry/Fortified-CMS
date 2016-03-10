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
    public function __construct( Response $response ){
        parent::__construct( $response );
    }

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

            'title'           => 'Fortress Sign In | Fortified Content Management',

            'meta'            => [
                'description' => 'Fortress Sign In for registered members',
                'keywords'    => '',
                'robots'      => Robots::DENY_All
            ],

            'content'         => $this->response->wrap( 'Fortress Sign In'
                , $this->response->fetch( 'login/index' )
            )

        ]);

        $this->display();
    }
}

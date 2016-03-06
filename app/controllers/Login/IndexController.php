<?php
namespace App\Controllers\Login;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class IndexController
 * @package App\Controllers\Home
 */
class IndexController extends AppController
{
    public function __construct( Response $response ){
        parent::__construct( $response );
    }

    public function getIndex()
    {
        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => 'NinjaSentry Fortress | Fortified Content Management',

            'meta'            => [
                'description' => 'Fortress Login',
                'keywords'    => '',
                'robots'      => Robots::DENY_All
            ],

            'content'         => $this->response->wrap( 'Fortress Login'
                , $this->response->fetch( 'login/index' )
            )

        ]);

        $this->display();
    }
}

<?php
namespace App\Controllers\Home;

use NinjaSentry\Sai\Response;
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
                'description' => 'Fortified content management system',
                'keywords'    => 'fortified content management',
            ],

            'content'         => $this->response->wrap( 'Fortress Homepage'
                , $this->response->fetch( 'home/index' )
            )

        ]);

        $this->display();
    }
}

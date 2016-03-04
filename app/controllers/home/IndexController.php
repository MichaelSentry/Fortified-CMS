<?php
namespace App\Controllers\Home;
use App\Kernel\AppController;

/**
 * Class IndexController
 * @package App\Controllers\Home
 */
class IndexController extends AppController
{
    public function __construct( $response ){
        parent::__construct( $response );
    }

    public function getIndex()
    {
        /**
         * Prepare page data
         */
        $this->response->content( 'page', [

            'title'           => 'NinjaSentry Fortress',

            'meta'            => [
                'description' => 'NinjaSentry Homepage',
                'keywords'    => 'web application security solutions',
            ],

            'content'         => $this->response->fetch( 'home/index' ),

        ]);

        $this->display();
    }
}

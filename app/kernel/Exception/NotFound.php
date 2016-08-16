<?php
namespace App\Kernel\Exception;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class NotFound
 * @package App\Kernel\Exception
 */
class NotFound extends AppController
{
    public function __construct( Response $response ){
        parent::__construct( $response );
    }

    public function getIndex()
    {
        /**
         * Add 404 Not Found header
         */
        //$this->response->httpHeader( STATUS::NOT_FOUND );

        /**
         * Set not found http header
         */
        $this->response->httpHeader( 'HTTP/1.1 404 Not Found' );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => 'Page Not Found | ',

            'meta'            => [
                'description' => 'Page Not Found',
                'keywords'    => '',
                'robots'      => Robots::DENY_All
            ],

            'content'         => $this->response->wrap( 'Not Found'
                , $this->response->fetch( 'error/not-found' )
            )

        ]);

        $this->display();
    }
}


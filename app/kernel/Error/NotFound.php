<?php
namespace App\Kernel\Error;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class NotFound
 * @package App\Kernel\Error
 */
final class NotFound extends AppController
{
    /**
     * @param Response $response
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
         * Get http protocol version
         */
        $protocol = $this->client->protocol;

        /**
         * Set '404 Not Found' response header
         */
        $this->response->httpHeader( $protocol . ' ' . STATUS::NOT_FOUND );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => '404 Page Not Found | ' . $this->siteName,

            'meta'            => [
                'description' => 'Page Not Found',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL // page should not be indexed / archived
            ],

            'content'         => $this->response->wrap( 'Page Not Found'
                , $this->response->fetch( 'error/not-found' )
            )

        ]);

        $this->display();
    }
}
<?php
namespace App\Kernel\Error;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class ServerError
 * @package App\Kernel\Error
 */
final class ServerError extends AppController
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
         * Set '500 Server Error' response header
         */
        $this->response->httpHeader( $protocol . ' ' . STATUS::SERVER_ERROR );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => '500 Internal Server Error | ' . $this->siteName,

            'meta'            => [
                'description' => 'Internal Server Error',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL // page should not be indexed / archived
            ],

            'content'         => $this->response->wrap( 'Internal Server Error'
                , $this->response->fetch( 'error/server-error' )
            )

        ]);

        $this->display();
    }
}
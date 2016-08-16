<?php
namespace App\Kernel\Error;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class Forbidden
 * @package App\Kernel\Error
 */
final class Forbidden extends AppController
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
         * Set '403 Forbidden' response header
         */
        $this->response->httpHeader( $protocol . ' ' . STATUS::FORBIDDEN );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => '403 Forbidden | ' . $this->siteName,

            'meta'            => [
                'description' => '403 Forbidden',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL // page should not be indexed / archived
            ],

            'content'         => $this->response->wrap( '403 Forbidden'
                , $this->response->fetch( 'error/forbidden' )
            )

        ]);

        $this->display();
    }
}
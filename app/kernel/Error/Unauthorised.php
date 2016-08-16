<?php
namespace App\Kernel\Error;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class Unauthorised
 * @package App\Kernel\Error
 */
final class Unauthorised extends AppController
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
         * Set '401 Unauthorised' response header
         */
        $this->response->httpHeader( $protocol . ' ' . STATUS::UNAUTHORISED );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => '401 Authorisation Required | ' . $this->siteName,

            'meta'            => [
                'description' => 'Authorisation required',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL // page should not be indexed / archived
            ],

            'content'         => $this->response->wrap( 'Authorisation Required'
                , $this->response->fetch( 'error/unauthorised' )
            )

        ]);

        $this->display();
    }
}
<?php
namespace App\Kernel\Error;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class BadRequest
 * @package App\Kernel\Error
 */
final class BadRequest extends AppController
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
         * Set '400 Bad Request' response header
         */
        $this->response->httpHeader( $protocol . ' ' . Status::BAD_REQUEST );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => '400 Bad Request | ' . $this->siteName,

            'meta'            => [
                'description' => '400 Bad Request',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL // page should not be indexed / archived
            ],

            'content'         => $this->response->wrap( 'Bad Request'
                , $this->response->fetch( 'error/bad-request' )
            )

        ]);

        $this->display();
    }
}
<?php
namespace App\Kernel\Error;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Tools\Robots;
use NinjaSentry\Katana\Http\Status;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class Unavailable
 * @package App\Kernel\Error
 */
final class Unavailable extends AppController
{
    /**
     * Retry-after header delay ( seconds )
     */
    const RETRY_DELAY = 3600;

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
         * Set '503 Service Unavailable' response header
         */
        $this->response->httpHeader( $protocol . ' ' . Status::SERVICE_UNAVAILABLE );
        $this->response->httpHeader( 'Retry-after: ' . self::RETRY_DELAY );
        $this->response->httpHeader( 'Status: Connection close' );

        /**
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => '501 Service Unavailable | ' . $this->siteName,

            'meta'            => [
                'description' => '501 Service Unavailable',
                'keywords'    => '',
                'robots'      => Robots::DENY_ALL // page should not be indexed / archived
            ],

            'content'         => $this->response->wrap( 'Service Unavailable'
                , $this->response->fetch( 'error/unavailable' )
            )

        ]);

        $this->display();
    }
}
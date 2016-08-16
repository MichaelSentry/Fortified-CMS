<?php
namespace App\Controllers\Bridge;

use NinjaSentry\Sai\Response;
use App\Kernel\BridgeController;

/**
 * Class IndexController
 * @package App\Controllers\Bridge
 */
final class IndexController extends BridgeController
{
    /**
     * @param \NinjaSentry\Sai\Response $response
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
         * Prepare page data container
         */
        $this->response->content( 'page', [

            'title'           => 'Bridge | Admin Control Panel | ' . $this->siteName,

            'meta'            => [
                'description' => 'Admin control panel',
                'keywords'    => 'admin',
            ],

            'content'         => $this->response->wrap( 'Bridge Command'
                , $this->response->fetch( 'bridge/index' )
            )

        ]);

        $this->display();
    }
}

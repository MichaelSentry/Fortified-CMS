<?php
namespace App\Controllers\Bridge;

use NinjaSentry\Sai\Response;
use App\Kernel\BridgeController;

/**
 * Class IndexController
 * @package App\Controllers\Home
 */
final class FirewallController extends BridgeController
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

            'title'           => 'Firewall Manager | Admin Control Panel | ' . $this->siteName,

            'meta'            => [
                'description' => 'Firewall control panel',
                'keywords'    => 'bridge, admin',
            ],

            'content'         => $this->response->wrap( 'Firewall Control Panel'
                , $this->response->fetch( 'bridge/firewall/index' )
            )

        ]);

        $this->display();
    }
}

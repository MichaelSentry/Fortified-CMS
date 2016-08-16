<?php
namespace App\Kernel;

use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class BridgeController
 * @package App\Kernel
 */
abstract class BridgeController extends AppController
{
    /**
     * @param \NinjaSentry\Sai\Response $response
     */
    public function __construct( Response $response )
    {
        parent::__construct( $response );

        /**
         * Redirect admins to login page to set the bridge_token
         *
         * Once the bridge token is set successfully,
         * the bridge login page intercept is skipped automatically
         */
        if( $this->identity->isAdmin() )
        {
            /**
             * Allow bridge/login page to be viewed
             * - redirect all other page requests to bridge/login page
             */
            if( $this->route->uri !== 'bridge/login' )
            {
                if( false === ( $this->identity->get('bridge_token') ) ) {
                    $this->response->redirect( 'bridge/login' );
                }
            }

        } else {

            /**
             * RouteGuard should prevent public / unauthorised access to bridge routes
             * But just in case...
             */
            if( $this->identity->loggedIn() ) {
                $this->response->redirect('account');
            } else {
                $this->response->redirect('sign-in');
            }
        }
    }

    /**
     * No access to index
     */
    public function getIndex(){}
}
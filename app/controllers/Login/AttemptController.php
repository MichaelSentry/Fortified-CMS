<?php
namespace App\Controllers\Login;
use NinjaSentry\Sai\Response;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class IndexController
 * @package App\Controllers\Home
 */
class AttemptController extends AppController
{
    public function __construct( Response $response ){
        parent::__construct( $response );
    }

    public function getIndex()
    {
        /**
         * Redirect all failed login attempts back to login page
         * Log full error details but only display vague error messages
         * don't disclose too much information about the errors to attackers
         */
        $message = 'Sorry, your attempt to sign in has failed. The Username or Password was incorrect';

        $this->response
             ->message( $message, 'error' )
             ->redirect( 'login' );
    }
}

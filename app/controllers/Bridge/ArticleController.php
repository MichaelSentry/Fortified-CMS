<?php
namespace App\Controllers\Bridge;

use NinjaSentry\Sai\Response;
use App\Models\Article\Reader;
use App\Kernel\BridgeController;

/**
 * Class ArticleController
 * @package App\Controllers\Bridge
 */
final class ArticleController extends BridgeController
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
         * init reader model with user auth object
         */
        $reader = new Reader( $this->identity );

        /**
         * Get list of all articles
         */
        $list = $reader->getEditorsList(
            $this->path->app( 'articles' )
        );

        /**
         * Set 'articles' list
         */
        $this->response->content( 'articles', $list );

        /**
         * Get all articles meta data
         */
        $meta = $reader->getMetaData();

        /**
         * Set 'metaData' 
         */
        $this->response->content( 'metaData', $meta );

        /**
         * Set 'page' data container
         */
        $this->response->content( 'page', [

            'title'           => 'Articles Index | Admin Control Panel | ' . $this->siteName,

            'meta'            => [
                'description' => 'Articles index',
                'keywords'    => '',
            ],

            'content'         => $this->response->wrap( 'Article Index'
                , $this->response->fetch( 'bridge/article/index' )
            )

        ]);

        $this->display();
    }
}
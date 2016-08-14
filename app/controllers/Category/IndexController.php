<?php
namespace App\Controllers\Category;

use App\Models\Article\Category;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class IndexController
 * @package App\Controllers\Category
 */
final class IndexController extends AppController
{
    /**
     * @param \NinjaSentry\Sai\Response $response
     */
    public function __construct( $response ){
        parent::__construct( $response );
    }

    /**
     * @throws \Exception
     */
    public function getIndex()
    {
        /**
         * Load category model
         */
        $category = new Category();

        /**
         * Load category list
         */
        $this->response->content( 'list'
            , $category->getList()
        );

        /**
         * Prepare page content
         */
        $this->response->content( 'page', [

            'title'           => 'Category List | ' . $this->siteName,

            'meta'            => [
                'description' => 'list of article categories',
                'keywords'    => 'article category',
            ],

            'content'         => $this->response->wrap( 'Category List'
                , $this->response->fetch( 'category/index' )
            )

        ]);

        $this->display();
    }
}

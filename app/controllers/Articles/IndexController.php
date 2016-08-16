<?php
namespace App\Controllers\Articles;

use App\Models\Article\Reader;
use NinjaSentry\Sai\Environment;
use NinjaSentry\Sai\Kernel\AppController;

/**
 * Class IndexController
 * @package App\Controllers\Articles
 */
final class IndexController extends AppController
{
    /**
     * @var string
     */
    private $readFile = '';

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
         * Set page content
         */
        $this->response->content( 'page', [

            'title'   => ' Articles Index | ' . $this->siteName,

            'meta'    => [
                'description' => 'List of all articles',
                'keywords'    => 'articles',
            ],

            'content' => $this->response->wrap( 'Articles Index'
                , $this->response->fetch( 'articles/index' )
            )

        ] );

        $this->display();
    }

    /**
     * @param $param
     * @param $args
     * @throws \Exception
     */
    public function __call( $param, $args )
    {
        if( empty( $param ) ) {
            $this->notFound();
        }

        $this->getArticle();
    }

    /**
     * Load article text file
     * Located in app/views/pages/articles/
     */
    public function getArticle()
    {
        /**
         * Get article uri
         */
        $uri = $this->route->uri;

        /**
         * Relative path to article
         */
        $this->readFile = 'articles/' . $uri;

        /**
         * Prepare paths
         */
        $paths = [
            'readFile'   => $this->readFile,
            'sourceFile' => $this->path->app( 'articles' ) . $uri . '.tpl.php'
        ];

        /**
         * Load Article reader model
         */
        $article = new Reader( $this->identity );

        /**
         * Source file paths
         */
        $article->setPaths( $paths );

        /**
         * Check article file exists
         */
        if( ! $article->validFile() )
        {
            /**
             * Debug error messages [ Development | Staging Mode ]
             * readFile displays the uri but not the full file path
             */
            if( $this->getMode() !== Environment::PRODUCTION_MODE )
            {
                throw new \Exception(
                    'Article Error :: Expected article not found ( '
                    . $this->readFile . ' )'
                );
            }

            /**
             * Display 404 page [ Production Mode ]
             */
            $this->notFound();
        }

        /**
         * Extract page meta data from file header
         */
        $meta = $article->getMetaData(
            $this->config->default_page->meta
        );

        /**
         * Set page content
         */
        $this->response->content( 'page', [

            'title'   => $meta['title'] . ' | ' . $this->siteName,

            'meta'    => [
                'description' => $meta['desc'],
                'keywords'    => $meta['keys'],
            ],

            'content' => $this->response->wrap( $meta['heading']
                , $this->response->fetch( $this->readFile )
            )

        ] );

        $this->display();
    }
}
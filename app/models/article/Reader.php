<?php
namespace App\Models\Article;

/**
 * Class Reader
 * @package App\Models\Article
 */
class Reader
{
    /**
     * @var array
     */
    public $list = [];

    /**
     * @var string
     */
    private $readFile = '';

    /**
     * @var string
     */
    private $sourceFile = '';

    /**
     * @param array $paths
     */
    public function __construct( $paths = [] ){
        $this->readFile   = $paths['readFile'];
        $this->sourceFile = $paths['sourceFile'];
    }

    /**
     * @param string $dir
     * @return array
     * @throws \Exception
     */
    public function getList( $dir = '' )
    {
        if( ! is_dir( $dir ) )
        {
            throw new \Exception(
                'Article Read Error :: Expected directory location does not exist'
            . ' ( '. escaped( $dir ) . ' )'
            );
        }

        $di = new \DirectoryIterator( $dir );

        foreach( $di as $file )
        {
            if( $file->isFile() ) {
                $this->list[] = str_replace( '\\', '/', $file->getPathname() );
            }
        }

        return $this->list;
    }

    /**
     * Validate article file exists
     *
     * @throws \Exception
     */
    public function validFile(){
        return ( is_readable( $this->sourceFile ) );
    }

    /**
     * Extract page meta data from article file
     *
     * @param \stdClass $default
     * @return mixed
     * @throws \Exception
     */
    public function getMetaData( \stdClass $default )
    {
        /**
         * Create file editor
         */
        $reader = new \SplFileObject( $this->sourceFile );

        /**
         * Load file - extract metadata
         */
        while( ! $reader->eof() )
        {
            $line = $reader->fgets();

            if( ! empty( $line ) && is_string( $line ) )
            {
                /**
                 * Stop reading file at the meta_end tag
                 */
                if( mb_strpos( $line, 'meta_end' ) !== false ) {
                    break;
                }

                /**
                 * Skip all lines with no separator
                 */
                if( mb_strpos( $line, ':' ) === false ) {
                    continue;
                }

                /**
                 * Break meta data string into key / value pairs
                 */
                list( $key, $value ) = explode( ':', $line );

                /**
                 * Prepare final meta data array
                 */
                $meta[ trim( $key ) ] = trim( $value );
            }
        }

        /**
         * Clear reader
         */
        $reader = null;

        /**
         * Validate meta data array
         */
        if( empty( $meta ) || ! is_array( $meta ) )
        {
            /**
             * If no meta data is available for this page,
             * get the default page meta data
             */
            $meta = (array) $default;

            /**
             * Exit -> Pages must have meta data
             */
            if( empty( $meta ) )
            {
                throw new \Exception(
                    'Article Error :: Expected Page meta data not found in ( '
                    . $this->readFile . ' )'
                );
            }
        }

        return $meta;
    }
}
<?php
namespace NinjaSentry\Sai\Tools;
use NinjaSentry\Katana\Http\Status;

/**
 * Class File
 * Load array based config files with validation checks
 * options : convert data to object | array
 * @package NinjaSentry\Sai\Tools
 */
class File
{
    /**
     * ArrayToObject
     * @param string $file_path
     * @return mixed|null
     * @throws \Exception
     */
    public static function toObject( $file_path = '' )
    {
        self::validatePath( $file_path );

        $data = require $file_path;

        if( empty( $data ) )
        {
            throw new \Exception(
                'File Error :: Expected data array is empty ( '
                . escaped( $file_path ) . ' )'
            );
        }

        if( is_array( $data ) )
        {
            $obj = json_decode( json_encode( $data ) );

            if( null === $obj || ! is_object( $obj ) )
            {
                throw new \Exception(
                    'File Error :: Expected data array is empty ( '
                    . escaped( $file_path ) . ' )'
                );
            }

            return $obj;
        }

        throw new \Exception(
            'File Error :: Expected data not found from ( '
            . escaped( $file_path ) . ' )'
        );
    }

    /**
     * @param string $path
     * @return mixed|null
     * @throws \Exception
     */
    public static function toArray( $path = '' )
    {
        self::validatePath( $path );

        $arr = require $path;

        if( !empty( $arr ) && is_array( $arr ) ) {
            return $arr;
        }

        throw new \Exception(
            'File Error :: toArray - array data not found from ( '
            . escaped( $path ) . ' )'
        );
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public static function validatePath( $path )
    {
        if( empty( $path ) )
        {
            throw new \Exception(
                'File Validation Error :: Required Path is empty'
            );
        }

        if( ! stream_is_local( $path ) )
        {
            throw new \Exception(
                'File Validation Error :: Remote file paths are not accepted'
                , Status::SERVER_UNAVAILABLE
            );
        }

        if( ! is_string( $path ) )
        {
            throw new \Exception(
                'File Validation Error :: Required Path must be a string value'
                , Status::SERVER_UNAVAILABLE
            );
        }

        if( strpos( $path, chr(0) ) !== false )
        {
            throw new \Exception(
                'File Validation Error :: Null bytes in file path are not accepted'
                , Status::SERVER_UNAVAILABLE
            );
        }

        if( ! is_readable( $path ) )
        {
            throw new \Exception(
                'File Validation Error :: Required Path is unreadable ( '
                . escaped( $path ) . ' )'
            );
        }
    }
}
<?php
namespace NinjaSentry\Katana\Firewall\Client;

/**
 * Class Permissions
 * @package NinjaSentry\Katana\Firewall\Client
 */
class Permissions
{
    /**
     * Public read access permissions
     */
    const READ_PERMISSION_ALLOW = 'allow_all';
    const READ_PERMISSION_DENY  = 'deny_all';

    /**
     * Public post permissions
     */
    const POST_PERMISSION_ALLOW    = 'allow_post';
    const POST_PERMISSION_DENY     = 'deny_post';

    /**
     * Restrict Client POST permissions - Enforce READ ONLY mode
     * @param array $profile
     * @return bool
     */
    public function hasPost( $profile = [] )
    {
        if( mb_strtoupper( $profile['method'] ) === 'POST' )
        {
            if( $profile['access_permissions'] !== self::POST_PERMISSION_DENY ) {
                return true;
            }
        }

        return false;
    }
}

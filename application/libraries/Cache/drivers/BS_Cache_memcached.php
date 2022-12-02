<?php
/**
 * @author WitER
 * @copyright Copyright (c) 2018, WitER (https://github.com/WitER)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class BS_Cache_memcached extends CI_Cache_memcached
{
    /**
     * Get all cache keys
     *
     * @return array
     */
    public function get_keys()
    {
        $keys = $this->_memcached->getAllKeys();

        return $keys ?: [];
    }
}

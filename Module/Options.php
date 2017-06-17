<?php
/*
 * (c) Tim Goudriaan <tim@codedmonkey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\Module;

class Options
{
    private $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $this->parameters = array_merge($this->parameters, $key);

            return $this;
        }

        $this->parameters[$key] = $value;

        return $this;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    public function get($key)
    {
        return $this->parameters[$key];
    }
}

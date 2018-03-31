<?php
/*
 * (c) Tim Goudriaan <tim@codedmonkey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle;

/**
 * Represents a set of options of a module.
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class Options
{
    private $defaults;
    private $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->defaults   = $parameters;
        $this->parameters = $parameters;
    }

    /**
     * @param string|array $key
     * @param string|null $value
     *
     * @return self
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $this->parameters = array_merge($this->parameters, $key);

            return $this;
        }

        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function get($key)
    {
        return $this->parameters[$key];
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }
}

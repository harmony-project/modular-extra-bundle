<?php
/*
 * (c) Tim Goudriaan <tim@codedmonkey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\Module;


class OptionsRegistry
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @param string      $service
     * @param string      $modularType
     * @param string|null $formType
     */
    public function addService($service, $modularType, $formType = null)
    {
        $this->services[$modularType] = [
            'modular_type' => $modularType,
            'service'      => $service,
            'form_type'    => $formType,
        ];
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function has($type)
    {
        return array_key_exists($type, $this->services);
    }

    /**
     * @param string $type
     *
     * @return Options
     */
    public function getOptions($type)
    {
        return $this->services[$type]['service'];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getFormType($type)
    {
        return $this->services[$type]['form_type'];
    }
}

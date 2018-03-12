<?php
/*
 * This file is part of the Harmony package.
 *
 * (c) Tim Goudriaan <tim@harmony-project.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\Twig;

/**
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class BaseTemplateExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $baseTemplate;

    /**
     * @param string $baseTemplate
     */
    public function __construct($baseTemplate)
    {
        $this->baseTemplate = $baseTemplate;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('modular_base_template', [$this, 'getBaseTemplate']),
        ];
    }

    /**
     * @return string
     */
    public function getBaseTemplate()
    {
        return $this->baseTemplate;
    }
}

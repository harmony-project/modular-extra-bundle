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

use Harmony\Component\ModularRouting\Manager\ModuleManager;

/**
 * Adds the `module` global to Twig.
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class ModuleExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var ModuleManager|null
     */
    private $manager;

    /**
     * @param ModuleManager|null $manager
     */
    public function __construct(ModuleManager $manager = null)
    {
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'module' => $this->manager ? $this->manager->getCurrentModule() : null,
        ];
    }
}

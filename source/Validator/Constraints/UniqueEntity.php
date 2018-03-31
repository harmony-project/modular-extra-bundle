<?php
/*
 * This file is part of the Harmony package.
 *
 * (c) Tim Goudriaan <tim@harmony-project.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\Validator\Constraints;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity as BaseConstraint;

/**
 * Constraint for `UniqueEntityValidator`.
 *
 * @author Tim Goudriaan <tim@codedmonkey.com>
 */
class UniqueEntity extends BaseConstraint
{
    public $service = 'harmony_modular_extra.unique_validator';
}

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

use Doctrine\Common\Persistence\ManagerRegistry;
use Harmony\Component\ModularRouting\Model\ModularRepositoryInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator as BaseValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class UniqueEntityValidator extends BaseValidator
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;

        parent::__construct($registry);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($entity, Constraint $constraint)
    {
        $class  = get_class($entity);

        $metadata   = $this->registry->getManagerForClass($class)->getClassMetadata($class);
        $repository = $this->registry->getRepository($class);

        if ($repository instanceof ModularRepositoryInterface && $metadata->hasAssociation('module')) {
            $fields = is_array($constraint->fields) ? $constraint->fields : [$constraint->fields];

            if (!array_search('module', $fields)) {
                $fields[] = 'module';

                $constraint->fields = $fields;
            }
        }

        parent::validate($entity, $constraint);
    }
}

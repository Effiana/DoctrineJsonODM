<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Effiana\DoctrineJsonOdm\Bundle;

use Doctrine\DBAL\Types\Type;
use Effiana\DoctrineJsonOdm\Type\JsonDocumentType;
use Symfony\Component\HttpKernel\Bundle\Bundle;
/**
 * Doctrine JSON ODM integration with the Symfony framework.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class EffianaDoctrineJsonOdmBundle extends Bundle
{
    public function __construct()
    {
        if (!Type::hasType('json_document')) {
            Type::addType('json_document', JsonDocumentType::class);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $type = Type::getType('json_document');
        $type->setSerializer($this->container->get('effiana_doctrine_json_odm.serializer'));
    }
}
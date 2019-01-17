<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Effiana\DoctrineJsonOdm\Bundle\EffianaDoctrineJsonOdmBundle;
use Effiana\DoctrineJsonOdm\Tests\Fixtures\TestBundle\TestBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Test purpose micro-kernel.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new EffianaDoctrineJsonOdmBundle(),
            new TestBundle(),
        ];
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'jsonodm',
            'test' => null,
        ]);

        $db = getenv('DB');
        $c->loadFromExtension('doctrine', [
            'dbal' => [
                'driver' => 'MYSQL' === $db ? 'pdo_mysql' : 'pdo_pgsql',
                'host' => getenv("{$db}_HOST"),
                'dbname' => getenv("{$db}_DBNAME"),
                'user' => getenv("{$db}_USER"),
                'password' => getenv("{$db}_PASSWORD"),
                'charset' => 'UTF8',
            ],
            'orm' => [
                'auto_generate_proxy_classes' => true,
                'auto_mapping' => true,
            ],
        ]);
    }
}

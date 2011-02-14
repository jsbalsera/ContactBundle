<?php

/**
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bundle\IHQS\ContactBundle;

use Bundle\IHQS\ContactBundle\DependencyInjection\Compiler\ConnectorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class IHQSContactBundle extends BaseBundle
{
    public function registerExtensions(ContainerBuilder $container)
    {
        parent::registerExtensions($container);
        $container->addCompilerPass(new ConnectorPass());
    }

    public function boot()
    {
        $connectors = $this->container->getParameter('ihqs_contact.connectors');
        foreach($connectors as $connectorService)
        {
            $connector = $this->container->get($connectorService);
            $connector->register($this->container->get('event_dispatcher'), 0);
            $connector->setContainer($this->container);
        }
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
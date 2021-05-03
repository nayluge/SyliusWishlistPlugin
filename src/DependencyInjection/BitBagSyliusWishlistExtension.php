<?php

declare(strict_types=1);

namespace BitBag\SyliusWishlistPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class BitBagSyliusWishlistExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $this->registerResources('bitbag_sylius_wishlist_plugin', 'doctrine/orm', $config['resources'], $container);
        $loader->load('services.yml');
        $container->setParameter('wishlist_cookie_token', $config['wishlist_cookie_token']);
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('doctrine_migrations') || !$container->hasExtension('sylius_labs_doctrine_migrations_extra')) {
            return;
        }
    }
}

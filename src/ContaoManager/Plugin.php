<?php

declare(strict_types=1);

namespace Anker\IPageBundle\ContaoManager;

use Anker\IPageBundle\AnkerIPageBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Symfony\Component\HttpKernel\KernelInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getBundles(ParserInterface $parser): array
	{
		return [
			BundleConfig::create(AnkerIPageBundle::class)
				->setLoadAfter([ContaoCoreBundle::class])
				->setReplace(['modules']),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
	{
		return $resolver
			->resolve(__DIR__.'/../Resources/config/routing.yml')
			->load(__DIR__.'/../Resources/config/routing.yml')
		;
	}
}

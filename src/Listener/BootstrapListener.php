<?php
namespace Seo\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;

class BootstrapListener extends AbstractListenerAggregate
{
	public function attach(EventManagerInterface $events)
	{
        $this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, array($this, 'onBootstrap'));
	}

    public function onBootstrap(MvcEvent $e)
    {
        $services = $e->getApplication()->getServiceManager();
        $viewHelperManager = $services->get('ViewHelperManager');
        if ($viewHelperManager instanceof \Zend\View\HelperPluginManager) {
            // Replace the original htmlTag View Helper with ours
            if ($viewHelperManager->has('escapehtmlattr')) {
                $viewHelperManager->setAllowOverride(true);
                $viewHelperManager->setInvokableClass('htmlTag', 'Seo\View\Helper\HtmlTag');
                $viewHelperManager->setAllowOverride(false);
            }
        }
    }
}
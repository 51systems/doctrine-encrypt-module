<?php

namespace DoctrineEncryptModuleTest\Service;

use DoctrineEncryptModule\Service\DoctrineEncryptionFactory;
use PHPUnit_Framework_TestCase as BaseTestCase;
use Zend\ServiceManager\ServiceManager;
use DoctrineModuleTest\Service\TestAsset\DummyEventSubscriber;

/**
 * Base test case to be used when a service manager instance is required
 */
class EventManagerFactoryTest extends BaseTestCase
{
    public function testWillInstantiateFromFQCN()
    {
        $name = 'encryptionFactory';
        $factory = new DoctrineEncryptionFactory($name);
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'Configuration',
            array(
                'doctrine' => array(
                    'encryption' => array(
                        $name => array(
                            'reader' => 'Doctrine\Common\Annotations\Reader'
                        ),
                    ),
                ),
            )
        );

        /* $var $eventManager \Doctrine\Common\EventManager */
        $eventManager = $factory->createService($serviceManager);
        $this->assertInstanceOf('Doctrine\Common\EventManager', $eventManager);

        $listeners = $eventManager->getListeners('dummy');
        $this->assertCount(1, $listeners);
    }

    public function testWillAttachEventListenersFromConfiguredInstances()
    {
        $name = 'eventManagerFactory';
        $factory = new EventManagerFactory($name);
        $subscriber = new DummyEventSubscriber();
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'Configuration',
            array(
                'doctrine' => array(
                    'eventmanager' => array(
                        $name => array(
                            'subscribers' => array(
                                $subscriber,
                            ),
                        ),
                    ),
                ),
            )
        );

        /* $var $eventManager \Doctrine\Common\EventManager */
        $eventManager = $factory->createService($serviceManager);
        $this->assertInstanceOf('Doctrine\Common\EventManager', $eventManager);

        $listeners = $eventManager->getListeners();
        $this->assertArrayHasKey('dummy', $listeners);
        $listeners = $eventManager->getListeners('dummy');
        $this->assertContains($subscriber, $listeners);
    }

    public function testWillAttachEventListenersFromServiceManagerAlias()
    {
        $name = 'eventManagerFactory';
        $factory = new EventManagerFactory($name);
        $subscriber = new DummyEventSubscriber();
        $serviceManager = new ServiceManager();
        $serviceManager->setService('dummy-subscriber', $subscriber);
        $serviceManager->setService(
            'Configuration',
            array(
                'doctrine' => array(
                    'eventmanager' => array(
                        $name => array(
                            'subscribers' => array(
                                'dummy-subscriber'
                            ),
                        ),
                    ),
                ),
            )
        );

        /* $var $eventManager \Doctrine\Common\EventManager */
        $eventManager = $factory->createService($serviceManager);
        $this->assertInstanceOf('Doctrine\Common\EventManager', $eventManager);

        $listeners = $eventManager->getListeners();
        $this->assertArrayHasKey('dummy', $listeners);
        $listeners = $eventManager->getListeners('dummy');
        $this->assertContains($subscriber, $listeners);
    }

    public function testWillRefuseNonExistingSubscriber()
    {
        $name = 'eventManagerFactory';
        $factory = new EventManagerFactory($name);
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'Configuration',
            array(
                'doctrine' => array(
                    'eventmanager' => array(
                        $name => array(
                            'subscribers' => array(
                                'non-existing-subscriber'
                            ),
                        ),
                    ),
                ),
            )
        );

        $this->setExpectedException('InvalidArgumentException');
        $factory->createService($serviceManager);
    }
}

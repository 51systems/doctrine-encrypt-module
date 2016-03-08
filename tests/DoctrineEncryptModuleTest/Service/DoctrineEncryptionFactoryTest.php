<?php

namespace DoctrineEncryptModuleTest\Service;

use DoctrineEncryptModule\Service\DoctrineEncryptionFactory;
use PHPUnit_Framework_TestCase as BaseTestCase;
use DoctrineEncrypt\Encryptors\AES256Encryptor;
use DoctrineEncrypt\Subscribers\DoctrineEncryptSubscriber;
use Zend\ServiceManager\ServiceManager;
use DoctrineModuleTest\Service\TestAsset\DummyEventSubscriber;

/**
 * Base test case to be used when a service manager instance is required
 */
class DoctrineEncryptionFactoryTest extends BaseTestCase
{
    public function testWillInstantiate()
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
                            'reader' => '\Doctrine\Common\Annotations\AnnotationReader',
                            'adapter' => function () {
                                return new AES256Encryptor('test');
                            },
                        ),
                    ),
                ),
            )
        );

        /** @var DoctrineEncryptSubscriber $encryptSubscriber */
        $encryptSubscriber = $factory->createService($serviceManager);
        $this->assertInstanceOf('\DoctrineEncrypt\Subscribers\DoctrineEncryptSubscriber', $encryptSubscriber);
    }
}

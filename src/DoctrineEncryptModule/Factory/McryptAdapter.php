<?php

namespace DoctrineEncryptModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class McryptAdapter implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (empty($config['doctrine']['encryption']['key'])) {
            throw new \InvalidArgumentException('You need to define a non-empty key in doctrine.encryption.key config');
        }
        $key = $config['doctrine']['encryption']['key'];

        $salt = null;
        if (!empty($config['doctrine']['encryption']['salt'])) {
            $salt = $config['doctrine']['encryption']['salt'];
        }

        $cipher = \Zend\Crypt\BlockCipher::factory('mcrypt');
        $cipher->setKey($key);
        if ($salt) {
            $cipher->setSalt($salt);
        }
        return $cipher;
    }
}

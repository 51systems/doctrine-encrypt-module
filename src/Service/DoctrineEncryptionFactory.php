<?php

namespace DoctrineEncryptModule\Service;


use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use DoctrineEncryptModule\Encryptors\ZendSymmetricCryptAdapter;
use DoctrineModule\Service\AbstractFactory;
use Reprovinci\DoctrineEncrypt\Encryptors\EncryptorInterface;
use Reprovinci\DoctrineEncrypt\Subscribers\DoctrineEncryptSubscriber;
use Zend\Crypt\Symmetric\SymmetricInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineEncryptionFactory extends AbstractFactory
{

    /**
     * Get the class name of the options associated with this factory.
     *
     * @return string
     */
    public function getOptionsClass()
    {
        return 'DoctrineEncryptModule\Options\Encryption';
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        /** @var \DoctrineEncryptModule\Options\Encryption $options */
        $options      = $this->getOptions($sl, 'encryption');

        $reader = $this->createReader($options->getReader(), $sl);
        $adapter = $this->createAdapter($options->getAdapter(), $sl);

        new DoctrineEncryptSubscriber(
            $reader,
            $adapter
        );
    }

    /**
     * @param $reader
     * @param ServiceLocatorInterface $sl
     * @return Reader
     * @throws \Doctrine\Common\Proxy\Exception\InvalidArgumentException
     */
    private function createReader($reader, ServiceLocatorInterface $sl)
    {
        $reader = $this->hydrdateDefinition($reader, $sl);

        if (!$reader instanceof Reader) {
            throw new InvalidArgumentException('Invalid reader provided. Must implement \Doctrine\Common\Annotations\Reader');
        }

        return $reader;
    }

    /**
     * @param $adapter
     * @param ServiceLocatorInterface $sl
     * @return \DoctrineEncryptModule\Encryptors\ZendSymmetricCryptAdapter
     * @throws \Doctrine\Common\Proxy\Exception\InvalidArgumentException
     */
    private function createAdapter($adapter, ServiceLocatorInterface $sl)
    {
        $adapter = $this->hydrdateDefinition($adapter, $sl);

        if ($adapter instanceof SymmetricInterface) {
            $adapter = new ZendSymmetricCryptAdapter($adapter);
        }

        if (!$adapter instanceof EncryptorInterface) {
            throw new InvalidArgumentException(
                'Invalid encryptor provided, must be a service name, '
                . 'class name, an instance, or method returning a Reprovinci\DoctrineEncrypt\Encryptors\EncryptorInterface'
            );
        }

        return $adapter;
    }

    /**
     * Hydrates the value into an object
     * @param $value
     * @param ServiceLocatorInterface $sl
     * @return object
     */
    private function hydrdateDefinition($value, ServiceLocatorInterface $sl)
    {
        if (is_string($value)) {
            if ($sl->has($value)) {
                $value = $sl->get($value);
            } elseif (class_exists($value)) {
                $value = new $value();
            }
        } else if (is_callable($value)) {
            $value = $value();
        }

        return $value;
    }
}
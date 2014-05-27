<?php

namespace DoctrineEncryptModule\Encryptors;


use Reprovinci\DoctrineEncrypt\Encryptors\EncryptorInterface;
use Zend\Crypt\Symmetric\SymmetricInterface;

/**
 * Provides a wrapper that allows classes implementing Zend\Crypt\Symmetric\SymmetricInterface
 * to be used to encrypt doctrine fields.
 */
class ZendSymmetricCryptAdapter implements EncryptorInterface
{
    /** @var SymmetricInterface */
    private $adapter;

    public function __construct(SymmetricInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Must accept data and return encrypted data
     */
    public function encrypt($data)
    {
        return $this->adapter->encrypt($data);
    }

    /**
     * Must accept data and return decrypted data
     */
    public function decrypt($data)
    {
        return $this->adapter->decrypt($data);
    }
}
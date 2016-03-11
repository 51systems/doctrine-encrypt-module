<?php

namespace DoctrineEncryptModule\Encryptors;

use DoctrineEncrypt\Encryptors\EncryptorInterface;
use Zend\Crypt\BlockCipher;

/**
 * Provides a wrapper that allows Zend Framework BlockCipher's to
 * to be used to encrypt doctrine fields.
 */
class ZendBlockCipherAdapter implements EncryptorInterface
{
    /** @var BlockCipher */
    private $adapter;

    public function __construct(BlockCipher $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Must accept data and return encrypted data
     */
    public function encrypt($data)
    {
        if (!is_string($data) || empty($data)) {
            return $data;
        }

        return $this->adapter->encrypt($data);
    }

    /**
     * Must accept data and return decrypted data
     */
    public function decrypt($data)
    {
        if (empty($data)) {
            return $data;
        }

        return $this->adapter->decrypt($data);
    }
}

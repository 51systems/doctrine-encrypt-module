<?php

namespace DoctrineEncryptModule\Options;


use Doctrine\Common\Annotations\Reader;
use Zend\Stdlib\AbstractOptions;

class Encryption extends AbstractOptions
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var mixed
     */
    private $adapter;

    /**
     * @param mixed $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function setReader($reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return \Doctrine\Common\Annotations\Reader
     */
    public function getReader()
    {
        return $this->reader;
    }
}
<?php

namespace DoctrineEncryptModule;

use DoctrineEncryptModule\Encryptors\ZendBlockCipherAdapter;

return array(
    // Factory mappings - used to define which factory to use to instantiate a particular doctrine
    // service type
    'doctrine_factories' => array(
        'encryption' => 'DoctrineEncryptModule\Service\DoctrineEncryptionFactory',
    ),

    'doctrine' => array(
        'encryption' => array(
            'orm_default' => array(
                'adapter' => ZendBlockCipherAdapter::class,
                'reader' => 'Doctrine\Common\Annotations\AnnotationReader',
            ),
        ),

        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'doctrine.encryption.orm_default',
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            ZendBlockCipherAdapter::class => \DoctrineEncryptModule\Factory\McryptAdapter::class,
        ),
    ),
);

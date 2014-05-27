<?php

namespace DoctrineEncryptModule;

return array(
    // Factory mappings - used to define which factory to use to instantiate a particular doctrine
    // service type
    'doctrine_factories' => array(
        'encryption' => 'DoctrineEncryptModule\Service\DoctrineCryptFactory'
    ),
);
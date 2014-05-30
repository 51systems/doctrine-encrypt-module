# Doctrine Encrypt Module
Package adds Doctrine Module support to doctrine-encrypt module

## Installation
Add `51systems/doctrine-encrypt-module` to your composer manifest.
```js
{
    "require": {
        "51systems/doctrine-encrypt-module": "1.*"
    }
}
```

## Configuration
Copy `doctrine-encrypt-module.global.php.dist` out of the config/ directory, rename it to `doctrine-encrypt-module.global.php`
and place it in your application config folder.

Modify the adapter anonymous to return the desired class to use for encryption. The returned class must either be a `Zend\Crypt\BlockCipher`
or implement `DoctrineEncrypt\Encryptors\EncryptorInterface`. References to other service locator keys
or FQN's are also acceptable.

## Usage
See https://github.com/51systems/doctrine-encrypt




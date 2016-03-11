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

Copy the file `config/doctrine-encrypt-module.local.php.dist` to your `config/autoload/` directory
and rename it to `config/doctrine-encrypt-module.local.php`.
Generate a encryption key and a salt and put it into your new local config file.

### Optional

If you  want to change the encryption algorithm or the annotation reader copy 
`doctrine-encrypt-module.global.php.dist` out of the config/ directory, rename it to `doctrine-encrypt-module.global.php`
and place it in your application config folder.

Modify the adapter anonymous to return the desired class to use for encryption. The returned class must either be a `Zend\Crypt\BlockCipher`
or implement `DoctrineEncrypt\Encryptors\EncryptorInterface`. References to other service locator keys
or FQN's are also acceptable.

## Usage
See https://github.com/51systems/doctrine-encrypt

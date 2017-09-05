# MjmlBundle

Bundle to use [MJML](https://mjml.io/) with Symfony.

## Installation

Download the bundle:

```bash
composer require notfloran/mjml-bundle
```

Enable the Bundle:

```php
<?php
// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new NotFloran\MjmlBundle\MjmlBundle(),
        );

        // ...
    }

    // ...
}
```

## Configuration

The MJML binary is configurable:

Example:

```yaml
mjml:
    bin: /opt/mjml # default:  mjml
```

## Usage

```php
$message = (new \Swift_Message('Hello Email'))
    ->setFrom('my-app@example.fr')
    ->setTo('me@example.fr')
    ->setBody(
        $this->get('notfloran.mjml')->render('mail/example.mjml.twig'),
        'text/html'
    )
;

$this->get('mailer')->send($message);
```

## License

[MjmlBundle](https://github.com/notFloran/mjml-bundle) is licensed under the [MIT license](LICENSE).
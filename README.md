# MjmlBundle

[![Latest Stable Version](https://poser.pugx.org/notfloran/mjml-bundle/v/stable.svg)](https://packagist.org/packages/notfloran/mjml-bundle)
[![Latest Unstable Version](https://poser.pugx.org/notfloran/mjml-bundle/v/unstable.svg)](https://packagist.org/packages/notfloran/mjml-bundle)

Bundle to use [MJML](https://mjml.io/) 3 and 4 with Symfony >= 3.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require notfloran/mjml-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require notfloran/mjml-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new NotFloran\MjmlBundle\MjmlBundle(),
        ];

        // ...
    }

    // ...
}
```

## Renderer

For the moment only one renderer is available, the binary renderer.

### Binary

Install [MJML](https://mjml.io)

```bash
$ npm install mjml
```

Then you need to update the configuration:

```yaml
# config/packages/mjml.yaml
mjml:
  renderer: binary # default: binary
  options:
    binary: '%kernel.project_dir%/node_modules/.bin/mjml' # default: mjml
    minify: true # default: false
    validation_level: skip # default: strict. See https://mjml.io/documentation/#validating-mjml
```

### Custom

First you must create a class which implements `NotFloran\MjmlBundle\Renderer\RendererInterface`, then declare it as a service.

And finally you have to change the configuration:

````yaml
# config/packages/mjml.yaml
mjml:
    renderer: 'service'
    options:
        service_id: 'App\Mjml\MyCustomRenderer'
````

### API

The bundle has no official integration with the [MJML API](https://mjml.io/api).

You can create your own integration by using [juanmiguelbesada/mjml-php](https://packagist.org/packages/juanmiguelbesada/mjml-php) and following this gist : https://gist.github.com/notFloran/ea6bab137be628f6a0c19054e08e6906.

## Usage

### Use "mjml" service

```twig
{# templates/mail/example.mjml.twig #}
<mjml>
    <mj-body>
            <mj-section>
                <mj-column>

                    <mj-image width="100px" src="https://mjml.io/assets/img/logo-small.png"></mj-image>

                    <mj-divider border-color="#F45E43"></mj-divider>

                    <mj-text font-size="20px" color="#F45E43" font-family="helvetica">
                        Hello {{ name }} from MJML and Symfony
                    </mj-text>

                </mj-column>
            </mj-section>
    </mj-body>
</mjml>
```

```php
$message = (new \Swift_Message('Hello Email'))
    ->setFrom('my-app@example.fr')
    ->setTo('me@example.fr')
    ->setBody(
        $this->get('mjml')->render(
            $this->get('twig')->render('templates/mail/example.mjml.twig', [
                'name' => 'Floran'
            ])
        ),
        'text/html'
    )
;

$this->get('mailer')->send($message);
```

### Use "mjml" twig tag


```twig
{# mail/example.mjml.twig #}
{% block email_content %}
    {% mjml %}
    <mjml>
        <mj-body>
                <mj-section>
                    <mj-column>

                        <mj-image width="100px" src="https://mjml.io/assets/img/logo-small.png"></mj-image>

                        <mj-divider border-color="#F45E43"></mj-divider>

                        <mj-text font-size="20px" color="#F45E43" font-family="helvetica">
                            Hello {{ name }} from MJML and Symfony
                        </mj-text>

                    </mj-column>
                </mj-section>
        </mj-body>
    </mjml>
    {% endmjml %}
{% endblock %}
```

```php
$message = (new \Swift_Message('Hello Email'))
    ->setFrom('my-app@example.fr')
    ->setTo('me@example.fr')
    ->setBody(
        $this->get('twig')->render('templates/mail/example.mjml.twig', [
            'name' => 'Floran'
        ]),
        'text/html'
    )
;

$this->get('mailer')->send($message);
```

## SwiftMailer integration

Declare the following service: 

```yaml
NotFloran\MjmlBundle\SwiftMailer\MjmlPlugin:
    tags: [swiftmailer.default.plugin]
```

Create a SwiftMailer message with a MJML body (without `{% mjml %}`) and with `text/mjml` as content-type:

```php
$message = (new \Swift_Message('Hello Email'))
    ->setFrom('send@example.com')
    ->setTo('recipient@example.com')
    ->setBody(
        $this->renderView('mail/example.mjml.twig'),
        'text/mjml'
    )

$mailer->send($message);
```

The plugin will automatically render the MJML body and replace the body with the rendered HTML.

In the case where a spool is used: the MJML content is save in the spool and render when the spool is flushed.

## License

[MjmlBundle](https://github.com/notFloran/mjml-bundle) is licensed under the [MIT license](LICENSE).

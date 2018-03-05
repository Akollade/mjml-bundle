# MjmlBundle

[![Latest Stable Version](https://poser.pugx.org/notfloran/mjml-bundle/v/stable.svg)](https://packagist.org/packages/notfloran/mjml-bundle)
[![Latest Unstable Version](https://poser.pugx.org/notfloran/mjml-bundle/v/unstable.svg)](https://packagist.org/packages/notfloran/mjml-bundle)


Bundle to use [MJML](https://mjml.io/) with Symfony 4.

## Installation

Download the bundle:

```bash
composer require notfloran/mjml-bundle
```

## Configuration

The MJML binary is configurable:

Example:

```yaml
# config/packages/notfloran_mjml.yaml
mjml:
    bin: '%kernel.project_dir%/node_modules/.bin/mjml' # default:  mjml
    mimify: true # default: false
```

## Usage

### Use service

```twig
{# templates/mail/example.mjml.twig #}
<mjml>
    <mj-body>
        <mj-container>
            <mj-section>
                <mj-column>

                    <mj-image width="100" src="https://mjml.io/assets/img/logo-small.png"></mj-image>

                    <mj-divider border-color="#F45E43"></mj-divider>

                    <mj-text font-size="20px" color="#F45E43" font-family="helvetica">
                        Hello {{ name }} from MJML and Symfony
                    </mj-text>

                </mj-column>
            </mj-section>
        </mj-container>
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

### Use twig tag


```twig
{# mail/example.mjml.twig #}
{% block email_content %}
    {% mjml %}
    <mjml>
        <mj-body>
            <mj-container>
                <mj-section>
                    <mj-column>

                        <mj-image width="100" src="https://mjml.io/assets/img/logo-small.png"></mj-image>

                        <mj-divider border-color="#F45E43"></mj-divider>

                        <mj-text font-size="20px" color="#F45E43" font-family="helvetica">
                            Hello {{ name }} from MJML and Symfony
                        </mj-text>

                    </mj-column>
                </mj-section>
            </mj-container>
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

## License

[MjmlBundle](https://github.com/notFloran/mjml-bundle) is licensed under the [MIT license](LICENSE).
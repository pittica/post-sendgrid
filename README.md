# Post SendGrid

[![LICENSE](https://img.shields.io/github/license/pittica/post-sendgrid.svg)](LICENSE)
[![packagist](https://img.shields.io/badge/packagist-pittica%2Fpost--sendgrid-brightgreen.svg)](https://packagist.org/packages/pittica/post-sendgrid)
![PHP from Packagist](https://img.shields.io/packagist/php-v/pittica/post-sendgrid)

This project uses SendGrid to send data from contact forms.

## Installation

You can install _post-sendgrid_ using [Composer](https://getcomposer.org).

``` bash
composer create-project --prefer-dist pittica/post-sendgrid
```

## Configuration

Create and edit a **config/app.php** file.

### Example

``` php
<?php

return [
    'fields' => [
        'whitelisted' => [
            'message'
        ],
        'email' => 'email',
        'subject' => 'subject',
        'name' => 'name',
        'labels' => [
            'message' => 'Message',
            'email' => 'E-Mail',
            'subject' => 'Subject'
        ]
    ],
    'sender' => [
        'address' => 'YOUR@EMAIL.ADDRESS',
        'name' => 'YOUR NAME'
    ],
	'api' => [
		'key' => 'SendGrid API KEY'
	],
    'recaptcha' => [
        'key' => 'RECAPTCHA KEY',
        'field' => 'g-recaptcha'
    ]
];
```

## Copyright

(c) 2020-2021, [Pittica S.r.l.s.](https://pittica.com).

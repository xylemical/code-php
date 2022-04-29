# PHP Code Writer

Code writer for PHP. 

## Install

The recommended way to install this library is [through composer](http://getcomposer.org).

```sh
composer require xylemical/code-php
```

## Usage

Example writer using twig (requires `xylemical/code-writer-twig`):

```php
<?php

use Xylemical\Code\Writer\Twig\TwigRender;

// Structure as created via xylemical/code documentation.
$class = ...;

$loader = new PhpTwigLoader();
$twig = new Environment($loader, ['debug' => TRUE]);
$twig->addExtension(new DebugExtension());
$twig->addExtension(new PhpTwigExtension());
$engine = new TwigRender($twig);

echo $engine->render($class);
```

## License

MIT, see LICENSE.

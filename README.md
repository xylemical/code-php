# Code Writer

Simple writer of code structures. 

## Install

The recommended way to install this library is [through composer](http://getcomposer.org).

```sh
composer require xylemical/code-writer
```

## Usage

Example writer:

```php
<?php

use Xylemical\Code\Writer\Twig\TwigRender;

// Structure as created via xylemical/code documentation.
$class = ...;

$loader = new FilesystemLoader("templates");
$twig = new Environment($loader, ['debug' => TRUE]);
$twig->addExtension(new DebugExtension());
$engine = new TwigRender($twig);

echo $engine->render($class);
```

## License

MIT, see LICENSE.

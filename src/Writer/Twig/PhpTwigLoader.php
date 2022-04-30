<?php

declare(strict_types=1);

namespace Xylemical\Code\Php\Writer\Twig;

use Twig\Loader\FilesystemLoader;

/**
 * Provides access to standard PHP twig templates.
 */
class PhpTwigLoader extends FilesystemLoader {

  /**
   * PhpLoader constructor.
   *
   * @param string|string[] $paths
   *   The path or paths for loading templates.
   * @param string|null $rootPath
   *   The root path.
   *
   * @throws \Twig\Error\LoaderError
   */
  public function __construct($paths = [], string $rootPath = NULL) {
    parent::__construct($paths, $rootPath);
    $this->addPath(__DIR__ . '/templates');
  }

}

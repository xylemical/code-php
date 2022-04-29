<?php

namespace Xylemical\Code\Php\Definition;

use Xylemical\Code\Definition\FilenameStrategyInterface;
use Xylemical\Code\FullyQualifiedName;

/**
 * Provides the filename strategy for the PSR-0 and PSR-4 project structures.
 */
class PsrFilenameStrategy implements FilenameStrategyInterface {

  /**
   * The base path for the project structure.
   *
   * @var string
   */
  protected string $base;

  /**
   * The base namespaces for the project structure.
   *
   * @var string[]
   */
  protected array $namespaces = [];

  /**
   * PsrFilenameStrategy constructor.
   *
   * @param string $base
   *   The base path.
   * @param array $namespaces
   *   The base namespaces.
   */
  public function __construct(string $base, array $namespaces = []) {
    $this->base = $base;
    $this->namespaces = $namespaces;
  }

  /**
   * {@inheritdoc}
   */
  public function getFilenames(FullyQualifiedName $name): array {
    $namespaces = $name->getNamespace();
    // Basic check to remove namespaces that match.
    foreach (array_values($this->namespaces) as $index => $namespace) {
      if ($namespaces[$index] !== $namespace) {
        throw new \OutOfBoundsException('FQCN cannot exist in given project structure.');
      }
    }

    $path = array_merge(
      explode('/', trim($this->base, '/')),
      array_slice($namespaces, count($this->namespaces)),
      [$name->getName() . '.php']
    );

    return [implode('/', $path)];
  }

}

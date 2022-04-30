<?php

declare(strict_types=1);

namespace Xylemical\Code\Php\Writer\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Xylemical\Code\Definition\File;
use Xylemical\Code\FullyQualifiedName;

/**
 * Provides extensions to twig that support PHP.
 */
class PhpTwigExtension extends AbstractExtension {

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new TwigFilter('normalize', [$this, 'doNormalize']),
      new TwigFilter('imports', [$this, 'doImports']),
    ];
  }

  /**
   * Normalize a name consistently.
   *
   * @return string
   *   The normalized name.
   */
  public function doNormalize(string $name): string {
    return preg_replace('/[^\w\d_\\\\]/', '_', $name);
  }

  /**
   * Generate the imports.
   *
   * @param \Xylemical\Code\Definition\File $file
   *   The file.
   *
   * @return \Xylemical\Code\FullyQualifiedName[]
   *   The import names.
   */
  public function doImports(File $file): array {
    $local = [];
    $remote = [];

    // Separate into local names (same namespace) and imports.
    $namespace = $file->getNamespace();
    foreach ($file->getNameManager()->all() as $name) {
      if ($namespace == $name->getNamespace()) {
        $local[$name->getName()] = TRUE;
      }
      else {
        $remote[] = $name;
      }
    }

    // Process each import to figure out a good alias name.
    $imports = [];
    foreach ($remote as $name) {
      $alias = $this->getUniqueAlias($local, $imports, $name);
      $imports[$alias] = $name->setShorthand($alias);
    }

    return array_values($imports);
  }

  /**
   * Get a unique alias from local and imports.
   *
   * @param array $local
   *   The local name.
   * @param array $imports
   *   The imports.
   * @param \Xylemical\Code\FullyQualifiedName $name
   *   The full name.
   *
   * @return string
   *   The alias.
   */
  protected function getUniqueAlias(array $local, array $imports, FullyQualifiedName $name): string {
    $full = explode($name->getSeparator() ?: '\\', $name->getFullName());
    $parts = [];
    do {
      array_unshift($parts, array_pop($full));
      $part = implode('', $parts);
      if (!isset($local[$part]) && !isset($imports[$part])) {
        return $part;
      }
    } while (count($full));

    // Lowest level matches already something.
    $full = implode('', $parts);
    $addition = '';
    while (isset($local[$full . $addition]) || isset($imports[$full . $addition])) {
      $addition = intval($addition) + 1;
    }
    return $full . $addition;
  }

}

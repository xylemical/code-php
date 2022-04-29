<?php

namespace Xylemical\Code\Php\Writer\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

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

}

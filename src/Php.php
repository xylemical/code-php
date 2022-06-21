<?php

declare(strict_types=1);

namespace Xylemical\Code\Php;

use Xylemical\Code\Util\Indenter;
use function var_export;

/**
 * Provides helper routines for PHP.
 */
class Php {

  /**
   * Provides a sanitized version of var_export().
   *
   * @param mixed $value
   *   The value to export.
   *
   * @return string
   *   The exported value.
   */
  public static function export(mixed $value): string {
    if (is_array($value)) {
      if (count($value)) {
        $output = "";
        foreach ($value as $key => $item) {
          $output .= var_export($key, TRUE) . " => " . static::export($item) . ",\n";
        }
        $output = Indenter::indent($output);
        return "[\n" . $output . ']';
      }
      return '[]';
    }
    return var_export($value, TRUE);
  }

}

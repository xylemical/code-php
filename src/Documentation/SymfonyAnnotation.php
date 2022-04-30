<?php

declare(strict_types=1);

namespace Xylemical\Code\Php\Documentation;

use Xylemical\Code\DocumentationInterface;
use Xylemical\Code\Util\Indenter;

/**
 * Provides a symfony style annotation.
 */
class SymfonyAnnotation extends Annotation {

  /**
   * {@inheritdoc}
   */
  public function getContents(): string {
    $output = '@' . $this->annotation;
    if (isset($this->value)) {
      $output .= '(' . $this->export($this->value) . ')';
    }
    return $output;
  }

  /**
   * Provides the value as an exportable php variable.
   *
   * @param mixed $value
   *   The value.
   *
   * @return string
   *   The exported variable.
   */
  protected function export(mixed $value): string {
    if (is_array($value)) {
      $output = "{\n";
      foreach ($value as $key => $item) {
        $output .= '  ' . var_export($key, TRUE) . ' = ';
        $output .= Indenter::indent($this->export($item)) . ",\n";
      }
      $output .= "}";
      return $output;
    }
    elseif (is_object($value)) {
      if ($value instanceof DocumentationInterface) {
        return $value->getContents();
      }
      return (string) $value;
    }
    return var_export($value, TRUE);
  }

}

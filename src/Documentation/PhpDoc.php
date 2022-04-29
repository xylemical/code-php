<?php

namespace Xylemical\Code\Php\Documentation;

use Xylemical\Code\DocumentationInterface;

/**
 * A PHP Documentation.
 */
class PhpDoc implements DocumentationInterface {

  /**
   * The short comment.
   *
   * @var string
   */
  protected string $short = '';

  /**
   * The long descriptive comment.
   *
   * @var string
   */
  protected string $description = '';

  /**
   * The annotations associated with the documentation.
   *
   * @var \Xylemical\Code\Php\Documentation\Annotation[]
   */
  protected array $annotations = [];

  /**
   * {@inheritdoc}
   */
  public function getContents(): string {
    $output = '';
    if ($this->short) {
      $output .= "{$this->short}\n";
    }

    // Process the long description.
    if ($this->description) {
      if ($output) {
        $output .= "\n";
      }
      $output .= $this->description;
    }

    // Process each of the annotations.
    foreach ($this->annotations as $annotation) {
      if ($output) {
        $output .= "\n";
      }
      $output .= $annotation->getContents();
    }

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->getContents() === '';
  }

}

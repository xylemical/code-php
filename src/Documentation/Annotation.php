<?php

namespace Xylemical\Code\Php\Documentation;

/**
 * Provides the php doc annotation.
 */
class Annotation {

  /**
   * The annotation.
   *
   * @var string
   */
  protected string $annotation = '';

  /**
   * The value of the annotation.
   *
   * @var mixed
   */
  protected mixed $value;

  /**
   * The description of the annotation.
   *
   * @var string
   */
  protected string $description = '';

  /**
   * Annotation constructor.
   *
   * @param string $annotation
   *   The php doc annotation.
   */
  public function __construct(string $annotation) {
    $this->annotation = $annotation;
  }

  /**
   * Get the contents of the annotation.
   *
   * @return string
   *   The tag.
   */
  public function getContents(): string {
    $output = '@' . $this->annotation;
    if (isset($this->value)) {
      $output .= ' ' . $this->value;
    }
    if ($this->description) {
      $output .= "\n" . $this->description;
    }
    return $output;
  }

  /**
   * Check if the annotation has a value.
   *
   * @return bool
   *   The result.
   */
  public function hasValue(): bool {
    return isset($this->value);
  }

  /**
   * Get the annotation value.
   *
   * @return mixed|null
   *   The value.
   */
  public function getValue() {
    return $this->value ?? NULL;
  }

  /**
   * Set the value of the annotation.
   *
   * @param mixed $value
   *   The value.
   *
   * @return $this
   */
  public function setValue(mixed $value): static {
    $this->value = $value;
    return $this;
  }

  /**
   * Remove the annotation value.
   *
   * @return $this
   */
  public function removeValue(): static {
    unset($this->value);
    return $this;
  }

  /**
   * Check if the annotation has a description.
   *
   * @return bool
   *   The result.
   */
  public function hasDescription(): bool {
    return isset($this->description);
  }

  /**
   * Get the annotation description.
   *
   * @return string
   *   The description.
   */
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * Set the description of the annotation.
   *
   * @param string $description
   *   The description.
   *
   * @return $this
   */
  public function setDescription(string $description): static {
    $this->description = $description;
    return $this;
  }

  /**
   * Remove the annotation description.
   *
   * @return $this
   */
  public function removeDescription(): static {
    unset($this->description);
    return $this;
  }

}

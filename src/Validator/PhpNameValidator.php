<?php

declare(strict_types=1);

namespace Xylemical\Code\Php\Validator;

use Xylemical\Code\Definition\ElementInterface;
use Xylemical\Code\Definition\StructureInterface;
use Xylemical\Code\DefinitionInterface;
use Xylemical\Code\NamedInterface;
use Xylemical\Code\Validator\AbstractValidator;

/**
 * Provides a validator for a php name.
 */
class PhpNameValidator extends AbstractValidator {

  /**
   * PHP keywords.
   *
   * @var string[]
   */
  protected array $keywords = [
    'in',
    'as',
    'object',
    'string',
    'int',
    'bool',
    'double',
    'float',
    'array',
    'foreach',
    'while',
    'do',
    'until',
    'public',
    'protected',
    'private',
    'function',
    'class',
    'interface',
    'trait',
    'extends',
    'implements',
    'namespace',
    'use',
    'if',
    'elseif',
    'else',
    'match',
    'return',
  ];

  /**
   * {@inheritdoc}
   */
  public function applies(DefinitionInterface $definition): bool {
    return $definition instanceof NamedInterface;
  }

  /**
   * {@inheritdoc}
   */
  public function validate(DefinitionInterface $definition): static {
    if ($definition instanceof StructureInterface) {
      $separator = $definition->getFullyQualifiedName()->getSeparator();
      $name = $definition->getFullyQualifiedName()->getFullName();
      $this->checkNames($definition, $name, $separator);
    }
    elseif ($definition instanceof ElementInterface) {
      // @todo This needs to be properly added to the elementInterface (separator).
      $this->checkNames($definition, $definition->getName(), '\\');
    }
    return $this;
  }

  /**
   * Check names are valid for names.
   *
   * @param \Xylemical\Code\DefinitionInterface $definition
   *   The definition.
   * @param string $name
   *   The names.
   * @param string $separator
   *   The separator.
   */
  protected function checkNames(DefinitionInterface $definition, string $name, string $separator): void {
    foreach (explode($separator ?: '\\', $name) as $name) {
      // Keyword check.
      if (in_array(strtolower($name), $this->keywords)) {
        $this->addError($definition, 'Name cannot be a keyword.');
      }

      // Correctness check.
      if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $name)) {
        $this->addError($definition, 'Name is not valid.');
      }
    }
  }

}

<?php

namespace Xylemical\Code\Php\Writer\Twig;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Xylemical\Code\Code;
use Xylemical\Code\Definition\Method;
use Xylemical\Code\Expression;
use Xylemical\Code\Language;
use Xylemical\Code\NameManager;
use Xylemical\Code\Writer\TestWriterCase;
use Xylemical\Code\Writer\Twig\TwigWriter;

/**
 * Tests \Xylemical\Code\Php\Writer\PhpTwigExtension.
 */
class PhpTwigLoaderTest extends TestWriterCase {

  /**
   * Get the twig rendering engine.
   *
   * @return \Xylemical\Code\Writer\Twig\TwigWriter
   *   The engine.
   */
  protected function getEngine(): TwigWriter {
    $loader = new PhpTwigLoader();
    $twig = new Environment($loader, ['debug' => TRUE]);
    $twig->addExtension(new DebugExtension());
    $twig->addExtension(new PhpTwigExtension());
    return new TwigWriter($twig);
  }

  /**
   * Tests templates.
   */
  public function testTwigTemplateEngine(): void {
    $path = realpath(__DIR__ . '/../../../fixtures/twig');
    $engine = $this->getEngine();

    // Ensure the twig template engine works for all the different variables.
    foreach ($this->getSources($path) as $source => $destination) {
      $manager = new NameManager(new Language());
      $result = $engine->write(include $source);
      $this->assertEquals(file_get_contents($destination), $result, 'Comparing ' . basename($source, '.inc'));
    }
  }

  /**
   * Test expression with code outputs correctly.
   */
  public function testExpression(): void {
    $engine = $this->getEngine();

    $array = [
      'Test' => 'Value',
    ];
    $expression = new Expression(new Code('php', var_export($array, TRUE)));

    $expected = <<<EOF
array (
  'Test' => 'Value',
)
EOF;

    $this->assertEquals($expected, $engine->write($expression));
  }

  /**
   * Tests a method output.
   */
  public function testMethod(): void {
    $engine = $this->getEngine();
    $manager = new NameManager(new Language());

    $array = [
      'Test' => 'Value',
    ];
    $expression = new Expression(new Code('php', var_export($array, TRUE)));
    $method = new Method('test', $manager);
    $method->setValue($expression);

    $expected = <<<EOF

public function test() {
    array (
      'Test' => 'Value',
    )
}

EOF;

    $this->assertEquals($expected, $engine->write($method));

  }

}

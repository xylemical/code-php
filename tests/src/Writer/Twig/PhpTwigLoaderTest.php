<?php

namespace Xylemical\Code\Php\Writer\Twig;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Xylemical\Code\Writer\TestWriterCase;
use Xylemical\Code\Writer\Twig\TwigWriter;

class PhpTwigLoaderTest extends TestWriterCase {

  public function testTwigTemplateEngine() {
    $path = realpath(__DIR__ . '/../../../fixtures/twig');
    $loader = new PhpTwigLoader();
    $twig = new Environment($loader, ['debug' => TRUE]);
    $twig->addExtension(new DebugExtension());
    $twig->addExtension(new PhpTwigExtension());
    $engine = new TwigWriter($twig);

    // Ensure the twig template engine works for all the different variables.
    foreach ($this->getSources($path) as $source => $destination) {
      $result = $engine->write(include $source);
      $this->assertEquals(file_get_contents($destination), $result, 'Comparing ' . basename($source, '.inc'));
    }
  }
}

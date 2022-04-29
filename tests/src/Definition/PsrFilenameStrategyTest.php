<?php

namespace Xylemical\Code\Php\Definition;

use PHPUnit\Framework\TestCase;
use Xylemical\Code\FullyQualifiedName;

class PsrFilenameStrategyTest extends TestCase {

  public function testStrategyPsr0() {
    $strategy = new PsrFilenameStrategy('src');

    $name = new FullyQualifiedName('Test\\Code');
    $this->assertEquals(['src/Test/Code.php'], $strategy->getFilenames($name));
  }

  public function testStrategyPsr4() {
    $strategy = new PsrFilenameStrategy('src', ['Test']);

    $name = new FullyQualifiedName('Test\\Code');
    $this->assertEquals(['src/Code.php'], $strategy->getFilenames($name));
  }

  public function testStrategyPsr4OutOfBounds() {
    $strategy = new PsrFilenameStrategy('src', ['Dummy']);

    $name = new FullyQualifiedName('Test\\Code');
    $this->expectException(\OutOfBoundsException::class);
    $strategy->getFilenames($name);
  }

}

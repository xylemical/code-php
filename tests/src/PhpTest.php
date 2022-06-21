<?php

declare(strict_types=1);

namespace Xylemical\Code\Php;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Code\Php\Php.
 */
class PhpTest extends TestCase {

  /**
   * Tests the var_export functionality.
   */
  public function testExport(): void {
    $this->assertEquals('NULL', Php::export(NULL));
    $this->assertEquals('0', Php::export(0));
    $this->assertEquals('1', Php::export(1));
    $this->assertEquals('-1', Php::export(-1));
    $this->assertEquals('1.0', Php::export(1.0));
    $this->assertEquals('[]', Php::export([]));

    $array = ['name' => 'foo'];
    $this->assertEquals("[\n  'name' => 'foo',\n]", Php::export($array));
    $array = [['name' => 'foo']];
    $this->assertEquals("[\n  0 => [\n    'name' => 'foo',\n  ],\n]", Php::export($array));
  }

}

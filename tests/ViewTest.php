<?php

/**
 * View Test
 *
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
  
  private $fixturePath = '';
  private $templatePath = '';

  function setUp()
  {
    parent::setUp();
    $this->fixturePath = dirname(__FILE__) . DS . 'fixtures' . DS;
    $this->templatePath = $this->fixturePath . DS . 'templates' . DS;
  }

  public function testCreateObject()
  {
    $template = $this->templatePath . 'page.php';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($template, $variables);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }
}

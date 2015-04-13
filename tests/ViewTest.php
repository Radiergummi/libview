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
    View::setTemplateDir($this->templatePath);
    $template = $this->templatePath . 'page.php';
    $obj = new Radiergummi\Libview\View($template);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }

  public function testCreateObjectWithVariables()
  {
    View::setTemplateDir($this->templatePath);
    $template = $this->templatePath . 'page.php';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($template, $variables);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }

  public function testRenderView()
  {
    View::setTemplateDir($this->templatePath);
    $template = $this->templatePath . 'page.php';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($template, $variables);
    $output = $obj->render();

    $this->assertInternalType('string', $output);
  }

  public function testRenderViewContainsVariable()
  {
    View::setTemplateDir($this->templatePath);
    $template = $this->templatePath . 'page.php';
    $variables = array('a' => 'foo');
    $obj = new Radiergummi\Libview\View($template, $variables);
    $output = $obj->render();

    $this->assertNotFalse(strpos($output, 'foo'));
  }
}

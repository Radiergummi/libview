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
    $this->templatePath = $this->fixturePath . DS . 'templates';
  }

  public function testCreateObject()
  {
    Radiergummi\Libview\View::setTemplateDir($this->templatePath);
    $template = 'page';
    $obj = new Radiergummi\Libview\View($template);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }

  public function testCreateObjectWithVariables()
  {
    Radiergummi\Libview\View::setTemplateDir($this->templatePath);
    $template = 'page';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($template, $variables);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }

  public function testRenderView()
  {
    Radiergummi\Libview\View::setTemplateDir($this->templatePath);
    $template = 'page';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($template, $variables);
    $output = $obj->render();

    $this->assertInternalType('string', $output);
  }

  public function testRenderViewContainsVariable()
  {
    Radiergummi\Libview\View::setTemplateDir($this->templatePath);
    $template = 'page';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($template, $variables);
    $output = $obj->render();
    echo $output;
    $this->assertNotFalse(strpos($output, 'foo'));
  }
}

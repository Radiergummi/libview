<?php

/**
 * View Test
 *
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
  
  private $fixturePath = '';
  private $viewPath = '';

  function setUp()
  {
    parent::setUp();
    $this->fixturePath = dirname(__FILE__) . DS . 'fixtures' . DS;
    $this->viewPath = $this->fixturePath . DS . 'views';
  }

  public function testCreateObject()
  {
    Radiergummi\Libview\View::setviewDir($this->viewPath);
    $view = 'page';
    $obj = new Radiergummi\Libview\View($view);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }

  public function testCreateObjectWithVariables()
  {
    Radiergummi\Libview\View::setviewDir($this->viewPath);
    $view = 'page';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($view, $variables);
    
    $this->assertInstanceOf('Radiergummi\Libview\View', $obj);
  }

  public function testRenderView()
  {
    Radiergummi\Libview\View::setviewDir($this->viewPath);
    $view = 'page';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($view, $variables);
    $output = $obj->render();

    $this->assertInternalType('string', $output);
  }

  public function testRenderViewContainsVariable()
  {
    Radiergummi\Libview\View::setviewDir($this->viewPath);
    $view = 'page';
    $variables = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
    $obj = new Radiergummi\Libview\View($view, $variables);
    $output = $obj->render();

    $this->assertNotFalse(strpos($output, 'foo'));
  }
}

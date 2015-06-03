<?php
// to use this library in your app, feel free to change this to namespace <Vendor>\<package>.
namespace Radiergummi\libview;

/**
 * General purpose view class
 * 
 * @package libview
 * @author Moritz Friedrich <m@9dev.de>
 */
class View
{
	/**
	 * holds the current view
	 * 
	 * @var string
	 */
	private $view = '';


	/**
	 * holds the view variables
	 * 
	 * @var array
	 */
	private $variables = array();


	/**
	 * the default path to the view directory, shared among all views
	 * 
	 * @var string
	 */
	public static $viewDir = '';


	/**
	 * Constructor
	 * 
	 * @param string $view  the view file to work with
	 * @param array $variables (optional)  the variables to replace in the view
	 * @param string $viewDir (optional)  a custom view directory for this view
	 * @param string $defaultview (optional)  a fallback view in case the spicified isn't to be found
	 */
	public function __construct($view, array $variables = array())
	{
			$this->view = $view;
			$this->variables = $variables;
	}


	/**
	 * Sets a custom view directory
	 * 
	 * @param string $viewDir  a custom view directory for this view
	 */
	public static function setviewDir($viewDir)
	{
		static::$viewDir = $viewDir;
	}


	/**
	 * Adds a partial view as a variable to the parent view
	 * 
	 * @param string $name  the variable name to use
	 * @param string $view  the view file for the partial
	 * @param array $variables (optional)  the view variables to use within the partial
	 * 
	 * @return object $this for chaining
	 */
	public function partial($name, $view, array $variables = array())
	{
		$this->variables[$name] = (new View($view, $variables))->render();
		return $this;
	}


	/**
	 * Sets a variable for the view
	 * 
	 * @param string $name  the variable name to use
	 * @param mixed $value  the view file for the partial
	 */
	public function set($name, $value)
	{
		$this->variables[$name] = $value;
	}


	/**
	 * Merges the variable array with another given one
	 * 
	 * @param array $values  the view variables array to merge
	 */
	public function mergeVariables(array $values)
	{
		$this->variables = array_merge($this->variables, $values);
	}


	/**
	 * Retrieve the view directory
	 * 
	 * @return the full path to the view directory
	 */
	private function getviewPath()
	{
		return (empty(self::$viewDir)
			? dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR
			: rtrim(self::$viewDir, '/') . DIRECTORY_SEPARATOR
		);
	}


	public function render()
	{
		// start collecting the output
		ob_start();

		// make the variables available in the view
		extract($this->variables);
		
		// include the theme functions file, if any
		if (is_readable($theme_functions = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'theme_functions.php')) require_once $theme_functions;

		// require the actual view
		require $this->getviewPath() . $this->view . '.php';

		// returb the collected output
		return ob_get_clean();
	}
}

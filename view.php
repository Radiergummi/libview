<?php
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
	 * holds the current template
	 * 
	 * @var string
	 */
	private $template = '';


	/**
	 * holds the template variables
	 * 
	 * @var array
	 */
	private $variables = array();


	/**
	 * the default path to the template directory, shared among all views
	 * 
	 * @var string
	 */
	public static $templateDir = '';


	/**
	 * the default (fallback) template to use, shared among all views
	 * 
	 * @var string
	 */
	public static $defaultTemplate = '';


	/**
	 * Constructor
	 * 
	 * @param string $template  the template file to work with
	 * @param array $variables (optional)  the variables to replace in the template
	 * @param string $templateDir (optional)  a custom template directory for this view
	 * @param string $defaultTemplate (optional)  a fallback template in case the spicified isn't to be found
	 */
	public function __construct($template, array $variables = array(), $templateDir = '', $defaultTemplate = '')
	{
			$this->template = $template;
			$this->variables = $variables;
			static::$templateDir = (isset($templateDir))
			    ? $templateDir
			    : dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR
			);
			static::$defaultTemplate = (isset($defaultTemplate))
			    ? $defaultTemplate
			    : 'page'
			);
	}


	/**
	 * Sets a custom template directory
	 * 
	 * @param string $templateDir  a custom template directory for this view
	 */
	public function setTemplateDir($templateDir)
	{
		static::$templateDir = $templateDir;
	}


	/**
	 * Sets a default template
	 * 
	 * @param string $defaultTemplate  a fallback template in case the spicified isn't to be found
	 */
	public function setdefaultTemplate($defaultTemplate)
	{
		static::$defaultTemplate = $defaultTemplate;
	}


	/**
	 * Adds a partial view as a variable to the parent template
	 * 
	 * @param string $name  the variable name to use
	 * @param string $template  the template file for the partial
	 * @param array $variables (optional)  the template variables to use within the partial
	 */
	public function partial($name, $template, array $variables = array())
	{
		$this->variables[$name] = (new View($template, $variables))->render();
	}


	/**
	 * Sets a variable for the template
	 * 
	 * @param string $name  the variable name to use
	 * @param mixed $value  the template file for the partial
	 */
	public function set($name, $value)
	{
		$this->variables[$name] = $value;
	}


	/**
	 * Merges the variable array with another given one
	 * 
	 * @param array $values  the template variables array to merge
	 */
	public function mergeVariables(array $values)
	{
		$this->variables = array_merge($this->variables, $values);
	}


	public function render()
	{
		// start collecting the output
		ob_start();

		// make the variables available in the template
		extract($this->variables);
		
		// include the theme functions file, if any
		if (is_readable($theme_functions = PATH . 'theme_functions.php')) include $theme_functions;

		// require the actual template
		if (is_readable($this->template)) {
		    require $this->templateDir . $this->template . '.php';
		} else {
		    require $this->templateDir . static::$defaultTemplate . '.php';
		}

		// returb the collected output
		return ob_get_clean();
	}
}

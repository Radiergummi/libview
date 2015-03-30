<?
// enable these if you intend to use this library in its own namespace!
# namespace View;
# 

/**
 * General purpose view class
 * 
 * @package libview
 * @author Moritz Friedrich <m@9dev.de>
 */
class View {
	/**
	 * holds the current template
	 * 
	 * @var string
	 */
	private $template = '';


	/**
	 * holds the template variables
	 * 
	 * @var string
	 */
	private $variables = '';


	/**
	 * the path to the current file (change this to whatever suits you)
	 * 
	 * @var string
	 */
	const PATH = dirname(__FILE__) . DIRECTORY_SEPARATOR;


	/**
	 * Constructor
	 * 
	 * @param string $template  the template file to work with
	 * @param array $variables (optional)  the variables to replace in the template
	 */
	public function __construct(string $template, array $variables = array()) {
			$this->template = $template;
			$this->variables = $variables;
	}


	/**
	 * Adds a partial view as a variable to the parent template
	 * 
	 * @param string $name  the variable name to use
	 * @param string $template  the template file for the partial
	 * @param array $variables (optional)  the template variables to use within the partial
	 */
	public function partial(string $name, string $template, array $variables = array()) {
		$this->variables[$name] = new View($template, $variables);
	}


	/**
	 * Sets a variable for the template
	 * 
	 * @param string $name  the variable name to use
	 * @param mixed $value  the template file for the partial
	 */
	public function set(string $name, mixed $value) {
		$this->variables[$name] = $value;
	}


	public function render() {
		// start collecting the output
		ob_start();

		// make the variables available in the template
		extract($this->variables);
		
		// include the theme functions file, if any
		if (is_readable($theme_functions = PATH . 'theme_functions.php')) include $theme_functions;

		// require the actual template
		require $this->template_dir . $this->template . '.php';

		// returb the collected output
		return ob_get_clean();
	}
}

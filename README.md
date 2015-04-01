# libview
Easy library to create views from templates. This is a PHP template engine, which means it's fast, reliable and simple.

*Please note:* This is heavily inspired by the fantastic [nano framework by rwarasaurus](https://github.com/rwarasaurus/nano/).
&nbsp;
&nbsp;


## Features
- Pure PHP
- Partials (sub-templates)
- Separately defined template variables and functions
- No external dependencies
- Small as hell (26 SLOC currently)
&nbsp;
&nbsp;


## Philosophy
There are people who claim pure PHP being too complicated for designers and advocate for template engines like Smarty instead. If you belong to those and are still reading this, please consider the points made [here](http://www.bigsmoke.us/php-templates/smarter-sans-smarty). I think learning an additional template syntax to replace basic PHP structure is just too much overhead, both in transmission and learning effort.  
&nbsp;
&nbsp;


## Usage
To create a basic view, construct a new one:
```php
$page = new View('page');
```
Now `$page` holds the html/php output ready to ship to the client. To make this work, we supply the object with a template name (*page* in this case) which it looks for in a subfolder named `templates`. I assume however you will make that suit your app.  
The template itself can contain regular PHP and HTML.
&nbsp;

### Template Variables
Now a template without dynamic content would be pretty pointless after all. Therefore, we can construct our view like this:
```php
$variables = array('welcomeMessage' => 'Hi there!', 'assetPath' => '/main/assets');
$page = new View('page', $variables);
```
The template file `templates/page.php` could look like this:
```php
// ...
  <head>
  <title>test</test>
  <link href="<? echo $assetPath; ?>/style.css" rel="stylesheet" />
  </head>
  <body>
    <h1><? echo $welcomeMessage; ?></h1>
// ...
```
&nbsp;

### Template functions
Sometimes, variables are just not enough and you need a function for a specific task within your templates. To supply these, create a file named `theme_functions.php` in your apps folder (*Not* within the templates folder). Libview will check for it and pass the content to the template. Just think of *not* adding a namespace to it: That way, you can easily use the functions in it by their name.  

Example:  
`theme_functions.php`
```php
<?
/**
 * returns a relative path to the asset folder for HTML links and optionally appends an element.
 *
 * @param string $append (optional)  append the given string to the path.
 */
function asset(string $append = ''){
  return (empty($append) ? '/main/assets/' : '/main/assets/' . ltrim($append, '/'));
}
```
&nbsp;

`templates/page.php`
```php
// ...
  <link href="<? echo asset('css/base/page.css'); ?>" rel="stylesheet" />
// ...
```
&nbsp;

### Combining to String output
If you are done with the view, just run `render()`on it: That will return a string ready for output (See below for details).
&nbsp;

### Methods
Libview provides several methods to prepare your View. More on them below:
&nbsp;

##### partial
To get a sub-template into your view, eg. a footer or header, create a partial:
```php
$page = new View('page', $variables);
$page
  ->partial('header', 'template-header', $headerVariables)
  ->partial('footer', 'template-footer', $footerVariables);
```
In your template, you can just insert a `<? echo $header ?>` and the parsed content of the file `templates/template-header.php` will appear. You also can (but don't have to) supply template variables to the partial.  
&nbsp;  
&nbsp;  

##### set
To add a new template variable at some point, use `set`:
```php
$page = new View('page', $variables);
$page->set('foo', 'bar');
```
&nbsp;  
&nbsp;  

##### mergeVariables
To add multiple new template variables at some point, use `mergeVariables`:
```php
$page = new View('page', $variables);
$page->mergeVariables(array('port' => 8080, 'ssl' => true, 'db' => $handle));
```
This will merge the existing array with the new one, which means that variables of the same name will be overwritten.  
&nbsp;  
&nbsp;  

##### render
If a template is ready to dispatch, the whole thing needs to be rendered into a string:
```php
$page = new View('page', $variables);
$response = $page->render();

// do some voodoo stuff
echo $response;
```
`render` will return a string you can work with and finally echo out to the client.
&nbsp;  
&nbsp;  

##### setDefaultTemplate
To set a default template in case the one specified cannot be found, use `setDefaultTemplate`:
```php
$page = new View('home', $variables);
$page->setDefaultTemplate('page');
```
The default template is static, meaning it is shared among all views from now on so you don't have to set it each time.
&nbsp;  
&nbsp;  

##### setTemplateDir
To set a default template directory, use `setTemplateDir`:
```php
$page = new View('home', $variables);
$page->setTemplateDir('public/templates');
```
The template directory is static, meaning it is shared among all views from now on so you don't have to set it each time.
&nbsp;  
&nbsp;  



&nbsp;  
&nbsp;  
## TODO
#### Bugs
- None known yet

#### Improvements
- The view could be sandboxed a bit.
- Libview should be unit tested, unfortunately, I've never done tests using PHPunit and need help with it.

#### Features
- ?
 
&nbsp;  
&nbsp;  
## How to contribute
I would love to see other people contribute their ideas to this project. However to ease the process, please keep the following in mind:  
- If you find a bug, please create an issue for it, tag the issue with *bug* and include the code to reproduce it.
- If you want to request or discuss a feature, please create an issue for it, tag it with *enhancement* and discribe it as detailed as possible.
- If you want to contribute actual code, please fork the repository, create a new branch in your fork (eg. *feature-ini-support*), make your changes in it, and create a pull request. 

Thank you!

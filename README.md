# libview
Easy library to create views from templates. This is a PHP template engine, which means it's fast, reliable and simple.

*Please note:* This is heavily inspired by the fantastic [nano framework by rwarasaurus](https://github.com/rwarasaurus/nano/). I just made it a little more modular and simpler to use.

## Philosophy
There are people who claim pure PHP being too complicated for designers and advocate for template engines like Smarty instead. If you belong to those and are still reading this, please consider the points made [here](http://www.bigsmoke.us/php-templates/smarter-sans-smarty). I think learning an additional template syntax to replace basic PHP structure is just too much overhead, both in transmission and learning effort.  
&nbsp;
&nbsp;


## Usage
To create a basic view, construct a new one:
```php
$page = new View('page');
```
Now `$page` holds the html/php output ready to ship to the client - you can just `echo` it. To make this work, we supply the object with a template name (*page* in this case) which it looks for in a subfolder named `templates`. I assume however you will make that suit your app.  
The template itself can contain regular PHP and HTML.

### Variables
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

### Functions
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

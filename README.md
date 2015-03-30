# libview
Easy library to create views from templates. This is a PHP template engine, which means it's fast, reliable and simple.

*Please note:* This is heavily inspired by the fantastic [nano framework by rwarasaurus](https://github.com/rwarasaurus/nano/). I just made it a little more modular and simpler to use.

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
    <h1><? echo $welcomeMessage ?></h1>
// ...
```

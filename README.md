# About Vengi
Vengi is a simple Template Engine for PHP. With vengi you can create your layouts and views in a simple and practical way, vengi is designed for small projects that are looking for something light, and easy to use and understand.

## Installation
You can add this Library via composer.

    composer require vengi/vengi

## Usage
Include the autoload.php:

    require_once('vendor/autoload.php');

Add Vengi: 

    use Vengi\Vengi;
    use Vengi\View;

Config work folders:

    Vengi::views(__DIR__.'/views'); // Set views path.
    Vengi::layouts(__DIR__.'/views/layouts'); // Set layouts path.

Note: By default, if you don't define the layouts path, the views/layouts path will be taken.

### Set and Get Views

Define the view to use.

    View::set('home'); 

Get the view at index.

    View::get();

### Layout – Sets the content area.

On the layout, add the following to define the main content area.

    @{_Content_}@

### Layouts and Views.

To write php code without using the opening and closing tags in views and layouts, use {{ }} instead.

    {{ //php code }} // This is equivalent to, <?php //php code ?>.

To do an echo.

    {= 'Hello World' }} // This is equivalent to, <?= 'Hello World' ?>.

### In the Views.

Once you have created the layouts or components to use (Note: components must not have @{_Content_}@, because it is not a layout), to add the layouts or components to the view, do the following:

Add the header of a selected layout.

    {{ Layout::set('main.layout')->header() }}

Add the footer of a selected layout.

    {{ Layout::set('main.layout')->footer() }}

Add the layout as a component.

    {{ Layout::set('menu')->item() }}

Note: you can add different header and footer layouts.
Example: 

    {{ Layout::set('main-1.layout')->header() }}
    <h1>Sum of two numbers.</h1>
    5+5 = {= 5+5 }}
    {{ Layout::set('main-2.layout')->footer() }}
    
### Pass Information to Views.

You can pass information to views through an associative array, on the view side you can access the information through a variable with the name of the key related to the corresponding value in the passed associative array.

    View::set('home',['key'=>$data]);

Example:

    View::set('home',['key'=>$data,'number'=>2022]);

In the View 'home':

    <h1>Home View</h1>
    Data: {= $key }}
    <br>
    Year: {= $number }}
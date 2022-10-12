<?php

namespace Vengi;

use Vengi\Engine;

class View
{
    public static $view;                                        # Save the view in use.
    public static $data;                                        # Save the data that will be available in the view.

    public  static function set($view,$data=null)               # Function set(receive a view, and receive optional data).
    {
        self::$view = $view;                                    # Save view in use on self::$view.
        self::$data = $data;                                    # Save data in use on self::$data.
    }
    
    public  static function get()                               # Function get().
    {
        foreach (array_keys(self::$data) as $keys) {            # It goes through the keys of the data.
            $$keys = self::$data[$keys];                        # It accesses the values corresponding to each key,
        }                                                       # and saves it in variables with the name of the key corresponding to the value.

        View::prepare();                                        # Call the function to prepare the content of the view.
        
        return require_once(__DIR__.'/views/view.php');         # Return require_once view.php.
    }
    
    public static function prepare()                            # Function prepare().
    {
        $file = Engine::$views_path.'/'.self::$view.'.php';     # Define the path of the view in use.
        $fopen = fopen($file, "r");                             # Open the view file.
        $view = fread($fopen, filesize($file));                 # Save the content of the view to $view.
        fclose($fopen);                                         # Close the file.

        $view = Engine::render($view);                          # Render the view content and save in $view.

        Engine::render_path(__DIR__.'/views');                  # Sets the route of the rendered views, if the route does not exist, it creates it.

        $compiled_view = __DIR__.'/views/view.php';             # Save the path of the compiled/rendered view.
        $fopen = fopen($compiled_view, "w");                    # Opens the file where the rendered content of the current view is saved.
        fwrite($fopen,$view,strlen($view));                     # Save/write the content of $view to the /view.php file.
        fclose($fopen);                                         # Close the file.
    }
}

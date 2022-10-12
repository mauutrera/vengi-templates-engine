<?php

use Vengi\Engine;

class Layout
{
    public static $layout;                                          # Save the current layout.
    public static $head = [];                                       # Save the custom head items.
    public static $title;                                           # Save the custom title page.

    public static function set($layout)                             # Function set(get the name of the layout).
    {
        self::$layout = $layout;                                    # Save the current layout in $layout.

        if (Engine::$layouts_path) {                                # If I set the layout path.
            $file = Engine::$layouts_path."/$layout.php";           # The path is set.
        } else {
            $file = Engine::$views_path."/layouts/$layout.php";     # Otherwise use the views/layouts path.
        }

        $fopen = fopen($file, "r");                                 # Open the layout template file.
        $layout_template = fread($fopen, filesize($file));          # Save the file data in a var $layout_template.
        fclose($fopen);                                             # Close the file.
        
        Engine::render_path(__DIR__.'/views/layouts');              # Set and create (if not exists) the layouts render path.

        if (str_contains($layout_template,'@{_Content_}@')) {       # If exists @{_Content_}@ It means that it is a layout. 
            $layout_template = explode('@{_Content_}@', $layout_template,2);    # Part the information from @{_Content_}@.
            $header = $layout_template[0];                          # Save the layout header.
            $header = Engine::render($header);                      # Render/Process the header.
            $footer = $layout_template[1];                          # Save the layout footer.
            $footer = Engine::render($footer);                      # Render/Process the footer.

            $file_header = __DIR__.'/views/layouts/header.php';     # Path where the rendered header file is saved.
            $file_footer = __DIR__.'/views/layouts/footer.php';     # Path where the rendered footer file is saved.
            
            $fopen = fopen($file_header, "w");                      # Open or create the rendered file (header).
            fwrite($fopen,$header,strlen($header));                 # Write the $header in the header.php file.
            fclose($fopen);                                         # Close the file.
            $fopen = fopen($file_footer, "w");                      # Open or create the rendered file (footer).
            fwrite($fopen,$footer,strlen($footer));                 # Write the $footer in the footer.php file.
            fclose($fopen);                                         # Close the file.
        } else {
            $layout_template = Engine::render($layout_template);    # Render/Process the layout componet.
            $file_item = __DIR__."/views/layouts/$layout.php";      # Path where the rendered component/item file is saved.
            $fopen = fopen($file_item, "w");                        # Open or create the rendered file (component/item).
            fwrite($fopen,$layout_template,strlen($layout_template));   # Write the $layout_template (component/item) in the $layout_template.php file.
            fclose($fopen);                                         # Close the file.
        }
        
        return new Layout;                                          # Return a Layout Class Object.
    }

    public function header()                                        # Function header().
    {
        return require_once(__DIR__.'/views/layouts/header.php');   # Return a require_once header.php component.
    }

    public function footer()                                        # Function header().
    {
        return require_once(__DIR__.'/views/layouts/footer.php');   # Return a require_once header.php component.
    }

    public function item()                                          # Function header().
    {
        return require_once(__DIR__.'/views/layouts/'.self::$layout.'.php');    # Return a require_once header.php component/item.
    }

    public static function head($head)                              # Function head('receive a string with <meta>, <link>, or <script> resources').
    {
        if (sizeof(self::$head) === 0) {                            # If $head array is empty.
            self::$head[0] = $head;                                 # Resources are stored in the array self::$head[with index 0].
        } else {                                                    # else.
            self::$head[sizeof(self::$head)+1] = $head;             # Resources are stored in the array self::$head[with index of $head array length + 1].
        }
    }

    public static function headCustom()                             # Function headCustom().
    {
        if (sizeof(self::$head)>=1) {                               # If exists custom head resources.
            foreach (self::$head as $head) {                        # The array is traversed.
                echo $head;                                         # The resources are written/echo.
            }
        }
    }

    public static function title($title)                            # Function title('receive a title page').
    {
        self::$title = $title;                                      # Save $title on self::$title.
    }

    public static function titles($optional)                        # Function titles('receive an optional PROVISIONAL TITLE').
    {
        if (empty(self::$title)) {                                  # If not exists a custom title.
            echo $optional;                                         # Echo the PROVISIONAL TITLE if exists.
        } else {                                                    # else.
            echo self::$title;                                      # Echo the custom self::$title.
        }
    }
}
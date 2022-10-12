<?php

namespace Vengi;

class Engine
{
    public static $views_path;                                          # Save the views path.
    public static $layouts_path;                                        # Save the layouts path.

    public static function views($views_path)                           # Function views(receive the views path).
    {
        self::$views_path = $views_path;                                # Save the path in self::$views_path.
    }

    public static function layouts($layouts_path)                       # Function layouts(receive the layouts path).
    {
        self::$layouts_path = $layouts_path;                            # Save the path in self::$layouts_path.
    }

    public static function render($template)                            # Function render(receive $template content).
    {
        $template = str_replace('{{','<?php', $template);               # Replace all {{ with <'?php.
        $template = str_replace('{=','<?=', $template);                 # Replace all {= with <'?=.
        $template = str_replace('}}','?>', $template);                  # Replace all }} with ?'>.
        $template = str_replace('{_r','<?php print_r(', $template);     # Replace all {_r with <'?php print_r(.
        $template = str_replace('r_}',')?>', $template);                # Replace all r_} with )?'>.

        return $template;                                               # Return render $template content.
    }

    public static function render_path($render_path)                    # Function render_path(receive render path).
    {
        if (!file_exists($render_path)) {                               # If the path does not exist.
            mkdir($render_path);                                        # Create the path.
        }
    }
}
<?php


/**
 * Copy these functions into your function.php file to see them take effect.
 * 
 * Then go nuts and have at it..
 */



//Example filter of preset hook values
function simple_hook_example_filter($hooks){
    $hooks = array (
        'example-hook-one' => 'Awesome Widget',
        'example-hook-two' => 'Simple Widget'
    );
    return $hooks;
}
add_filter('simple-hook-list', 'simple_hook_example_filter');





//Example default hook
function simple_hook_example_default($default_hook){
    return 'example-hook-name-two';
}




//Example use of hook
function simple_hook_super_example() {
    echo "This is my super simple hook widget";
}
add_action('example-hook-one', 'simple_hook_super_example');





//Example use of hook
function simple_hook_awesome_example() {
    echo "This is my awesome simple hook widget";
}
add_action('example-hook-two', 'simple_hook_awesome_example');
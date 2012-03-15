=== Simple Hook Widget ===
Contributors: eddiemoya
Donate link: http://eddiemoya.com
Tags: widget, sidebar, hook, custom hook, development
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: trunk

Allows developers to create a drop down of hooks to be selected from a widget, for on-the-fly widgets without the fuss, or just easily test hooks.

== Description ==

This widget allows the user to insert a hook, with a name of their choosing, in any sidebar. 

The hook can be anything, an existing hook from the WordPress Core, a plugin, a theme, or something you've come up with on the fly. Once the hook exists, your plugins, your theme, or the WordPress Core to make something happen with that hook.

This can be used in conjunction with other more complex plugins, to allow you to trigger a hook from the sidebar (yes, that is intentionally vague). It can also serve as a quick alternative to making very simple widgets tied to code from a theme. Say you have a chunk of code which already exists on your site, you'd like to also have it placed in a sidebar, but don't want to make a widget out of it (since its entirely theme-centric). You could simply hook this chunk of code to a custom hook and use the Simple Hook Widget to place that custom hook in the sidebar. 

This is clearly not the best method of widget development, but there may be times where such on option is useful to a developer in a pinch.

= Update 2.0 =
* New filter which allows developers to specify what hooks are available to choose from.

Warning: Use this plugin with care. If you are not a developer and don't know what 'hooks' are, this plugin is not for you. This plugin will allow you to enter _ANY_ hook, and will run it in the sidebar - that includes core WordPress loaded with actions that could result in problems for your site.

== Installation ==


1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. In the widgets interface, drag to desired location.
1. Enter desired hook name or select one from the drop down menu (if there is one).
1. Enjoy cake.



== Frequently Asked Questions ==

= Does this plugin work? =

Yes

= Is it simple? =

Yes

= Is it dishwasher safe? =

No.


== Upgrade Notice ==

= 2.0 =
New functionality!

= 1.1.1 =
Please upgrade to 1.1.1 - Fixes a problem that caused plugin to fail during activation.

== Changelog ==

= 2.0 =
* New 'simple-hook-list' filter which allows developers to specify what hooks are available to choose from in the widget panel.
* New 'simple-hook-default' filter which allows developers to specify a default value for Simple Hook Widget.

= 1.1.1 =
* Fixed a packaging problem which made plugin activation fail

= 1.1 =
* Changed the name of the update hook prefix from simplehook_ to simplehookupdate_ 

= 1.0 =
* Initial commit

== Developer Notes ==


= IMPORTANT: = 
If the 'simple-hook-list' is not filtered, the Simple Hook Widget will not show a drop down in the widget interface, but instead it will provide an empty text field allowing a user to enter _ANY_ hook they like.


= Using the hooks =

Here is a simple example of how to use a hook used in the Simple Hook Widget. Its just like using any other hook in WordPress. Remember, you can do whatever you want here, you just need to make sure the hook used in the add_action() is the same as the hook name selected in a particular widget.

Example #1:
`
function simple_hook_super_example() {
    echo "This is my super simple hook widget";
}
add_action('example-hook-name-one', 'simple_hook_super_example');


You can create any number of different widgets by simply writing a function, and adding it as an action to a hook. Here is a similar one as the first, but this is here to illustrate the point.

Example #2:
`
function simple_hook_awesome_example() {

    //Do whatever you want your 'widget' to do, when the 'example-hook-name-two' hook is chosen.
    echo "This is my awesome simple hook widget";
}
add_action('example-hook-name-two', 'simple_hook_awesome_example');
`


= Creating dropdown of Pre-determined hooks =

= Filter: 'simple-hook-list' =
Version 2.0 of the Simple Hook Widget includes the 'simple-hook-list' filter which allows developers to specify a set of hooks which can be selected from the widgets admin panel.

The function you create should return an associative array where the index is the actual hook's name, and the value is the text that will represent it in the drop down on the widgets panel. 

Example:
`
function simple_hook_example_filter($hooks){
    $hooks = array (
        'example-hook-name-one' => 'Awesome Widget',
        'example-hook-name-two' => 'Simple Widget'
    );
    return $hooks;
}
add_filter('simple-hook-list', 'simple_hook_example_filter');
`

= IMPORTANT: = If the 'simple-hook-list' is not filtered, the Simple Hook Widget will not show a drop down in the widget interface, but instead it will provide an empty text field allowing a user to enter _ANY_ hook they like.

= Hook: simple-hook-default =

This hook allows developers provide a default value for the Simple Hook widget. By default, the default value for the hook, is an empty string.
Example:
`
function simple_hook_example_default($default_hook){
    return 'example-hook-name-two';
}
`
Note: If filtering 'simple-hook-list' to create a drop down, the default value must match one of the _keys_ in the array passed to the filter - otherwise this default will do nothing.

= Hook: simplehookupdate_ =

This widget also contains an internal hook, which will be _your_ hook, prefixed with simplehookupdate_. So if you use this plugin to create a hook name 'testhook', the widget, aside from creating the 'testhook' in the chosen sidebar location, will also create a hook called 'simplehookupdate_testhook'. This hook occurs within the update method of the WP_Widget class, immediately before $instance is returned.

Not sure how useful this is, but a friend suggested it, so here is it.


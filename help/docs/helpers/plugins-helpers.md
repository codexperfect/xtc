# Plugins Helpers

Many Plugins Helpers can be found in the `Drupal\xtc\XtendedContent\API` namespace:

## Classes extending `PluginBase`

They provide `get()` and `load()` functions.

- `XtcDisplay`
- `XtcFilter`
- `XtcFilterType`
- `XtcForm`
- `XtcHandler`
- `XtcMapping`
- `XtcPager`
- `XtcProfile`
- `XtcRequest`
- `XtcServer`

### Extending the Helpers

Providing a new Helper class can be done that way:

```php
namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcsearch\PluginManager\XtcSearchDisplay\XtcSearchDisplayDefault;

class XtcDisplay extends PluginBase
{

  public static function get($name): XtcSearchDisplayDefault{
    return parent::get($name);
  }

  protected static function getService() : string {
    return 'plugin.manager.xtcsearch_display';
  }
}
```

- Make sure to define the right return type to the `get()` function.
- Define the Plugin Manager service in the `getService()` function.

## ToolBox

The `ToolBox` Helper class is used to provide Xtended Content suite with plain tool static functions.

For now: 

- `replaceAccents()`
- `transliterate()`
- `getPrefix()`
- `getSuffix()`

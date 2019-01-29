# File profile

## Loading a File profile

To load a content, simply provide the profile name to the `getFile()` static function from the helper class `\Drupal\xtc\XtendedContent\API\Config`. 

```php
$content = \Drupal\xtc\XtendedContent\API\Config::getFile('test_text');
```

## Plugin definition

This is a Drupal 8 YAML plugin.

## Yaml file

The profiles can be defined in a YAML file that follows this pattern: 
`[module_name].xtc_profiles.yml`.

The plugin is defined in the Xtended Content (`xtc`) module: `xtc/src/PluginManager/XtcProfile/XtcProfilePluginManager.php`.

## Structure

A File profile definition looks lake this:

```yaml
test_text:
  label: 'Text file'
  description: ''
  type: 'text'
  abs_path: false
  module: 'xtcfile'
  path: 'example/demo.txt'
```

`label` (string) and `description` (string) are mandatory for any Drupal 8 plugin definition.

### Handler type `type` (string)

Available types provided by the XTC File are:

- Csv `csv`: use `LoadCsv` class (based on [https://github.com/parsecsv/parsecsv-for-php]()) to load Comma-Separated Values files. 
- Html `html`: load HTML file. 
- Json `json`: load Json file through Drupal Json serializer.
- Markdown `md`: use `LaodMarkdown` class (using **erusev/parsedown**, [https://github.com/erusev/parsedown]()) to load Markdown content.  
- Text`text`: load plain Text file.
- Yaml `yaml`: load Yaml file through Drupal Yaml serializer.

#### Dynamic handlers

Two dynamic handlers are provided for Documentation:

- MkDocs `mkdocs`: provide a light API to display MkDocs ([https://www.mkdocs.org/]()) based documentation in the administration area.
- Readme `readme`: extends Markdown type to provide display modules Readme files in the administration area.

`getDocs()` static function from `\Drupal\xtc\XtendedContent\API\Config` provides an example for dynamics handlers:

```php
public static function getDocs($module){
  $profile = [
    'type' => 'mkdocs',
    'abs_path' => false,
    'module' => $module,
    'path' => 'help/mkdocs.yml',
  ];
  $content = self::getFromProfile($profile);
  if(!empty($content) && is_array($content)) {
    return $content;
  }
  return "<h2>Documentation needs to be created.</h2>
         <p>Documentation follows <b><a href='https://www.mkdocs.org/' target='_blank'>
         mkdocs</a></b> standards.</p>
      ";
}
``` 

`Config::getFromProfile()` needs to be used in that case.
This function directly trigger a `get()`;

```php
public static function getFromProfile($profile){
  return self::getHandler($profile['type'])
             ->setProfile($profile)
             ->setOptions()
             ->get();
  ;
}
```

If for any reason, an action needs to be done before the get(), the `Config::getHandlerFromProfile()` can be prefered: 

```php
public static function getHandlerFromProfile($profile){
  return self::getHandler($profile['type'])
             ->setProfile($profile)
             ->setOptions();
  ;
}
```

### Absolute path `abs_path` (boolean)

Whether the provided path is absolute or local.

### Module `module` (string)

Module machinename where the file is expected to be found.

### Path `path` (string)

Path from the module root directory.


## Extending types list

Any new File type handler should be based on `\Drupal\xtcfile\Plugin\XtcHandler\FileBase`.

Example from the `Text` type:

```php
namespace Drupal\xtcfile\Plugin\XtcHandler;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "text",
 *   label = @Translation("Text File for XTC"),
 *   description = @Translation("Text File for XTC description.")
 * )
 */
class Text extends FileBase
{

}
```
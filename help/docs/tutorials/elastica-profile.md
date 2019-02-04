# Elastica profile

## Loading an Elastica profile

To load an Elasticsearch client as a service, simply provide the profile name, the helper static function `Config::getXtcRequestFromProfile()` from `\Drupal\xtc\XtendedContent\API\Config`.

```php
public static function getXtcRequestFromProfile($name){
  $profile = \Drupal::service('plugin.manager.xtc_profile')
    ->getDefinition($name)
  ;
  $xtcrequest = (New $profile['service']($name));
  if($xtcrequest instanceof AbstractXtcRequest){
    $xtcrequest->setConfigfromPlugins();
  }
  return $xtcrequest;
}
```

To load a content, here an example of code: 

```php
$results = $this->getESHits(Config::getXtcRequestFromProfile($name), $uri);
```

Where:


```php
protected function getESHits(XtcRequestInterface $service, $uri = ''){
  $method = $service->getWebservice()['method'];
  $service->get($method, $uri);
  if(!empty($results = $service->getData('array'))
  ){
    return $results;
  }
  return [];
}
```

## Plugin definition

This is a Drupal 8 YAML plugin.

## Yaml file

The profiles can be defined in a YAML file that follows this pattern: 
`[module_name].xtc_profiles.yml`.

The plugin is defined in the Xtended Content (`xtc`) module: `xtc/src/PluginManager/XtcProfile/XtcProfilePluginManager.php`.

## Structure

An Elastica profile definition looks like this:

```yaml
article:
  label: 'Article'
  description: ''
  type: 'elastica'
  server: 'xtc_elastica'
  request: 'contenu-by-id'
  service: 'Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\GetElasticaXtcRequest'
```

Default values can be provided thanks to `args`:

```yaml
article:
  label: 'Article'
  description: ''
  type: 'elastica'
  server: 'xtc_elastica'
  request: 'contenu-by-id'
  service: 'Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\GetElasticaXtcRequest'
  args:
    category: 'News'
```

`label` (string) and `description` (string) are mandatory for any Drupal 8 plugin definition.

### Handler type `type` (string)

Always use `elastica`.

### Server `server` (string)

Provide the name of the XTC `server` plugin to use.

### Request `request` (string)

Provide the name of the XTC `request` plugin to use.

### Service `service` (string)

Provide the name of the XtcRequest class to build the Elasticsearch Client.

### Arguments `args` (array)

Array of default values that can be pass to the `request` plugin.

## Extending available XtcRequest services list

Any new XtcRequest service should be based on `\Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\AbstractElasticaXtcRequest`.

Example from the `GetElasticaXtcRequest` type:

```php
namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtcelastica\XtendedContent\Serve\Client\GetElasticaClient;

class GetElasticaXtcRequest extends AbstractElasticaXtcRequest
{
  /**
   * @return \Drupal\xtcelastica\XtendedContent\Serve\Client\AbstractElasticaClient
   */
  protected function getElasticaClient(){
    return New GetElasticaClient($this->profile);
  }

}
```
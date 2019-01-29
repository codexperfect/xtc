# Guzzle profile

## Loading a Guzzle profile

To load an Guzzle client as a service, simply provide the profile name, the helper static function `Config::getXtcRequestFromProfile()` from `\Drupal\xtc\XtendedContent\API\Config`.

```php
$profileService = Config::getXtcRequestFromProfile('user_profile');
```

That does:

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

`Config::getXtcRequestFromProfile()` returns an instance of `AbstractXtcRequest` as it is a very high level helper function. When getting a Guzzle profile, 
we expect the built Client to be using Guzzle - see `\Drupal\xtcguzzle\XtendedContent\Serve\XtcRequest\AbstractGuzzleXtcRequest`: 

```php
protected function buildClient(){
  $this->client = $this->getGuzzleClient();
  $this->client->setXtcConfig($this->config);
  return $this;
}
```

Then expect `get()` to behave exactly as your usual **Guzzle Client**. 

```php
$users = $profileService->get('getUserGroupById', $this->groupId)->getData('array');
```

As `get()` function from `\Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest` is as transparent as possible:

```php
  public function get($method, $param = '')
  {
    try {
      $this->client->init($method, $param);
      $content = $this->client->get();
    } catch (RequestException $e) {
      $content = '';
    }
    $this->setData($content);
    return $this;
  }
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
user_profile:
  label: 'User profile'
  description: ''
  type: 'guzzle'
  server: 'ldap'
  service: 'Drupal\xtcguzzle\XtendedContent\Serve\XtcRequest\GuzzleXtcRequest'
  method: 'getUserGroupById'
```

`label` (string) and `description` (string) are mandatory for any Drupal 8 plugin definition.

### Handler type `type` (string)

Always use `guzzle`.

### Server `server` (string)

Provide the name of the XTC `server` plugin to use.

### Service `service` (string)

Provide the name of the XtcRequest class to build the Guzzle Client.

### Method `method` (string)

Method can be pass to benefit from dynamic functions.

## Extending available XtcRequest services list

Any new XtcRequest service should be based on `\Drupal\xtcguzzle\XtendedContent\Serve\XtcRequest\AbstractGuzzleXtcRequest`.

Example from the `GuzzleXtcRequest` class:

```php
namespace Drupal\xtcguzzle\XtendedContent\Serve\XtcRequest;


class GuzzleXtcRequest extends AbstractGuzzleXtcRequest
{
}
```
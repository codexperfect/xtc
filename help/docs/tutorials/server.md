# Defining a Server

## Loading a Server profile

To load a content, simply provide the profile name to the `get()` static function from the helper class `\Drupal\xtc\XtendedContent\API\XtcServer`. 

```php
$content = \Drupal\xtc\XtendedContent\API\XtcServer::get('test_text');
```

## Plugin definition

This is a Drupal 8 YAML plugin.

## Yaml file

The profiles can be defined in a YAML file that follows this pattern: 
`[module_name].xtc_servers.yml`.

The plugin is defined in the Xtended Content (`xtc`) module: `xtc/src/PluginManager/XtcServer/XtcServerPluginManager.php`.

## Structure

A Server profile definition looks like this:

```yaml
xtc_elastica:
  label: 'XTC Elastica'
  description: 'Elastica Server, for multiple environments.'
  type: 'elastica'
  env: 'prod'
  connection:
    dev:
      host: '127.0.0.123'
      port: 9200
    rec:
      host: '192.168.1.123'
      port: 9200
    prod:
      host: '192.168.1.456'
      port: 9200
```

`label` (string) and `description` (string) are mandatory for any Drupal 8 plugin definition.

### Server type `type` (string)

Available types provided by the XTC File are:

- Elastica `elastica`: used by XTC Elastica handler 
- Guzzle `guzzle`: used by XTC Guzzle handler 

### Server active environment `env` (string)

Defines the active environment to be used by the Drupal instance. Environments are used to facilitate deployment between different environments. 

Active environment can be overriden in the `settings.local.php` file:

```php
$settings['xtc.serve_client']['xtc']['serve_client']['server']['xtc_elastica']['env'] = 'dev';
```

> If 2 different environments need to be used on the same instance of Drupal, 
it means you should define 2 different server profiles.

### Additional values

Depending on the Handler that need a **Server** definition, you might need to define additional values.

For example, **XTC Elastica** expects a Connection `connection` (array) to be defined, 
while **XTC Guzzle** API needs a Path `path` (array) and accepts Options `options` (array). In this case, 
Options are, transparently, the ones from the Guzzle API. 

```yaml
countries:
  label: 'Countries'
  description: ''
  type: 'guzzle'
  env: 'prod-int'
  options:
    verify: false
    timeout: 5
  path:
    prod-int:
      tls: false
      server: "data.example.com"
      port: 8001
      endpoint: "pays"
    prod-ext:
      tls: true
      server: "data.example.com"
      port: 8011
      endpoint: "pays"
    rec-int:
      tls: false
      server: "data-rec.example.com"
      port: 8001
      endpoint: "pays"
    rec-ext:
      tls: true
      server: "data-rec.example.com"
      port: 8011
      endpoint: "pays"
```

## Uses

Server profiles are used by:

- XTC Elastica
- XTC Guzzle
- XTC Search

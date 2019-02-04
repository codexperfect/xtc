# Defining a Request

## Loading a Request profile

To load a content, simply provide the profile name to the `loadXtcRequest()` static function from the helper class `\Drupal\xtc\XtendedContent\API\Config`. 

```php
$request = Config::loadXtcRequest($profile['request']);
```

## Plugin definition

This is a Drupal 8 Annotation plugin.

## XtcRequest classes

An **XtcRequest** can be defined by a class extending `\Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest`:

**XtcRequest** is mainly use to override the **Client** that will be used. 

```php
namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtcelastica\XtendedContent\Serve\Client\SearchElasticaClient;

class SearchElasticaXtcRequest extends AbstractElasticaXtcRequest
{
  protected function getElasticaClient(){
    return New SearchElasticaClient($this->profile);
  }

}
```

## XtcClient classes

An **XtcClient** can be defined by a class extending `\Drupal\xtc\XtendedContent\Serve\Client\AbstractClient`:

**XtcClient** is mainly use to define the **Methods** that will can used. 


```php
namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


class GetElasticaClient extends AbstractElasticaClient
{
  public function getElasticaDataByID(){
    $clientParams = $this->getParams();
    $clientParams['id'] = $this->param['q'];
    try {
      $this->content = $this->client->get($clientParams);
      return $this;
    } finally{
      return $this;
    }
  }

  public function getKnownDoc(){
    $clientParams = $this->getParams();
    $queryParams = explode('/', $this->param['q']);
    $clientParams['index'] = $queryParams[0];
    $clientParams['type'] = $queryParams[1];
    $clientParams['id'] = $queryParams[2];
    $this->content = $this->client->get($clientParams);
    return $this;
  }

}
```

### Methods

**Methods** are defined in: 

- `guzzle` type profiles
- **Xtc Request** for `elastica` type profiles

# Search profile

## Plugin definition

This is a Drupal 8 YAML plugin.

## Yaml file

The profiles can be defined in a YAML file that follows this pattern: 
`[module_name].xtc_searchs.yml`.

The plugin is defined in the Xtended Content Search (`xtcsearch`) module: `xtcsearch/src/PluginManager/XtcSearch/XtcSearchPluginManager.php`.

## Structure

A Search profile definition looks like this:

```yaml
xtc_search:
  label: 'XTC Search'
  description: 'XTC Search'
  server: 'xtc_elastica'
  routeName: 'xtcsearch.search'
  resetRoute: 'xtcsearch.search'
  display: 'xtc_search_page'
  items:
    theme: 'xtc_search_result_element'
    region: 'content'
  index:
    - 'contenu'
    - 'document'
    - 'publication'
  type: '_doc'
  filters:
    excludeUnsearchable: 'hidden'
    fulltext: 'header'
    published: 'sidebar'
    learningResource: 'sidebar'
    editor: 'sidebar'
  pager:
    name: 'page'
    size: 20
    masonry: false
```

Another example, for Agenda in a fictional `xtc_agenda` module:

```yaml
agenda:
  label: 'Agenda'
  description: 'Agenda search per month.'
  form: 'Drupal\xtc_agenda\Form\AgendaForm'
  routeName: 'xtc_agenda.agenda_month'
  resetRoute: 'xtc_agenda.agenda'
  server: 'xtc_elastica'
  display: 'xtc_search_page'
  items:
    theme: 'teaser_event'
    region: 'content'
  index:
    - 'event'
  type: '_doc'
  filters:
    excludeUnsearchable: 'hidden'
    thisMonth: 'sidebar'
    editor: 'sidebar'
  pager:
    name: 'more'
    size: 50
    masonry: true
  nav:
    top_navigation: true
    bottom_navigation: true
  sort:
    field: 'startDate'
    dir: 'desc'
```

`label` (string) and `description` (string) are mandatory for any Drupal 8 plugin definition.

### Form `form` (string)

By default, `\Drupal\xtcsearch\Form\XtcSearchForm` is used.

```php
namespace Drupal\xtcsearch\Form;


class XtcSearchForm extends XtcSearchFormBase
{
}
```

This value allows to override this class.

To define such a custom: extends `\Drupal\xtcsearch\Form\XtcSearchForm` 
or `\Drupal\xtcsearch\Form\XtcSearchFormBase`

```php
namespace Drupal\xtc_agenda\Form;


use Drupal\xtcsearch\Form\XtcSearchForm;

class AgendaForm extends XtcSearchForm
{
}
```

This could be useful, for example, to override:

- `preprocessResults()`
- `getNav()`
- `emptyResultMessage()`
- `preprocessQueryString()`

### Server `server` (string)

Provide the name of the XTC `server` plugin to use.

Presently, only Elastica search is available: make sure this is an `elastica` type server.

### Route name `routeName` (string)

The route is used on submit.

Optional: if not defined, the current route will be used. Pretty useful to define a Search page 
with dynamic route. 

> For a better project documentation, always define a routeName when not using a dynamic route.

### Reset route `resetName` (string)

The route is used by the reset button. It allows to provide a resetRoute that is different 
from the routeName. 

Optional: if not defined, the current route will be used. Pretty useful to define a Search page 
with dynamic route. 

> For a better project documentation, always define a routeName when not using a dynamic route.

### Display `display` (string)

Provide the name of the XTC `display` plugin to use.

### Items `items` (array)

Define how to display each item from the results.

#### Theme hook `theme` (string)

Define the name of the Drupal theme hook to use to render each item. Depending on the definition
of the `hook_theme()`, this can be a function or a template: Drupal as usual.

#### Region `region` (string)

Define the `region` where the results should appear. 

Available regions are:

- main
- header
- top
- content
- bottom
- sidebar
- footer

Usually, `content` is the right value.

### Index `index` (array)

Provide a list of Elastica indices to use in the search request.

### Type `type` (string)

Provide the Elastica type to use in the search request. 

Presently, several indices can be requested but only 1 type.

### Filters `filters` (array)

Array XTC `filters` plugin that should be used.

For each filter, define the `region` where the **Filter widget** should appear. 

Available regions are:

- main
- header
- top
- content
- bottom
- sidebar
- footer

A special region `hidden` allows to enable a filter in the search, without displaying it in the UI.

We recommend to display filters in the **header** or in the **sidebar**. 

### Pager `pager` (array)

Define a pager that will used on the search display.

#### Name `name` (string)

Presently, 3 pagers are available:

- page: Standards pager that looks like Drupal long pager. Button trigger a reload of all the contents that will be 
displayed on the page. 
- more: **More** button that loads only additional contents that are appended to the ones already displayed. 
Using Masonry, the More pager doesn't reload the whole page.  
- nopager: No paging is proposed.

#### Size `size` (string)

Presently, 3 pagers are available:

#### Masonry `masonry` (boolean)

Should Masonry be used to display contents

### Navigation `nav` (array)

#### Navigation regions

Define if Top navigation `top_navigation` (boolean) and Bottom navigation `bottom_navigation` (boolean)
should be used. 

#### Link regions

Define if Top link `top_link` (array) and Bottom link `bottom_link` (array)
should be used. 

To display a link, 3 values can be defined for Type `type` (string): 

- `route`: use `Url::fromRoute()`
- `url`: use `Url::fromUri()` 
- `path`: use `Url::fromUri()`

> see `buildLinks()` from `\Drupal\xtcsearch\Form\Traits\NavigationTrait` for details.

As a consequence, depending on the type of `\Drupal\Core\Url` function you decide to use, make sure to define
the expected values: 

- `label`
- `route`
- `url`
- `path`
- `parameters`
- `options`

### Sort `sort` (array)

Define Elastica **Sort** feature.

#### Field `field` (string)

Define the name of the existing Elastica field to be use for the sort.

#### Direction `dir` (string)

Define the value of the existing Elastica direction to be use for the sort.

Allowed values are the ones provided by Elastica API: 

- asc: Ascending
- desc: Descending

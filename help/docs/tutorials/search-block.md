# Creating a search block

Search block mainly consists of displaying an XTC Search form in a Drupal block instead of a page. 

## Main differences with an XTC Search page

- A Drupal block is defined by a Block plugin: No route, no default controller.
- A Drupal block doesn't have its own URL.

## Start by providing a Block

Create a Block that extends `\Drupal\xtcsearch\Plugin\Block\XtcSearchBlockBase`.

Define the Xtc Search plugin name in the `getSearchName()` function.

```php
namespace Drupal\xtc_search\Plugin\Block;

use Drupal\xtcsearch\Plugin\Block\XtcSearchBlockBase;

/**
 * Provides a 'XtcSearchBlock' block.
 *
 * @Block(
 *  id = "light_xtcsearch_block",
 *  admin_label = @Translation("Light XTC Search block"),
 * )
 */
class LightXtcSearchBlock extends XtcSearchBlockBase
{

  protected function getSearchName() : string {
    return 'search_light';
  }

}
```

## Loading a Search form

To load a Search form, simply provide the profile name, the helper static function `Config::getSearch()` from `\Drupal\xtc\XtendedContent\API\Config`.

```php
$form = Config::getSearch('xtc_search');
```

## Plugin example

A Search Block profile definition looks like this:

```yaml
search_light:
  label: 'XTC Lite Search'
  description: 'XTC Lite Search'
  routeName: 'xtcsearch.search'
  resetRoute: 'xtcsearch.search'
  server: 'xtc_elastica'
  display: 'xtc_lightsearch_block'
  index:
    - 'contenu'
    - 'document'
    - 'publication'
  type: '_doc'
  filters:
    nosuggest: 'header'
  pager:
    name: 'nopager'
    masonry: false
```

This `search_light` XTC Search Block provides a small minimum block to be displayed anywhere on the website: on submit, 
it redirect to `xtcsearch.search`: the XTC Search form page. 

That other one provide a block that displays 3 coming events:

```yaml
agenda_block:
  label: "Next events"
  description: 'Agenda: Next events.'
  form: 'Drupal\xtc_agenda\Form\AgendaForm'
  routeName: 'xtc_agenda.agenda'
  resetRoute: 'xtc_agenda.agenda'
  server: 'xtc_elastica'
  display: 'xtc_agenda_block'
  items:
    theme: 'teaser_event_block'
    region: 'content'
  index:
    - 'event'
  type: '_doc'
  filters:
    comingEvents: 'hidden'
  pager:
    name: 'nopager'
    size: 3
    masonry: false
  nav:
    bottom_link:
      type: 'route'
      label: "See all"
      route: 'xtc_agenda.agenda'
  sort:
    field: 'startDate'
    dir: 'asc'
```

We can note that:

- 3 items are displayed, with no pager. Sorted by date.
- A specific display is used.
- The `comingEvents` request is used, but no widget is displayed (`hidden`).
- A **See all** bottom link is provided to `xtc_agenda.agenda` route (main Agenda page). 
- On submit, redirect to `xtc_agenda.agenda` route.

## Build your own

To define a custom display for an XTC Search Block, we recommend you start from `xtc_block` in `xtcsearch.xtcsearch_displays.yml`.

> Because it is not reasonable to display **Hide** and **Reset** buttons in the `sidebar` region, you should use 
the Filter Top `filter_top` (boolean) and Filter Bottom `filter_bottom` (boolean) values to define if filters will be
displayed in the `top` region or the `bottom` region.   

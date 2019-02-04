# Search display

## Plugin definition

This is a Drupal 8 YAML plugin.

## Yaml file

The profiles can be defined in a YAML file that follows this pattern: 
`[module_name].xtc_displays.yml`.

The plugin is defined in the Xtended Content Search (`xtcsearch`) module: `xtcsearch/src/PluginManager/XtcSearch/XtcSearchDisplayPluginManager.php`.

## Structure

A Search profile definition looks like this:

```yaml
xtc_page:
  label: 'Page'
  description: 'Page for XTC Search.'
  total: true
  hide: true
  reset: true
  filter_top: true
  filter_bottom: true
  container:
    main:
      prefix: '<div class="row m-0" id="container-news-filter">'
      suffix: '</div>'
    header:
      prefix: '<div id="mainfilter-div" class="col-12 mainfilter-div pt-3"> <div class="row">'
      suffix: '</div> </div>'
    sidebar:
      prefix: '<div id="filter-div" class="order-1 order-md-2 mb-4 mb-md-0 col-12 col-md-4"> <div class="row mr-md-0 h-100"> <div class="col-12 filter-div pt-3">'
      suffix: '</div> </div> </div>'
    top:
    content:
      prefix: '<div id="news-elements" class="col-12 p-0 order-2 order-md-1">'
      suffix: '</div>'
    bottom:
    footer:
  button:
    buttons:
      prefix: '<div class="row col-12 mt-3 pr-md-0">'
      suffix: '</div>'
    filter_top:
      prefix: '<div class="col-6"> <div class="form-group text-left">'
      suffix: '</div> </div>'
    filter_bottom:
      prefix: '<div class="col-12 mt-3"> <div class="form-group text-right">'
      suffix: '</div> </div>'
    hide:
      prefix: '<div class="col-12 mt-3 mb-3 d-block d-md-none"> <div class="text-center text-sm-right d-block">'
      suffix: '</div> </div>'
    reset:
      prefix: '<div class="col-6 text-right mt-1 pr-md-0">'
      suffix: '</div>'
  navigation:
    top:
      prefix: '<div class="row mx-0 mb-30"><div class="col-12 px-0 px-md-15">'
      suffix: '</div></div>'
    top_buttons:
      prefix: '<div class="float-right">'
      suffix: '</div>'
    top_prev:
      prefix: ''
      suffix: ''
    top_next:
      prefix: ''
      suffix: ''
    bottom:
      prefix: '<div class="row mx-0 mb-50"> <div class="col-12 bottom-months px-0 px-md-15">'
      suffix: '</div></div>'
    bottom_buttons:
      prefix: ''
      suffix: ''
    bottom_prev:
      prefix: '<div class="float-left">'
      suffix: '</div>'
    bottom_next:
      prefix: '<div class="float-right">'
      suffix: '</div>'
  items:
    items:
      prefix: '<div id="news-list-div">'
      suffix: '</div>'
    results:
      prefix: '<div id="all-items" class="gallery-wrapper clearfix"><div class="col-sm-12 col-md-6 col-lg-4 grid-sizer px-0 px-md-3"></div>'
      suffix: '</div>'
    noresults:
      prefix: '<div class="row mx-0 mb-30"><div class="col-12 px-0 px-md-15 no-result">'
      suffix: '</div></div>'
    noresults_button:
      prefix: '<div class="reset"> <div class="chevron"></div>'
      suffix: '</div>'
```

`label` (string) and `description` (string) are mandatory for any Drupal 8 plugin definition.

### Total `total` (boolean)

Define if the **Total** number of results should be displayed.

### Hide `hide` (boolean)

Define if the **Hide** button should be displayed.

### Reset `reset` (boolean)

Define if the **Reset** button should be displayed.

### Filter Top `filter_top` (boolean)

Define if the filters should be displayed in the **Top** region.

### Filter Bottom `filter_bottom` (boolean)

Define if the filters should be displayed in the **Bottom** region.

### Link `link` (array)

Define a link that should usually lead to an XTC Search full page.

#### Link Label `label` (string)

Define the label of the link.

#### Link page `page` (string)

Define the route of the link.

### Container `container` (array)

7 **Container** regions are available:

- main
- header
- sidebar
- top
- content
- bottom
- footer

For each `container` region, **Prefix** and **Suffix** tags can be defined.

### Button `button` (array)

5 **Button** zones are available:

- buttons
- filter_top
- filter_bottom
- hide
- reset

For each `button` zone, **Prefix** and **Suffix** tags can be defined.

### Navigation `navigation` (array)

8 **Navigation** regions are available:

- top
- top_buttons
- top_prev
- top_next
- bottom
- bottom_buttons
- bottom_prev
- bottom_next

For each `navigation` region, **Prefix** and **Suffix** tags can be defined.

### Items `items` (array)

4 **Items** zones are available:

- items
- results
- noresults: Used when no result is return.
- noresults_button: Button that allows the user to reset the form. 

For each `items` zone, **Prefix** and **Suffix** tags can be defined.

### About **Prefix** and **Suffix**

Please note, `prefix` and `suffix` default to `''`;

```yaml
    top_prev:
      prefix: ''
      suffix: ''
```

and 
 
```yaml
    top_prev:
```

are the same.

## Block display example

Where the `link` value is defined.

And most of header elements (`total`, `hide`, `reset`) are hidden. 

While filters are displayed in the button region instead of the `sidebar`.

```yaml
xtc_block:
  label: 'Block'
  description: 'Block for XTC Search.'
  total: false
  hide: false
  reset: false
  filter_top: false
  filter_bottom: true
  link:
    label: 'All events'
    page: xtc_search
  container:
    main:
      prefix: '<div class="row m-0 order-1" id="container-news-filter">'
      suffix: '</div>'
    header:
      prefix: '<div id="mainfilter-div" class="col-12 mainfilter-div pt-3 order-2"> <div class="row">'
      suffix: '</div> </div>'
    top:
      prefix: '<div id="news-elements" class="col-12 p-0 order-3">'
      suffix: '</div>'
    content:
      prefix: '<div id="news-elements" class="col-12 p-0 order-4">'
      suffix: '</div>'
    bottom:
      prefix: '<div class="col-12 p-0 orderorder-5">'
      suffix: '</div>'
    sidebar:
      prefix: '<div id="filter-div" class="mb-4 mb-md-0 col-12 order-6"> <div class="row py-2 m-0"> <div class="col-12 filter-div pt-3">'
      suffix: '</div> </div> </div>'
    footer:
      prefix: '<div class="col-12 p-0 order-7">'
      suffix: '</div>'
  button:
    buttons:
      prefix: '<div class="row col-12 mt-3 pr-md-0">'
      suffix: '</div>'
    filter_top:
      prefix: '<div class="col-6"> <div class="form-group text-left">'
      suffix: '</div> </div>'
    filter_bottom:
      prefix: '<div class="col-12 mt-3"> <div class="form-group text-right">'
      suffix: '</div> </div>'
    hide:
      prefix: '<div class="col-12 mt-3 mb-3 d-block d-md-none"> <div class="text-center text-sm-right d-block">'
      suffix: '</div> </div>'
    reset:
      prefix: '<div class="col-6 text-right mt-1 pr-md-0">'
      suffix: '</div>'
  navigation:
    top:
      prefix: '<div class="row mx-0 mb-30"><div class="col-12 px-0 px-md-15">'
      suffix: '</div></div>'
    top_buttons:
      prefix: '<div class="float-right">'
      suffix: '</div>'
    top_prev:
    top_next:
    bottom:
      prefix: '<div class="row mx-0 mb-50"> <div class="col-12 bottom-months px-0 px-md-15">'
      suffix: '</div></div>'
    bottom_buttons:
    bottom_prev:
      prefix: '<div class="float-left">'
      suffix: '</div>'
    bottom_next:
      prefix: '<div class="float-right">'
      suffix: '</div>'
  items:
    items:
      prefix: '<div id="news-list-div">'
      suffix: '</div>'
    results:
      prefix: '<div id="all-items" class="gallery-wrapper clearfix"><div class="col-sm-12 col-md-6 col-lg-4 grid-sizer px-0 px-md-3"></div>'
      suffix: '</div>'
    noresults:
      prefix: '<div class="row mx-0 mb-30"><div class="col-12 px-0 px-md-15 no-result">'
      suffix: '</div></div>'
    noresults_button:
      prefix: '<div class="reset"> <div class="chevron"></div>'
      suffix: '</div>'
```

## Autocomplete display example

An autocomplete search form needs no element with `prefix` and `suffix.`

```yaml
autocomplete:
  label: 'Autocomplete'
  description: 'Autocomplete for XTC Search.'
  container:
    main:
    header:
    top:
    content:
    bottom:
    sidebar:
    footer:
  button:
    buttons:
    filter_top:
    filter_bottom:
    hide:
    reset:
  items:
    items:
    results:
    noresults:
    noresults_button:
```

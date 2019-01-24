## XTC Search Plugins

5 plugin managers are defined in `xtcsearch`.

### `xtcsearch`

<u>Service:</u> `plugin.manager.xtcsearch`

1 disabled plugin example is provided by `xtcelastica` in `xtcelastica.xtc_searchs.yml.dist`:

- `xtc_search`

### `xtcsearch_display`

<u>Service:</u> `plugin.manager.xtcsearch_display`

3 plugins are provided by `xtcsearch` in `xtcsearch.xtcsearch_displays.yml`:

- autocomplete
- xtc_block: an `XtcSearchBlockBase` plugin is provided to help build XTC Search blocks.
- xtc_page

### `xtcsearch_filter`

<u>Service:</u> `plugin.manager.xtcsearch_filter`

### `xtcsearch_filter_type`

<u>Service:</u> `plugin.manager.xtcsearch_filter_type`

12 plugins are provided by `xtcsearch`:

- select
- checkbox
- fullltext
- autocomplete
- exclude
- checkbox_and
- iterativeCheckbox
- comingEvents
- range
- dateSelect
- dateRange
- thisMonth

### `xtcsearch_pager`

<u>Service:</u> `plugin.manager.xtcsearch_pager`

3 plugins are provided by `xtcsearch`:

- page
- more: using Masonry style
- nopager

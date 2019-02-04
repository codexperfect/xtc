# XTC Plugins

4 plugin managers are defined in `xtc`.

### `xtc_handler` plugin manager

<u>Service:</u> `plugin.manager.xtc_handler`

8 plugins are provided by `xtcfile`:

- csv
- html
- json
- markdown
- mkdocs
- readme
- text
- yaml

### `xtc_profile` plugin manager

<u>Service:</u> `plugin.manager.xtc_profile`

4 disabled plugins examples are provided by `xtcelastica` in `xtcelastica.xtc_profiles.yml.dist`:

- account-by-id
- known-doc
- index-doc
- unindex-doc 

6 disabled plugins examples are provided by `xtcfile` in `xtcfile.xtc_profiles.yml.dist`:

- test_text
- test_html
- test_csv
- test_yaml
- test_json
- test_md
 
As a complement, `xtcfile` module implements dynamic profiles to provide:

- In-line **Readme files** in the Drupal administration area: used for all existing modules.
- In-line Documentation based on **MkDocs** standards: used in the `xtc` module.
- A **API function** that can be used to write the module Help page in a `help/help.md` file: used in every `xtc` modules.
 
### `xtc_request` plugin manager

<u>Service:</u> `plugin.manager.xtc_request`

> These requests are consumed by `XtcRequest*` + `Client*`: this approach uses directly raw **elasticsearch** library. It is now deprecated. `xtcsearch` approach (using object **elastica** library) should be privileged.

### `xtc_server` plugin manager

<u>Service:</u> `plugin.manager.xtc_server`

1 disabled plugin example is provided by `xtcelastica` in `xtcelastica.xtc_servers.yml.dist`.

This plugin helps to describe a server that can be used by other plugins such as `xtcelastica`, `xtcguzzle` or `xtcsearch`.



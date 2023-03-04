## WP API Plugin

A simple WordPress plugin that fetches and manages API.

### Table of contents

1. [Installation](#installation)
2. [Features](#features)
3. [WP-CLI](#wp-cli)

#### Installation

- Clone this repository in your `wp-content/plugins` directory.
- Run `npm install` and `composer install` on terminal on your newly created `wp-api-plugin` directory
- Run `npm start` to start development
- Activate the plugin in the Plugins menu inside WordPress Admin.

#### Features

1. Fetches an external API and store its content in a transient
2. A new internal API to render the results with caching
3. Gutenberg block wich calls dynamically the plugin API to get content, with option to hide columns
4. Admin page with the content of the API and option to purge the cache
5. WP-CLI command to purge the cache manually
6. Multilingual-ready

#### WP-CLI

To use the terminal commands, WP-CLI needs to be installed on you WP installation.

Available commands:
- `wp clear_users_cache`: Purge the plugin cache

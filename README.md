# rainlab-blog-api

[![Build](https://img.shields.io/circleci/build/github/scottbedard/rainlab-blog-api)](https://circleci.com/gh/scottbedard/rainlab-blog-api)
[![Coverage](https://img.shields.io/codecov/c/github/scottbedard/rainlab-blog-api)](https://codecov.io/gh/scottbedard/rainlab-blog-api)
[![MIT License](https://img.shields.io/github/license/scottbedard/rainlab-blog-api?color=blue)](https://github.com/scottbedard/rainlab-blog-api/blob/master/LICENSE)

> *Warning:* This plugin is a work in progress, and is not ready for use by anyone. Breaking changes may happen at any time.

A simple and extendable HTTP API for [RainLab.Blog](https://github.com/rainlab/blog-plugin).

## Installation & configuration

To install the API, execute the following command from the root off your October installation.

```bash
git clone git@github.com:scottbedard/rainlab-blog-api.git plugins/bedard/rainlabblogapi
```

By default, all routes are grouped behind a `/api/rainlab/blog` prefix. To override this, add the following to a `.env` file at the root of your October installation. Alternatively, you can use October's [file based configuration](https://octobercms.com/docs/plugin/settings#file-configuration).

```
RAINLAB_BLOG_API_PREFIX="/your/custom/prefix"
```

To disable the API completely, set the following environment variable.

```
RAINLAB_BLOG_API_ENABLE=false
```

## License

[MIT](https://github.com/scottbedard/rainlab-blog-api/blob/master/LICENSE)

Copyright (c) 2020-present, Scott Bedard.

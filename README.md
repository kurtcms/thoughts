# Thoughts: A Blank Canvas Hugo Theme for Thoughts of All Sorts

Building upon the awesome [Bootstrap 5](https://github.com/twbs/bootstrap) CSS framework, Thoughts is a blank canvas [Hugo](https://github.com/gohugoio/hugo) theme for thoughts of all sorts.

<kbd>![Thoughts: A Blank Canvas Hugo Theme for Thoughts of All Sorts](https://github.com/kurtcms/thoughts/blob/master/screenshot.png)</kbd>

A detailed walk-through is available [here](https://kurtcms.org/from-wordpress-to-hugo/).

## Installation

Download a copy of the themme with `git submodule`

```shell
$ cd /hugo/
$ git init
$ git submodule add https://github.com/kurtcms/thoughts themes/thoughts
$ git submodule update --init --recursive
```

Copy the provided configuration file.

```shell
$ cp /hugo/themes/thoughts/config.toml /hugo/config.toml
```

Modify the parameters accordingly.

```shell
$ nano /hugo/config.toml
```
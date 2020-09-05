# Twitter Clone

This repository stores an application similar to Twitter.

![Homepage](https://raw.githubusercontent.com/monoprosito/twitter_clone/master/home-page.png)

# Getting Started

To deploy the local application, you need few requirements installed

## Prerequisites

- [PHP](https://www.php.net/)
- A Web Server (like [Apache](https://httpd.apache.org/), [Nginx](https://www.nginx.com/), etc...)
- [Composer](https://getcomposer.org/download/)

## Installation

1. Clone the repo

```bash
git clone https://github.com/monoprosito/twitter_clone.git
```

2. Update your Apache configuration file (`httpd.conf`) / Nginx configuration file (`default`) configuration file, like this:

```
# Where WEB_SERVER_PATH is the root folder of your web server

DocumentRoot "${WEB_SERVER_PATH}/twitter_clone/public"
<Directory "${WEB_SERVER_PATH}/twitter_clone/public">
    ...

</Directory>
```

3. Generate autoload files

This project does not require any dependency, however it is necessary to generate an `autoload` file.

```bash
composer install
```

# License

Distributed under the MIT License. See LICENSE for more information.

# Contact

Santiago Arboleda Londoño - [@msarboledal](https://twitter.com/msarboledal) - [monoprosito@gmail.com](mailto:monoprosito@gmail.com)

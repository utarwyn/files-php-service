<h1 align="center">FilesService</h1>

<h4 align="center">
A simple service for your web-based files.
<br>
Works with PHP 5.6+
</h4>

<p align="center">
    <a href="https://github.com/utarwyn/files-php-service/actions?query=workflow%3ABuild"><img src="https://github.com/utarwyn/files-php-service/workflows/Build/badge.svg" alt="Publishing status"></a>
    <a href="https://github.com/utarwyn/files-php-service/actions?query=workflow%3APublish"><img src="https://github.com/utarwyn/files-php-service/workflows/Publish/badge.svg" alt="Publishing status"></a>
    <a href="https://packagist.org/packages/utarwyn/files-php-service"><img src="https://poser.pugx.org/utarwyn/files-php-service/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://github.com/utarwyn/files-php-service/blob/master/LICENSE"><img src="https://poser.pugx.org/utarwyn/files-php-service/license.svg" alt="License"></a>
</p>

FilesService is a **lightweight self-hosted service** which provides an easy way to manage web-based files.
It supplies a documented **RESTful API** and an authentication system based on **OAuth2** to store files in a protected bucket.

Installation
------------

1. Install the service with Composer:\
   `composer create-project utarwyn/files-php-service`
2. Move file `.env.example` to `.env` and configure it.
3. Use Nginx or Apache to provide an access to the `public` folder.

Use it with Docker
------------

1. Pull the latest image from [DockerHub][1]:\
   `docker pull utarwyn/files-php-service`
2. Create a folder to store uploaded files somewhere.
3. Create a `.env` file based on the `.env.example` in the repository.
4. Start the Docker container by providing their paths:\
   `docker run -v /home/.env:/app/.env -v /home/storage:/app/storage -p 80:8080 utarwyn/files-php-service`

Documentation
------------

> Soon!

License
--------

FilesService is open-sourced software licensed under the [MIT license][2].

---
> GitHub [@utarwyn][3] &nbsp;&middot;&nbsp; Twitter [@Utarwyn][4]

[1]: https://hub.docker.com/r/utarwyn/files-php-service
[2]: https://opensource.org/licenses/MIT
[3]: https://github.com/utarwyn
[4]: https://twitter.com/Utarwyn

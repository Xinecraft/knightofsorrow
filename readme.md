## KnightofSorrow Website Source

[![Build Status](https://travis-ci.org/kinnngg/knightofsorrow.svg)](https://travis-ci.org/kinnngg/knightofsorrow)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://github.com/kinnngg/knightofsorrow)

KnightofSorrow is a website for SWAT4 Servers. This website is used to rank players of a SWAT4 servers.
Website is developed with Laravel 5.1 LTS framework for backend and Bootstrap 3 for frontend.
Server tracking is implemented with the help of `julia/tracker` that can be found at my repo list.

Live Server Viewer is impleted with modified `julia/gs1` and `kinnngg/chattracker` which are not public repo yet.

## Installation

To install clone the repo:

``git clone https://www.github.com/kinnngg/knightofsorrow.git``

``cd knightofsorrow``

``composer install``

``php artisan key:generate``

``php artisan migrate``

``php artisan db:seed``


## Contributing

Please submit pull request for that :)

### License

The KnightofSorrow website source is open-sourced licensed under the [MIT license](http://opensource.org/licenses/MIT)
# Book My House

A simple house booking system built with PHP.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing
purposes.

### Prerequisites

You'll need the following installed on your system:

- PHP 8.0 or higher
- Composer
- SQLite3 (usually included with PHP)
- A web server (Apache/Nginx) or PHP's built-in server

### Installing

1. Install PHP dependencies
    ```bash
    composer install
    ```

2. Start the development server
    ```bash
    php -S localhost:8000 -t public/
    ```

3. Open http://localhost:8000 in your browser

The application will automatically create the SQLite database and sample data on first run.

## Running the tests

For automated tests, we are using PHPUnit (when tests are available)

### End to end tests

You can run the test suite with `composer test` (when implemented)

### Coding style checks

PSR-12 coding standards are recommended for this project.

## Deployment

Currently we don't have deployment workflow as it's just a demo application.

For production deployment:
1. Configure your web server to serve files from the `public/` directory
2. Ensure the `database/` directory is writable
3. Set appropriate file permissions

## Built With

- [PHP](https://www.php.net/) - Core language
- [SQLite](https://www.sqlite.org/) - Database
- [Composer](https://getcomposer.org/) - Dependency management

## Contributing

We are not accepting Pull Requests.

## Versioning

We are using rolling release to update this demo app from time to time.

## Authors

- [App Maintainers ltd.](https://www.appmaintainers.com)
- See [individual contributors](https://github.com/AppMaintainers/book-my-house/graphs/contributors) on github
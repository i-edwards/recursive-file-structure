### Usage
Start the server with `docker compose up -d`

Exec into the server with `docker composer exec -it web-server bash`

Install packages with `composer install`

Run the tests with `./vendor/bin/phpunit tests/`

Load the data with `php load-data.php`

View the search page by visiting `localhost` in the browser

View search results by typing in the box and clicking `Search`

The database is available on port 3306 with the default user/pass of `root/root`. This can be changed using environment variables - see `docker-compose.yml`.

### Database design rationale
Any database engine can be used here, ultimately. The only strategy that won't work is trying to store the entire file structure in one massively nested JSON document. MongoDB for example, has a limit of 100 levels of nesting, so will run into issues eventually. But flat JSON documents that reference parent IDs will still work, and Mongo supports BSON for file data too.

I chose MariaDB because the number of properties are known, and it can enforce parental referential integrity.

Only one database entity is required - in the abstract, a file and a directory are essentially the same thing, only a directory can have children beneath it.

I included a flag in the table to mark an entity as a directory. This isn't strictly necessary, as you can check if there's file data to make the distinction, but it makes querying easier in the case there are empty files.

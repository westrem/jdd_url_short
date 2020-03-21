# Config

Create a `config.php` in the root, containing:

```
$dbdsn = 'mysql:host=;port=;dbname=;charset=utf8mb4';
$dbuser = '';
$dbpass = '';

$google_analytics = 'UA-';
```

# Database

Make sure the database has correct collation:

```
SET NAMES utf8mb4;
ALTER DATABASE database_name CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
```

Make sure the `links` table has correct character set and collation:

```
ALTER TABLE links CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Make sure the columns in `links` table have correct character set and collation:

```
ALTER TABLE links CHANGE title title VARCHAR(140) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE links CHANGE description description VARCHAR(140) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
```

# Web Server Setup

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000/?q=ID` in your browser to try the redirect.

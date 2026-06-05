# PurpleRoots PHP Reconstructed

This version converts the original frontend-only PurpleRoots prototype into a PHP project with reusable includes, MySQL configuration, product CRUD pages, marketplace, farmer profile, dashboard, analytics, API endpoints, and traceability pages.

## Local setup with XAMPP
1. Copy the `PurpleRoots_PHP_Reconstructed` folder into `xampp/htdocs/`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and import `database/purpleroots.sql`.
4. Check the credentials in `config/database.php`:
   - host: `localhost`
   - database: `purpleroots`
   - username: `root`
   - password: empty by default for XAMPP
5. Visit: `http://localhost/PurpleRoots_PHP_Reconstructed/index.php`

## Main pages
- `index.php`
- `marketplace.php`
- `farmer-profile.php`
- `dashboard.php`
- `analytics.php`
- `products/view_products.php`
- `products/add_product.php`
- `traceability/trace_product.php`
- `traceability/generate_qr.php`
- `api/products.php`
- `api/check_email.php`

## Note
If the database is not connected yet, the app will still show built-in demo data. Product add/edit/delete requires MySQL import to persist changes.

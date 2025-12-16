# Portfolio Hosting Guide (InfinityFree)

This guide walks you through deploying your portfolio on InfinityFree, setting up the database, and testing the contact form.

## Prerequisites
- InfinityFree account
- Your project files: `index.html`, `style.css`, `script.js`, `contact.php`, `config.php`, `db.sql`
- Optional: An `images/` folder with your hero photo referenced in `index.html`

## 1) Create Site & Database on InfinityFree
1. Sign in and create a new website (subdomain or custom domain).
2. Open the Control Panel (vPanel).
3. Create a MySQL Database:
   - Go to MySQL Databases.
   - Create DB and note these values:
     - Host: `sqlXXX.epizy.com`
     - Username: `epiz_XXXXXXXX`
     - Password: your DB password
     - Database: `epiz_XXXXXXXX_portfolio` (actual name shown in panel)

## 2) Configure Database Credentials
Update `config.php` with your hosting values:
```php
$DB_HOST = 'sqlXXX.epizy.com';
$DB_USER = 'epiz_XXXXXXXX';
$DB_PASS = 'your_password';
$DB_NAME = 'epiz_XXXXXXXX_portfolio';
```
Tip: Do not use `127.0.0.1` or `root` on InfinityFree.

## 3) Upload Your Files
Use the File Manager or FTP to upload into `htdocs`:
- `index.html`, `style.css`, `script.js`, `contact.php`, `config.php`, `db.sql`
- Create `images/` and upload your hero photo (match the path in `index.html`).

## 4) Create the Table
Shared hosting already provides the database; only run the table creation. In phpMyAdmin:
1. Select your database (`$DB_NAME`).
2. Paste and run this SQL (skip CREATE DATABASE/USE):
```sql
CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  project VARCHAR(120) NOT NULL,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(160) NOT NULL,
  notes TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 5) Verify Backend Connectivity
- Visit `https://your-domain/contact.php` directly.
  - You should see a JSON error: `{"success":false,"message":"Method not allowed"}` for GET.
  - This confirms the file is reachable.

## 6) Test the Contact Form
1. Open your site homepage.
2. Submit the form with valid inputs.
3. Expected result: toast saying "Signal sent. I will respond soon.".
4. Check `contact_messages` in phpMyAdmin for the inserted row.

## Local Testing (Optional)
- Use XAMPP on Windows:
  - Put the project in `c:\xampp\htdocs\PORTFOLIO`.
  - Start Apache and MySQL.
  - In `config.php`, set local credentials:
    ```php
    $DB_HOST = '127.0.0.1';
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'portfolio';
    ```
  - Import `db.sql` into a local DB (you can keep CREATE DATABASE/USE locally).
  - Visit `http://localhost/PORTFOLIO/index.html`.

## Troubleshooting
- Broken image in hero:
  - Ensure the file exists in `images/` and the path matches `index.html`.
- Form returns "Failed to save message":
  - Check table exists and credentials in `config.php` are correct.
- Database connection failed:
  - Verify the MySQL host and user from InfinityFree panel.
  - Password must match exactly; try resetting if unsure.
- JSON parse error in browser:
  - Ensure `contact.php` outputs valid JSON; avoid stray whitespace/HTML.
- CORS issues:
  - Use relative form action (`contact.php`) and host all files on the same domain.

## Security Notes
- Credentials live in `config.php`; never commit real production passwords to public repos.
- Error messages are generic by design; for detailed logs, use server-side logging (disabled on free hosts).

## Next Steps
- Replace "Your Name" and update hero photo in `index.html`.
- Consider adding an email notification service later (transactional SMTP/API), mindful of shared host restrictions.

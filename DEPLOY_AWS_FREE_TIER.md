Deploying this Laravel app to AWS (Free Tier) — concise steps
1) Prepare AWS account
   - Sign up for AWS and enable Free Tier.
2) Launch an EC2 instance (Amazon Linux 2 or Ubuntu)
   - Instance type: t2.micro / t3.micro (Free Tier eligible).
   - Allow ports: 22 (SSH), 80 (HTTP), 443 (HTTPS).
3) SSH into instance
   - sudo apt update && sudo apt upgrade -y (Ubuntu)
4) Install stack
   - Install PHP 8.x, nginx, mysql-client, composer, unzip, git, php-extensions (pdo_mysql, mbstring, xml, zip, gd, curl).
   - Example (Ubuntu): apt install nginx php-fpm php-mysql php-xml php-mbstring php-curl unzip git -y
   - Install Composer: curl -sS https://getcomposer.org/installer | php && sudo mv composer.phar /usr/local/bin/composer
5) Clone repo & set permissions
   - git clone <your-repo> /var/www/vol
   - cd /var/www/vol
   - composer install --no-dev --optimize-autoloader
   - cp .env.example .env ; update .env values for production (APP_ENV=production, APP_URL)
   - php artisan key:generate
   - php artisan storage:link
   - chown -R www-data:www-data storage bootstrap/cache
6) Configure nginx
   - Create site config pointing root to /var/www/vol/public and set index to index.php
   - Use fastcgi_pass to PHP-FPM socket (e.g., unix:/run/php/php8.1-fpm.sock)
   - Restart nginx & php-fpm
7) Database
   - For production use RDS (free tier) or install MySQL on EC2 (not recommended)
   - Create database and update DB_* env vars
   - Run php artisan migrate --force
8) Queue & background jobs (optional)
   - For queues, set up Supervisor to run php artisan queue:work
9) SSL
   - Use Let's Encrypt Certbot to issue free certificates for your domain (requires domain pointing to EC2 public IP)
10) Notes & housekeeping
   - Ensure .env values are correct and never commit .env
   - Use IAM permissions and secure SSH keys
   - Backups: use S3 for uploads and RDS snapshots for DB
   - Monitor usage to stay within free tier limits

If you want, I can produce an nginx config example, Supervisor config, and step-by-step commands tailored to Ubuntu 22.04.

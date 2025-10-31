# Volunteer Platform

A modern Laravel-based platform connecting volunteers and organizations. Users can register as volunteers or organizations, claim and complete opportunities, earn badges and certificates, and sign up with Google. The platform is designed for scalability, security, and ease of use.

## Features

- Volunteer and Organization registration (email or Google)
- Opportunities: post, claim, complete, and earn points
- Dynamic leaderboard for volunteers and organizations
- Profile management: avatar upload, skills, badges, certificates
- Testimonials and feedback system
- Organization verification and gallery
- Responsive, modern UI with Bootstrap 5
- SEO optimized (meta tags, OG tags)
- AWS Free Tier deployment ready

## Screenshots

![Landing Page](public/screenshots/landing.png)
![Opportunities](public/screenshots/opportunities.png)
![Profile](public/screenshots/profile.png)

## Getting Started

### Prerequisites

- PHP 8.1+
- Composer
- MySQL (or compatible)
- Node.js (for asset compilation, optional)
- [Laravel Socialite](https://laravel.com/docs/socialite) (for Google OAuth)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/volunteer-platform.git
   cd volunteer-platform
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy and configure `.env`:
   ```bash
   cp .env.example .env
   # Edit .env for DB, APP_URL, Google OAuth, etc.
   ```

4. Generate app key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Link storage for avatars/certificates:
   ```bash
   php artisan storage:link
   ```

7. (Optional) Compile assets:
   ```bash
   npm install && npm run build
   ```

8. Start the server:
   ```bash
   php artisan serve
   ```

### Google OAuth Setup

See [google-oauth-setup.md](../google-oauth-setup.md) for step-by-step instructions.

### AWS Free Tier Deployment

See [DEPLOY_AWS_FREE_TIER.md](DEPLOY_AWS_FREE_TIER.md) for concise deployment steps.

## Usage

- Register as a volunteer or organization
- Organizations can post opportunities
- Volunteers can claim and complete opportunities
- Earn points, badges, and certificates
- Leave and view testimonials
- Manage your profile and skills

## Project Structure

- `app/Http/Controllers` — Main controllers
- `app/Models` — Eloquent models
- `resources/views` — Blade templates (modular, partials)
- `routes/web.php` — Route definitions
- `public/logo.png` — Your logo (used in header and hero)
- `public/screenshots/` — Add screenshots for documentation

## Credits

- Developed by Md. Mahtab Hossain Bhuiyan
- Built with [Laravel](https://laravel.com), [Bootstrap 5](https://getbootstrap.com), [Socialite](https://laravel.com/docs/socialite)

## License

MIT

---

For bug reports or feature requests, open an issue or contact the maintainer.

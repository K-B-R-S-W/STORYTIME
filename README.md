# STORYTIME 🎬

A dynamic web application for movie enthusiasts to explore and discover information about various movies. This platform provides detailed information about movies, including popular titles like Oppenheimer, Barbie, Black Adam, and more.

## Features 🌟

- Movie information and details
- User feedback system
- Location-based services
- Contact and About Us pages
- Responsive design
- Interactive user interface

## AI Chatbot 🤖

StoryTime includes an integrated AI-powered chatbot to assist users with:
- Movie information and recommendations (limited to available movies)
- Booking assistance and seat selection
- Theater facilities and showtime details
- Special offers and promotions

## Technologies Used 💻

- PHP
- MongoDB
- Bootstrap
- Custom CSS
- JavaScript
- Vimeo Player Integration
- Mobirise Assets
- Animated Components

## Project Structure 📁

```
STORYTIME/
├── assets/           # Core assets (CSS, JS, images, fonts, themes, plugins)
├── build/            # Build scripts and assets
├── css/              # Custom stylesheets (e.g., font-awesome.css, style.css)
├── fonts/            # Typography resources (FontAwesome, etc.)
├── images/           # Image assets (banners, seat maps, etc.)
├── includes/         # PHP includes (e.g., chat-include.php)
├── components/       # UI components (e.g., chat-widget.php)
├── ai-backend/       # AI backend scripts (e.g., main.py)
├── js/               # JavaScript files (e.g., payment.js, jQuery)
├── pages/            # Component pages (addmovie.php, booking.php, dashboard.php, etc.)
├── ripple/           # Ripple effect components (ripple.js, ripple.css)
├── vendor/           # Composer dependencies (excluded from Git, see below)
├── *.php             # Main PHP files for movies, feedback, contact, etc.
├── .env              # Environment variables (excluded from Git)
├── .gitignore        # Git ignore rules
├── composer.json     # Composer dependencies definition
├── composer.lock     # Composer lock file
├── README.md         # Project documentation
```

## Prerequisites 🔧

- PHP 7.4 or higher
- MongoDB
- Web server (e.g., Apache, XAMPP)
- Composer (PHP package manager)

## Installation 🚀

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/STORYTIME.git
   ```

2. **Navigate to the project directory:**
   ```bash
   cd STORYTIME
   ```

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Create a `.env` file in the root directory and configure your environment variables:**
   ```
   DB_CONNECTION=MONGODB_URI
   API_KEY for Chatbot
   ```

5. **Start your local web server and navigate to the project URL.**

## Configuration ⚙️

- Configure your web server to point to the project directory
- Ensure MongoDB is running and accessible
- Check that all required PHP extensions are enabled

## Usage 📖

1. Access the homepage through your web browser
2. Browse through different movie sections
3. Use the navigation to explore features like:
   - Movie details
   - Location services
   - Feedback system
   - Contact information

## Contributing 🤝

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License 📄

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact 📧

Your Name - [your.email@example.com](mailto:your.email@example.com)

Project Link: [https://github.com/yourusername/STORYTIME](https://github.com/yourusername/STORYTIME)

## Acknowledgments 🙏

- Bootstrap for the responsive framework
- MongoDB for database solutions
- All contributors who have helped with the project

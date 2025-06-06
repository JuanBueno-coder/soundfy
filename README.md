# 🎵 Soundfy - Full-Stack Music Streaming Platform

> **Spotify-inspired music streaming platform built with Laravel 10 & modern PHP practices**

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

## 🎯 Project Overview

Soundfy is a comprehensive music streaming platform that demonstrates enterprise-level PHP development skills. Built as a portfolio project to showcase modern Laravel architecture, API design, and scalable backend development practices.

## ✨ Key Features (Planned)

- 🔐 **Advanced Authentication** - JWT-based API authentication
- 🎵 **Music Management** - Upload, organize, and stream audio files
- 🎨 **Artist & Album Management** - Complete metadata handling
- 📱 **Playlist System** - Create, share, and manage playlists
- 💳 **Payment Integration** - Stripe-powered subscription system
- 🔍 **Advanced Search** - Full-text search with filters
- 📊 **Analytics Dashboard** - Real-time streaming metrics
- 🌐 **RESTful API** - Comprehensive API with OpenAPI documentation

## 🏗️ Architecture & Technical Stack

### Backend
- **Framework**: Laravel 10.x
- **PHP**: 8.4
- **Database**: MySQL 8.0
- **Testing**: PHPUnit
- **API**: RESTful with JSON responses

### Development Tools
- **Dependency Management**: Composer
- **Database Migrations**: Laravel Schema Builder
- **API Documentation**: OpenAPI/Swagger (planned)
- **CI/CD**: GitHub Actions (planned)

## 📊 Database Design

### Core Entities
```
users (authentication & profiles)
artists (music creators)
albums (music collections)
songs (individual tracks)
playlists (user collections)
playlist_song (many-to-many pivot)
```

### Relationships
- **1:N** - Artist → Albums → Songs
- **1:N** - User → Playlists
- **M:N** - Playlists ↔ Songs (with pivot table)

## 🚀 Getting Started

### Prerequisites
- PHP 8.4+
- Composer
- MySQL 8.0+
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/JuanBueno-coder/soundfy.git
   cd soundfy
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   ```bash
   # Configure your .env file with database credentials
   php artisan migrate
   ```

5. **Start development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to see the application.

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 📚 Development Roadmap

### Phase 1: Foundation (Current)
- [x] Project setup & architecture
- [x] Database design & migrations
- [x] Basic Laravel configuration
- [ ] Core models & relationships
- [ ] Authentication system

### Phase 2: Core Features
- [ ] User registration & authentication
- [ ] Artist & album management
- [ ] Music upload & streaming
- [ ] Basic playlist functionality

### Phase 3: Advanced Features
- [ ] Payment integration (Stripe)
- [ ] Advanced search & filtering
- [ ] Real-time features (WebSockets)
- [ ] API documentation

### Phase 4: Production Ready
- [ ] Performance optimization
- [ ] Comprehensive testing
- [ ] CI/CD pipeline
- [ ] Production deployment

## 🛠️ Technical Highlights

This project demonstrates:

- **Clean Architecture**: Separation of concerns with proper MVC structure
- **Database Design**: Normalized schema with efficient relationships
- **Modern PHP**: Using PHP 8.4 features and Laravel best practices
- **Testing Strategy**: Comprehensive test coverage with PHPUnit
- **API Design**: RESTful endpoints following industry standards
- **Security**: JWT authentication, input validation, and SQL injection prevention

## 📝 Code Quality

- **PSR Standards**: Following PSR-12 coding standards
- **Type Declarations**: Full type hinting and return types
- **Documentation**: Comprehensive inline documentation
- **Testing**: Unit and feature tests for all critical functionality

## 🤝 Contributing

This is a portfolio project, but feedback and suggestions are welcome! Feel free to:

1. Fork the repository
2. Create a feature branch
3. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 📧 Contact

**Juan** - Aspiring Backend Developer specializing in PHP/Laravel

- GitHub: [@JuanBueno-coder](https://github.com/JuanBueno-coder)
- LinkedIn: [Juan Antonio Bueno Rodríguez](https://www.linkedin.com/in/juan-antonio-bueno-4b823b236/)
- Email: your.email@example.com

---

*Built with ❤️ and Laravel | Showcasing modern PHP development practices*
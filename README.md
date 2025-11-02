# phpDoc Generator v0.4.7

🚀 **PHP Documentation Generator** - Automatically generates beautiful HTML documentation from PHP files with DocBlock support.

## ✨ Features

- ✅ Recursive directory scanning
- ✅ Parses PHP classes, functions, and methods
- ✅ Full PHPDoc comment support (@param, @return, @description)
- ✅ Interactive tree structure navigation
- ✅ Modern dark theme UI (VS Code inspired)
- ✅ HTTP authentication with .htaccess
- ✅ Multi-language support with language picker (6 languages)
- ✅ Expandable/collapsible method details
- ✅ Real-time search functionality
- ✅ Collapsible directory tree on main page

## 📦 Requirements

- PHP 7.4 or higher
- Apache web server (for .htaccess authentication - optional)

## 🚀 Quick Start

### 1. Configuration

Edit the `$settings` array in `generator.php`:
```php
$settings = [
    // Directories to scan (recursive)
    'directories' => [
        '../your-project/app/Controllers',
        '../your-project/app/Models',
    ],
    
    // Output directory
    'output_dir' => 'output',
    
    // Exclude directories
    'exclude_dirs' => ['vendor', 'cache', 'node_modules'],
    
    // HTTP authentication (optional)
    'http_auth' => [
        // 'admin' => 'password123',
    ],
    
    // Language (en, sk, cs, de, ru, ja)
    'language' => 'en',
    
    // Available languages in documentation
    'available_languages' => ['en', 'sk', 'cs', 'de', 'ru', 'ja'],
];
```

### 2. Generate Documentation

**Method A: Direct Browser Access**
1. Upload `generator.php` to your server (e.g., `/public_html/phpdoc/`)
2. Open `http://your-domain.com/phpdoc/generator.php` in your browser
3. Documentation will be generated automatically in the `output/` subdirectory
4. View the result at `http://your-domain.com/phpdoc/output/index.html`

**Method B: Using Configuration Interface** *(Coming soon - in development)*
1. Use the web-based configuration tool
2. Fill in your project settings
3. Download pre-configured `generator.php`
4. Upload to your server and open in browser (Method A)

> **Note:** The web-based configuration interface is currently being prepared and will be available in the near future.

### 3. View Documentation

Open `output/index.html` in your web browser.

## 🌐 Live Demo

- **Generator:** https://phpdoc.kukis.sk/demo/generator.php
- **Documentation:** https://phpdoc.kukis.sk/demo/output/

## 📖 Usage Example

### Input (PHP file with DocBlocks):
```php
<?php
/**
 * User authentication class
 */
class UserAuth {
    /**
     * Authenticate user credentials
     * 
     * @param string $username User's username
     * @param string $password User's password
     * @return bool Authentication result
     */
    public function login($username, $password) {
        // Authentication logic
        return true;
    }
}
```

### Output:

Beautiful HTML documentation with:
- Class overview
- Method signatures
- Parameter descriptions
- Return types
- Searchable interface

## 🔒 HTTP Authentication

To enable password protection:
```php
'http_auth' => [
    'admin' => 'secure_password',
    'user' => 'another_password',
],
```

The generator will automatically create `.htaccess` and `.htpasswd` files.

## 🌍 Supported Languages

The documentation interface supports 6 languages with a built-in language picker:

- 🇬🇧 **English (en)** - default
- 🇸🇰 **Slovak (sk)** - Slovenčina
- 🇨🇿 **Czech (cs)** - Čeština
- 🇩🇪 **German (de)** - Deutsch
- 🇷🇺 **Russian (ru)** - Русский
- 🇯🇵 **Japanese (ja)** - 日本語

Change default language in settings: `'language' => 'en'`

Users can switch languages directly in the documentation interface using the language picker (saves preference to localStorage).

## 📁 Project Structure
```
phpDoc/
├── generator.php          # Main generator script
└── output/               # Generated documentation
    ├── index.html       # Main index
    ├── .htaccess        # Apache protection (optional)
    ├── .htpasswd        # HTTP authentication users (if enabled)
    └── ...              # Generated files
```

## 📝 License

MIT License

## 👨‍💻 Author

Created for developers who need quick and beautiful PHP documentation.

## 🐛 Issues & Contributions

Found a bug or have a feature request? Feel free to open an issue or submit a pull request!

---

**Version:** 0.4.7  
**Last Updated:** October 2025
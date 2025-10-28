# phpDoc Generator v0.4.3

🚀 **PHP Documentation Generator** - Automatically generates beautiful HTML documentation from PHP files with DocBlock support.

## ✨ Features

- ✅ Recursive directory scanning
- ✅ Parses PHP classes, functions, and methods
- ✅ Full PHPDoc comment support (@param, @return, @description)
- ✅ Interactive tree structure navigation
- ✅ Modern dark theme UI (VS Code inspired)
- ✅ HTTP authentication with .htaccess
- ✅ Multi-language support (Slovak, English, German...)
- ✅ Expandable/collapsible method details
- ✅ Real-time search functionality

## 📦 Requirements

- PHP 7.4 or higher
- Apache web server (for .htaccess authentication)
- Command line access (for generation)

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
    
    // Language (sk, en, de)
    'language' => 'en',
];
```

### 2. Generate Documentation

Run from command line:
```bash
php generator.php
```

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

- **Slovak (sk)** - default
- **English (en)**
- **German (de)**

Change in settings: `'language' => 'en'`

## 📁 Project Structure
```
phpDoc/
├── generator.php          # Main generator script
├── output/               # Generated documentation
│   ├── index.html       # Main index
│   ├── .htaccess        # Apache protection
│   └── ...              # Generated files
└── README.md            # This file
```

## 🎨 Screenshots

The generated documentation features:
- Clean, modern dark theme interface
- Syntax-highlighted code elements
- Collapsible method documentation
- Breadcrumb navigation
- Project statistics dashboard

## 📝 License

MIT License - feel free to use, modify, and distribute.

## 👨‍💻 Author

Created with ❤️ for developers who need quick and beautiful PHP documentation.

## 🐛 Issues & Contributions

Found a bug or have a feature request? Feel free to open an issue or submit a pull request!

---

**Version:** 0.4.2  
**Last Updated:** October 2025

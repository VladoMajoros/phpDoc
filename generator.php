
<?php
/**
 * phpDocGenerator v0.4.5
 * PHP Documentation Output Creator
 * Generates HTML documentation from PHP files
 */

// @CONFIG_START - User editable configuration section
// ============================================================================
// USER CONFIGURATION - Modify values below
// ============================================================================

$settings = [
    // Directories to scan (will be traversed recursively)
    'directories' => [
        './wp/wp-content/plugins',
        './wp/wp-includes',
    ],

    // Output directory for documentation (relative to generator.php)
    'output_dir' => 'output',

    // Directories to skip (e.g. vendor, cache)
    'exclude_dirs' => [
        'vendor',
        'cache',
        'logs',
        'tmp',
        'node_modules',
    ],

    // HTTP authentication - add multiple users
    // Leave empty array for public access
    'http_auth' => [
        // Format: 'username' => 'password'
        // 'admin' => 'password123',
        // 'user' => 'pass456',
    ],

    // Active language (en, sk, cs, de, ru, ja)
    'language' => 'en',
    
    // Available languages in documentation
    'available_languages' => ['en', 'sk', 'cs', 'de', 'ru', 'ja'],
];

// @CONFIG_END - Do not edit below this line unless you know what you're doing

// ============================================================================
// LANGUAGE DEFINITIONS
// ============================================================================

$languages = [
    'en' => [
        'name' => 'English',
        'native' => 'English',
        'flag' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="18" viewBox="0 0 640 480"><path fill="#012169" d="M0 0h640v480H0z"/><path fill="#FFF" d="m75 0 244 181L562 0h78v62L400 241l240 178v61h-80L320 301 81 480H0v-60l239-178L0 64V0z"/><path fill="#C8102E" d="m424 281 216 159v40L369 281zm-184 20 6 35L54 480H0zM640 0v3L391 191l2-44L590 0zM0 0l239 176h-60L0 42z"/><path fill="#FFF" d="M241 0v480h160V0zM0 160v160h640V160z"/><path fill="#C8102E" d="M0 193v96h640v-96zM273 0v480h96V0z"/></svg>'
    ],
    'sk' => [
        'name' => 'Slovak',
        'native' => 'Slovenčina',
        'flag' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="18" viewBox="0 0 640 480"><path fill="#ee1c25" d="M0 0h640v480H0z"/><path fill="#0b4ea2" d="M0 0h640v320H0z"/><path fill="#fff" d="M0 0h640v160H0z"/><path fill="#fff" d="M233 370.8c-43-20.7-104.6-61.9-104.6-143.2 0-81.4 4-118.4 4-118.4h201.3s3.9 37 3.9 118.4S276 350 233 370.8"/><path fill="#ee1c25" d="M233 360c-39.5-19-96-56.8-96-131.4s3.6-108.6 3.6-108.6h184.8s3.5 34 3.5 108.6C329 303.3 272.5 341 233 360"/><path fill="#fff" d="M241.4 209c10.7.2 31.6.6 50.1-5.6 0 0-.4 6.7-.4 14.4s.5 14.4.5 14.4c-17-5.7-38.1-5.8-50.2-5.7v41.2h-16.8v-41.2c-12-.1-33.1 0-50.1 5.7 0 0 .5-6.7.5-14.4s-.5-14.4-.5-14.4c18.5 6.2 39.4 5.8 50 5.6v-25.9c-9.7 0-23.7.4-39.6 5.7 0 0 .5-6.6.5-14.4 0-7.7-.5-14.4-.5-14.4 15.9 5.3 29.9 5.8 39.6 5.7-.5-16.4-5.3-37-5.3-37s9.9.7 13.8.7 13.8-.7 13.8-.7-4.8 20.6-5.3 37c9.7.1 23.7-.4 39.6-5.7 0 0-.5 6.7-.5 14.4s.5 14.4.5 14.4a119 119 0 0 0-39.7-5.7v26z"/><path fill="#0b4ea2" d="M233 263.3c-19.9 0-30.5 27.5-30.5 27.5s-6-13-22.2-13c-11 0-19 9.7-24.2 18.8 20 31.7 51.9 51.3 76.9 63.4 25-12 57-31.7 76.9-63.4-5.2-9-13.2-18.8-24.2-18.8-16.2 0-22.2 13-22.2 13S253 263.3 233 263.3"/></svg>'
    ],
    'cs' => [
        'name' => 'Czech',
        'native' => 'Čeština',
        'flag' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="18" viewBox="0 0 640 480"><path fill="#fff" d="M0 0h640v240H0z"/><path fill="#d7141a" d="M0 240h640v240H0z"/><path fill="#11457e" d="M360 240 0 0v480z"/></svg>'
    ],
    'de' => [
        'name' => 'German',
        'native' => 'Deutsch',
        'flag' => '<svg width="30" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><path fill="#ffce00" d="M0 320h640v160H0z"/><path d="M0 0h640v160H0z"/><path fill="#d00" d="M0 160h640v160H0z"/></svg>'
    ],
    'ru' => [
        'name' => 'Russian',
        'native' => 'Русский',
        'flag' => '<svg width="30" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><g fill-rule="evenodd" stroke-width="1pt"><path fill="#fff" d="M0 0h640v480H0z"/><path fill="#0039a6" d="M0 160h640v320H0z"/><path fill="#d52b1e" d="M0 320h640v160H0z"/></g></svg>'
    ],
    'ja' => [
        'name' => 'Japanese',
        'native' => '日本語',
        'flag' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="18" viewBox="0 0 640 480"><defs><clipPath id="jp-a"><path fill-opacity=".7" d="M-88 32h640v480H-88z"/></clipPath></defs><g fill-rule="evenodd" stroke-width="1pt" clip-path="url(#jp-a)" transform="translate(88 -32)"><path fill="#fff" d="M-128 32h720v480h-720z"/><circle cx="523.1" cy="344.1" r="194.9" fill="#bc002d" transform="translate(-168.4 8.6)scale(.76554)"/></g></svg>'
    ],
];

// ============================================================================
// LANGUAGE TRANSLATIONS
// ============================================================================

$translations = [
    'sk' => [
        'GENERATOR_HOME' => 'Domov',
        'GENERATOR_FILES' => 'Súborov',
        'GENERATOR_CLASSES' => 'Tried',
        'GENERATOR_FUNCTIONS' => 'Funkcií',
        'GENERATOR_PROJECT_STRUCTURE' => 'Štruktúra projektu',
        'GENERATOR_PARAMETERS' => 'Parametre',
        'GENERATOR_RETURN' => 'návrat',
        'GENERATOR_SEARCH_PLACEHOLDER' => '🔎 Hľadať funkcie...',
        'GENERATOR_CLASS' => 'trieda',
        'GENERATOR_FUNCTION' => 'funkcia',
        'GENERATOR_PROTECTED_AREA' => 'Chránená oblasť',
        'GENERATOR_AUTH_ENABLED' => 'HTTP autentifikácia zapnutá',
        'GENERATOR_AUTH_DISABLED' => 'HTTP autentifikácia vypnutá - verejný prístup',
        'GENERATOR_USERS' => 'Používatelia',
    ],
    'en' => [
        'GENERATOR_HOME' => 'Home',
        'GENERATOR_FILES' => 'Files',
        'GENERATOR_CLASSES' => 'Classes',
        'GENERATOR_FUNCTIONS' => 'Functions',
        'GENERATOR_PROJECT_STRUCTURE' => 'Project Structure',
        'GENERATOR_PARAMETERS' => 'Parameters',
        'GENERATOR_RETURN' => 'return',
        'GENERATOR_SEARCH_PLACEHOLDER' => '🔎 Search functions...',
        'GENERATOR_CLASS' => 'class',
        'GENERATOR_FUNCTION' => 'function',
        'GENERATOR_PROTECTED_AREA' => 'Protected Area',
        'GENERATOR_AUTH_ENABLED' => 'HTTP authentication enabled',
        'GENERATOR_AUTH_DISABLED' => 'HTTP authentication disabled - public access',
        'GENERATOR_USERS' => 'Users',
    ],
    'cs' => [
        'GENERATOR_HOME' => 'Domů',
        'GENERATOR_FILES' => 'Souborů',
        'GENERATOR_CLASSES' => 'Tříd',
        'GENERATOR_FUNCTIONS' => 'Funkcí',
        'GENERATOR_PROJECT_STRUCTURE' => 'Struktura projektu',
        'GENERATOR_PARAMETERS' => 'Parametry',
        'GENERATOR_RETURN' => 'návrat',
        'GENERATOR_SEARCH_PLACEHOLDER' => '🔎 Hledat funkce...',
        'GENERATOR_CLASS' => 'třída',
        'GENERATOR_FUNCTION' => 'funkce',
        'GENERATOR_PROTECTED_AREA' => 'Chráněná oblast',
        'GENERATOR_AUTH_ENABLED' => 'HTTP autentizace zapnuta',
        'GENERATOR_AUTH_DISABLED' => 'HTTP autentizace vypnuta - veřejný přístup',
        'GENERATOR_USERS' => 'Uživatelé',
    ],
    'de' => [
        'GENERATOR_HOME' => 'Startseite',
        'GENERATOR_FILES' => 'Dateien',
        'GENERATOR_CLASSES' => 'Klassen',
        'GENERATOR_FUNCTIONS' => 'Funktionen',
        'GENERATOR_PROJECT_STRUCTURE' => 'Projektstruktur',
        'GENERATOR_PARAMETERS' => 'Parameter',
        'GENERATOR_RETURN' => 'Rückgabe',
        'GENERATOR_SEARCH_PLACEHOLDER' => '🔎 Funktionen suchen...',
        'GENERATOR_CLASS' => 'Klasse',
        'GENERATOR_FUNCTION' => 'Funktion',
        'GENERATOR_PROTECTED_AREA' => 'Geschützter Bereich',
        'GENERATOR_AUTH_ENABLED' => 'HTTP-Authentifizierung aktiviert',
        'GENERATOR_AUTH_DISABLED' => 'HTTP-Authentifizierung deaktiviert - öffentlicher Zugang',
        'GENERATOR_USERS' => 'Benutzer',
    ],
    'ru' => [
        'GENERATOR_HOME' => 'Главная',
        'GENERATOR_FILES' => 'Файлов',
        'GENERATOR_CLASSES' => 'Классов',
        'GENERATOR_FUNCTIONS' => 'Функций',
        'GENERATOR_PROJECT_STRUCTURE' => 'Структура проекта',
        'GENERATOR_PARAMETERS' => 'Параметры',
        'GENERATOR_RETURN' => 'возврат',
        'GENERATOR_SEARCH_PLACEHOLDER' => '🔎 Поиск функций...',
        'GENERATOR_CLASS' => 'класс',
        'GENERATOR_FUNCTION' => 'функция',
        'GENERATOR_PROTECTED_AREA' => 'Защищённая область',
        'GENERATOR_AUTH_ENABLED' => 'HTTP-аутентификация включена',
        'GENERATOR_AUTH_DISABLED' => 'HTTP-аутентификация отключена - публичный доступ',
        'GENERATOR_USERS' => 'Пользователи',
    ],
    'ja' => [
        'GENERATOR_HOME' => 'ホーム',
        'GENERATOR_FILES' => 'ファイル',
        'GENERATOR_CLASSES' => 'クラス',
        'GENERATOR_FUNCTIONS' => '関数',
        'GENERATOR_PROJECT_STRUCTURE' => 'プロジェクト構造',
        'GENERATOR_PARAMETERS' => 'パラメータ',
        'GENERATOR_RETURN' => '戻り値',
        'GENERATOR_SEARCH_PLACEHOLDER' => '🔎 関数を検索...',
        'GENERATOR_CLASS' => 'クラス',
        'GENERATOR_FUNCTION' => '関数',
        'GENERATOR_PROTECTED_AREA' => '保護エリア',
        'GENERATOR_AUTH_ENABLED' => 'HTTP認証が有効',
        'GENERATOR_AUTH_DISABLED' => 'HTTP認証が無効 - パブリックアクセス',
        'GENERATOR_USERS' => 'ユーザー',
    ],
];

// ============================================================================
// DOCUMENTATION GENERATOR - do not edit below unless you know what you're doing
// ============================================================================

class phpDocGenerator {
    const VERSION = '0.4.5';

    private $settings = [];
    private $files = [];
    private $documentation = [];
    private $allClasses = [];
    private $allFunctions = [];
    private $fileTree = [];
    private $baseDir = null;
    private $lang = [];
    private $languages = [];
    private $translations = [];
    private $isCLI = false;

    public function __construct($settings, $translations, $languages) {
        $this->settings = $settings;
        $this->translations = $translations;
        $this->languages = $languages;
        $this->lang = $translations[$settings['language']] ?? $translations['en'];
        $this->isCLI = php_sapi_name() === 'cli';
        $this->validateSettings();
    }

    /**
     * Output message with proper line break based on environment
     */
    private function output($message) {
        if ($this->isCLI) {
            echo $message . "\n";
        } else {
            echo htmlspecialchars($message) . "<br>\n";
        }
    }

    private function validateSettings() {
        if (empty($this->settings['directories'])) {
            $this->output("❌ Missing 'directories' in settings!");
            exit(1);
        }
        if (empty($this->settings['output_dir'])) {
            $this->settings['output_dir'] = 'output';
        }
    }

    public function generate() {
        $this->output("🚀 Starting phpDocGenerator v" . self::VERSION . "...");
        $this->output("");

        $this->scanDirectories();
        $this->baseDir = $this->findCommonBasePath();
        $this->parseFiles();
        $this->buildFileTree();
        $this->createOutputStructure();
        $this->generateHTMLFiles();
        $this->generateDirectoryIndexes();
        $this->generateMainIndex();
        $this->createHtaccess();

        $this->output("");
        $this->output("✅ Done! Open {$this->settings['output_dir']}/index.html in your browser.");
    }

    private function scanDirectories() {
        $this->output("📂 Scanning directories...");
        foreach ($this->settings['directories'] as $dir) {
            if (!is_dir($dir)) {
                $this->output("⚠️  Directory does not exist: $dir");
                continue;
            }
            $this->scanDirectory($dir);
        }
        $this->output("   Found " . count($this->files) . " PHP files");
        $this->output("");
    }

    private function scanDirectory($dir) {
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $path = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                $skip = false;
                if (!empty($this->settings['exclude_dirs'])) {
                    foreach ($this->settings['exclude_dirs'] as $exclude) {
                        if (strpos($path, $exclude) !== false) {
                            $skip = true;
                            break;
                        }
                    }
                }
                if (!$skip) {
                    $this->scanDirectory($path);
                }
            } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $this->files[] = $path;
            }
        }
    }

    private function findCommonBasePath() {
        $paths = [];
        foreach ($this->settings['directories'] as $dir) {
            $realPath = realpath($dir);
            if ($realPath) {
                $paths[] = $realPath;
            }
        }

        if (empty($paths)) {
            return '';
        }

        $commonPath = $paths[0];
        foreach ($paths as $path) {
            while (strpos($path, $commonPath) !== 0) {
                $commonPath = dirname($commonPath);
            }
        }

        return $commonPath;
    }

    private function parseFiles() {
        $this->output("🔍 Analyzing PHP files...");
        foreach ($this->files as $file) {
            $this->documentation[$file] = $this->parseFile($file);
        }
    }

    private function parseFile($file) {
        $content = file_get_contents($file);
        $tokens = token_get_all($content);

        $doc = [
            'file' => $file,
            'classes' => [],
            'functions' => [],
            'constants' => []
        ];

        $currentClass = null;
        $currentComment = null;

        for ($i = 0; $i < count($tokens); $i++) {
            $token = $tokens[$i];

            if (is_array($token) && $token[0] === T_DOC_COMMENT) {
                $currentComment = $this->parseDocBlock($token[1]);
            }

            if (is_array($token) && $token[0] === T_CLASS) {
                $className = $this->getNextToken($tokens, $i, T_STRING);
                $doc['classes'][$className] = [
                    'name' => $className,
                    'comment' => $currentComment,
                    'methods' => [],
                    'properties' => []
                ];
                $currentClass = $className;
                $this->allClasses[] = ['name' => $className, 'file' => $file];
                $currentComment = null;
            }

            if (is_array($token) && $token[0] === T_FUNCTION) {
                $functionName = $this->getNextToken($tokens, $i, T_STRING);
                $params = $this->extractParameters($tokens, $i);

                $functionData = [
                    'name' => $functionName,
                    'comment' => $currentComment,
                    'parameters' => $params
                ];

                if ($currentClass) {
                    $doc['classes'][$currentClass]['methods'][] = $functionData;
                } else {
                    $doc['functions'][] = $functionData;
                    $this->allFunctions[] = ['name' => $functionName, 'file' => $file];
                }
                $currentComment = null;
            }

            if (is_array($token) && $token[0] === T_CONST) {
                $constName = $this->getNextToken($tokens, $i, T_STRING);
                $doc['constants'][] = [
                    'name' => $constName,
                    'comment' => $currentComment
                ];
                $currentComment = null;
            }
        }

        return $doc;
    }

    private function parseDocBlock($comment) {
        $lines = explode("\n", $comment);
        $parsed = [
            'description' => '',
            'params' => [],
            'return' => '',
            'tags' => []
        ];

        $description = [];
        foreach ($lines as $line) {
            $line = trim($line, " \t\n\r\0\x0B*/");

            if (preg_match('/@param\s+(\S+)\s+\$(\S+)\s*(.*)/', $line, $matches)) {
                $parsed['params'][] = [
                    'type' => $matches[1],
                    'name' => $matches[2],
                    'description' => $matches[3] ?? ''
                ];
            } elseif (preg_match('/@return\s+(\S+)\s*(.*)/', $line, $matches)) {
                $parsed['return'] = $matches[1] . ' ' . ($matches[2] ?? '');
            } elseif (preg_match('/@(\w+)\s*(.*)/', $line, $matches)) {
                $parsed['tags'][$matches[1]] = $matches[2];
            } elseif (!empty($line)) {
                $description[] = $line;
            }
        }

        $parsed['description'] = implode(' ', $description);
        return $parsed;
    }

    private function getNextToken($tokens, $startIndex, $type) {
        for ($i = $startIndex + 1; $i < count($tokens); $i++) {
            if (is_array($tokens[$i]) && $tokens[$i][0] === $type) {
                return $tokens[$i][1];
            }
        }
        return '';
    }

    private function extractParameters($tokens, $startIndex) {
        $params = [];
        $inParams = false;
        $currentParam = '';

        for ($i = $startIndex; $i < count($tokens); $i++) {
            if ($tokens[$i] === '(') {
                $inParams = true;
                continue;
            }
            if ($tokens[$i] === ')') {
                if (!empty($currentParam)) {
                    $params[] = trim($currentParam);
                }
                break;
            }
            if ($inParams) {
                if ($tokens[$i] === ',') {
                    $params[] = trim($currentParam);
                    $currentParam = '';
                } else {
                    $currentParam .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
            }
        }

        return $params;
    }

    private function buildFileTree() {
        $this->output("🌳 Building tree structure...");

        foreach ($this->files as $file) {
            $relativePath = $this->getRelativePath($file);

            if ($this->fileExistsInTree($relativePath)) {
                continue;
            }

            $parts = explode('/', $relativePath);

            $current = &$this->fileTree;
            foreach ($parts as $index => $part) {
                if ($index === count($parts) - 1) {
                    if (!isset($current['files'])) {
                        $current['files'] = [];
                    }
                    if (!in_array($part, $current['files'])) {
                        $current['files'][] = $part;
                    }
                } else {
                    if (!isset($current['dirs'][$part])) {
                        $current['dirs'][$part] = ['dirs' => [], 'files' => []];
                    }
                    $current = &$current['dirs'][$part];
                }
            }
        }
    }

    private function fileExistsInTree($relativePath) {
        $parts = explode('/', $relativePath);
        $current = $this->fileTree;

        foreach ($parts as $index => $part) {
            if ($index === count($parts) - 1) {
                return isset($current['files']) && in_array($part, $current['files']);
            } else {
                if (!isset($current['dirs'][$part])) {
                    return false;
                }
                $current = $current['dirs'][$part];
            }
        }

        return false;
    }

    private function getRelativePath($file) {
        $file = realpath($file);

        if ($this->baseDir && $file && strpos($file, $this->baseDir) === 0) {
            return str_replace('\\', '/', substr($file, strlen($this->baseDir) + 1));
        }

        return basename($file);
    }

    private function createOutputStructure() {
        $this->output("📁 Creating directory structure...");

        if (!file_exists($this->settings['output_dir'])) {
            mkdir($this->settings['output_dir'], 0755, true);
        }

        foreach ($this->files as $file) {
            $relativePath = $this->getRelativePath($file);
            $outputPath = $this->settings['output_dir'] . '/' . dirname($relativePath);

            if (!file_exists($outputPath)) {
                mkdir($outputPath, 0755, true);
            }
        }
    }

    private function generateHTMLFiles() {
        $this->output("📄 Generating HTML files...");

        foreach ($this->documentation as $file => $doc) {
            $relativePath = $this->getRelativePath($file);
            $outputFile = $this->settings['output_dir'] . '/' . $relativePath . '.html';

            $html = $this->generateFileHTML($file, $doc, $relativePath);
            file_put_contents($outputFile, $html);
        }
    }

    private function generateFileHTML($file, $doc, $relativePath) {
        $depth = substr_count($relativePath, '/');
        $rootPath = $depth > 0 ? str_repeat('../', $depth) : '';

        $header = $this->generateHeader($rootPath);
        $breadcrumb = $this->generateBreadcrumb($relativePath, $rootPath);
        $searchBox = '<input type="text" id="search" placeholder="' . $this->lang['GENERATOR_SEARCH_PLACEHOLDER'] . '" class="search-box">';
        $content = $this->generateFileContent($file, $doc);

        return $this->getHTMLTemplate(basename($file), $header . $breadcrumb . $searchBox . $content, 'file', $rootPath);
    }

    private function generateBreadcrumb($path, $rootPath = '') {
        $parts = explode('/', $path);
        $breadcrumb = '<div class="breadcrumb">';
        $breadcrumb .= '<a href="' . $rootPath . 'index.html">' . $this->lang['GENERATOR_HOME'] . '</a>';

        $currentPath = '';
        foreach ($parts as $index => $part) {
            if ($index === count($parts) - 1) {
                $breadcrumb .= ' <span class="separator">›</span> <span class="current">' . htmlspecialchars($part) . '</span>';
            } else {
                $currentPath .= ($currentPath ? '/' : '') . $part;
                $breadcrumb .= ' <span class="separator">›</span> <a href="' . $rootPath . $currentPath . '/index.html">' . htmlspecialchars($part) . '</a>';
            }
        }

        $breadcrumb .= '</div>';
        return $breadcrumb;
    }

    private function generateHeader($rootPath = '') {
        $html = "<div class='header-main'>\n";
        $html .= "<div class='logo'>\n";
        $html .= "<a href='{$rootPath}index.html'><img src='https://contentigniter.kukis.sk/phpDoc/phpdoc-app-logo.png' alt='phpDOC'></a>\n";
        $html .= "<small>v" . self::VERSION . "</small>\n";
        $html .= "</div>\n";
        
        // Language picker
        $html .= $this->generateLanguagePicker();
        
        $html .= "<div class='stats-header'>\n";
        $html .= "<div class='stat-item'><span class='stat-number'>" . count($this->files) . "</span><span class='stat-label' data-i18n='GENERATOR_FILES'>" . $this->lang['GENERATOR_FILES'] . "</span></div>\n";
        $html .= "<div class='stat-item'><span class='stat-number'>" . count($this->allClasses) . "</span><span class='stat-label' data-i18n='GENERATOR_CLASSES'>" . $this->lang['GENERATOR_CLASSES'] . "</span></div>\n";
        $html .= "<div class='stat-item'><span class='stat-number'>" . count($this->allFunctions) . "</span><span class='stat-label' data-i18n='GENERATOR_FUNCTIONS'>" . $this->lang['GENERATOR_FUNCTIONS'] . "</span></div>\n";
        $html .= "</div>\n";
        $html .= "</div>\n";

        return $html;
    }

    private function generateLanguagePicker() {
        $currentLang = $this->settings['language'];
        $currentLangData = $this->languages[$currentLang];
        
        $html = "<div class='language-picker'>\n";
        $html .= "<div class='lang-current' onclick='toggleLanguagePicker()'>\n";
        $html .= $currentLangData['flag'];
        $html .= "<span class='lang-name'>" . htmlspecialchars($currentLangData['native']) . "</span>\n";
        $html .= "<span class='lang-arrow'>▼</span>\n";
        $html .= "</div>\n";
        $html .= "<div class='lang-dropdown' id='langDropdown' style='display:none;'>\n";
        
        foreach ($this->settings['available_languages'] as $code) {
            if ($code === $currentLang) continue;
            if (!isset($this->languages[$code])) continue;
            
            $langData = $this->languages[$code];
            $html .= "<div class='lang-option' onclick='changeLang(\"$code\")'>\n";
            $html .= $langData['flag'];
            $html .= "<span class='lang-name'>" . htmlspecialchars($langData['native']) . "</span>\n";
            $html .= "</div>\n";
        }
        
        $html .= "</div>\n";
        $html .= "</div>\n";
        
        return $html;
    }

    private function generateFileContent($file, $doc) {
        $html = "<div class='file-header'>\n";
        $html .= "<h1>" . $this->getFileIcon() . " " . htmlspecialchars(basename($file)) . "</h1>\n";
        $html .= "<div class='file-path'>" . htmlspecialchars($file) . "</div>\n";
        $html .= "</div>\n";

        foreach ($doc['classes'] as $class) {
            $html .= "<div class='class'>\n";
            $html .= "<h2><span class='keyword' data-i18n='GENERATOR_CLASS'>" . $this->lang['GENERATOR_CLASS'] . "</span> <span class='class-name'>" . htmlspecialchars($class['name']) . "</span></h2>\n";

            if ($class['comment'] && !empty($class['comment']['description'])) {
                $html .= "<div class='description'>" . htmlspecialchars($class['comment']['description']) . "</div>\n";
            }

            if (!empty($class['methods'])) {
                $html .= "<div class='methods-list'>\n";
                foreach ($class['methods'] as $index => $method) {
                    $html .= $this->generateMethodHTML($method, $index);
                }
                $html .= "</div>\n";
            }

            $html .= "</div>\n";
        }

        foreach ($doc['functions'] as $index => $function) {
            $html .= $this->generateFunctionHTML($function, $index);
        }

        return $html;
    }

    private function generateMethodHTML($method, $index) {
        $id = 'method-' . $index;
        $params = !empty($method['parameters']) ? '(' . htmlspecialchars(implode(', ', $method['parameters'])) . ')' : '()';

        $html = "<div class='method-item'>\n";
        $html .= "<div class='method-header' onclick='toggleMethod(\"$id\")'>\n";
        $html .= "<span class='toggle-icon' id='icon-$id'>▶</span>\n";
        $html .= "<span class='keyword' data-i18n='GENERATOR_FUNCTION'>" . $this->lang['GENERATOR_FUNCTION'] . "</span> <span class='function-name'>" . htmlspecialchars($method['name']) . "</span>";
        $html .= "<span class='params-preview'>" . $params . "</span>\n";
        $html .= "</div>\n";

        $html .= "<div class='method-details' id='$id' style='display:none;'>\n";

        if ($method['comment'] && !empty($method['comment']['description'])) {
            $html .= "<div class='description'>" . htmlspecialchars($method['comment']['description']) . "</div>\n";
        }

        if ($method['comment'] && !empty($method['comment']['params'])) {
            $html .= "<div class='parameters'><strong data-i18n='GENERATOR_PARAMETERS'>" . $this->lang['GENERATOR_PARAMETERS'] . ":</strong>\n";
            foreach ($method['comment']['params'] as $param) {
                $html .= "<div class='param'><span class='type'>" . htmlspecialchars($param['type']) . "</span> ";
                $html .= "<span class='var'>\$" . htmlspecialchars($param['name']) . "</span>";
                if (!empty($param['description'])) {
                    $html .= " <span class='param-desc'>- " . htmlspecialchars($param['description']) . "</span>";
                }
                $html .= "</div>\n";
            }
            $html .= "</div>\n";
        }

        if ($method['comment'] && !empty($method['comment']['return'])) {
            $html .= "<div class='return'><span class='keyword' data-i18n='GENERATOR_RETURN'>" . $this->lang['GENERATOR_RETURN'] . "</span> " . htmlspecialchars($method['comment']['return']) . "</div>\n";
        }

        $html .= "</div>\n";
        $html .= "</div>\n";

        return $html;
    }

    private function generateFunctionHTML($function, $index) {
        $id = 'func-' . $index;
        $params = !empty($function['parameters']) ? '(' . htmlspecialchars(implode(', ', $function['parameters'])) . ')' : '()';

        $html = "<div class='function'>\n";
        $html .= "<div class='method-header' onclick='toggleMethod(\"$id\")'>\n";
        $html .= "<span class='toggle-icon' id='icon-$id'>▶</span>\n";
        $html .= "<span class='keyword' data-i18n='GENERATOR_FUNCTION'>" . $this->lang['GENERATOR_FUNCTION'] . "</span> <span class='function-name'>" . htmlspecialchars($function['name']) . "</span>";
        $html .= "<span class='params-preview'>" . $params . "</span>\n";
        $html .= "</div>\n";

        $html .= "<div class='method-details' id='$id' style='display:none;'>\n";

        if ($function['comment'] && !empty($function['comment']['description'])) {
            $html .= "<div class='description'>" . htmlspecialchars($function['comment']['description']) . "</div>\n";
        }

        $html .= "</div>\n";
        $html .= "</div>\n";

        return $html;
    }

    private function generateDirectoryIndexes() {
        $this->output("📂 Generating directory indexes...");
        $this->generateDirIndex($this->fileTree, '');
    }

    private function generateDirIndex($tree, $path) {
        if (!empty($tree['dirs'])) {
            foreach ($tree['dirs'] as $dirName => $subTree) {
                $dirPath = $path ? $path . '/' . $dirName : $dirName;
                $outputFile = $this->settings['output_dir'] . '/' . $dirPath . '/index.html';

                $depth = substr_count($dirPath, '/') + 1;
                $rootPath = str_repeat('../', $depth);

                $header = $this->generateHeader($rootPath);
                $breadcrumb = $this->generateBreadcrumb($dirPath, $rootPath);
                $treeHtml = $this->generateTreeHTML($subTree);
                $content = $header . $breadcrumb . "<div class='directory-index'><h1>" . $this->getFolderIcon() . " " . htmlspecialchars($dirName) . "</h1>" . $treeHtml . "</div>";

                $html = $this->getHTMLTemplate($dirName, $content, 'directory', $rootPath);
                file_put_contents($outputFile, $html);

                $this->generateDirIndex($subTree, $dirPath);
            }
        }
    }

    private function generateTreeHTML($tree) {
        $html = "<div class='tree'>\n";

        if (!empty($tree['dirs'])) {
            ksort($tree['dirs']);
            foreach ($tree['dirs'] as $dirName => $subTree) {
                $html .= "<div class='tree-item'>\n";
                $html .= $this->getFolderIcon() . " <a href='" . htmlspecialchars($dirName) . "/index.html'>" . htmlspecialchars($dirName) . "</a>\n";
                $html .= "</div>\n";
            }
        }

        if (!empty($tree['files'])) {
            sort($tree['files']);
            foreach ($tree['files'] as $fileName) {
                $html .= "<div class='tree-item'>\n";
                $html .= $this->getFileIcon() . " <a href='" . htmlspecialchars($fileName) . ".html'>" . htmlspecialchars($fileName) . "</a>\n";
                $html .= "</div>\n";
            }
        }

        $html .= "</div>\n";
        return $html;
    }

    private function generateMainIndex() {
        $this->output("🏠 Generating main index.html...");

        $header = $this->generateHeader('');

        $content = "<div class='main-tree'>\n";
        $content .= "<h2 data-i18n='GENERATOR_PROJECT_STRUCTURE'>" . $this->lang['GENERATOR_PROJECT_STRUCTURE'] . "</h2>\n";
        $content .= $this->generateFullTreeHTML($this->fileTree, '');
        $content .= "</div>\n";

        $html = $this->getHTMLTemplate('phpDocGenerator', $header . $content, 'main', '');
        file_put_contents($this->settings['output_dir'] . '/index.html', $html);
    }

    private function generateFullTreeHTML($tree, $path) {
        $html = "<div class='tree'>\n";

        if (!empty($tree['dirs'])) {
            ksort($tree['dirs']);
            foreach ($tree['dirs'] as $dirName => $subTree) {
                $dirPath = $path ? $path . '/' . $dirName : $dirName;
                $html .= "<div class='tree-item tree-dir'>\n";
                $html .= "<span class='folder-toggle' onclick='toggleFolder(this)'>▶</span> ";
                $html .= $this->getFolderIcon() . " <a href='" . htmlspecialchars($dirPath) . "/index.html'>" . htmlspecialchars($dirName) . "</a>\n";
                $html .= "<div class='tree-children' style='display:none;'>" . $this->generateFullTreeHTML($subTree, $dirPath) . "</div>";
                $html .= "</div>\n";
            }
        }

        if (!empty($tree['files'])) {
            sort($tree['files']);
            foreach ($tree['files'] as $fileName) {
                $filePath = $path ? $path . '/' . $fileName : $fileName;
                $html .= "<div class='tree-item tree-file'>\n";
                $html .= $this->getFileIcon() . " <a href='" . htmlspecialchars($filePath) . ".html'>" . htmlspecialchars($fileName) . "</a>\n";
                $html .= "</div>\n";
            }
        }

        $html .= "</div>\n";
        return $html;
    }

    private function getFolderIcon() {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16"><path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19z"/></svg>';
    }

    private function getFileIcon() {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/><path d="M8.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 9 8.646 7.354a.5.5 0 0 1 0-.708zm-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 9l1.647-1.646a.5.5 0 0 0 0-.708z"/></svg>';
    }

    private function createHtaccess() {
        $this->output("🔐 Creating .htaccess...");

        $htaccess = '';

        if (!empty($this->settings['http_auth'])) {
            $htpasswdContent = '';
            foreach ($this->settings['http_auth'] as $username => $password) {
                $htpasswdContent .= $username . ':' . crypt($password, base64_encode($password)) . "\n";
            }
            file_put_contents($this->settings['output_dir'] . '/.htpasswd', trim($htpasswdContent));

            $htpasswdPath = realpath($this->settings['output_dir'] . '/.htpasswd');

            $htaccess = <<<HTACCESS
# HTTP Authentication
AuthType Basic
AuthName "phpDocGenerator - {$this->lang['GENERATOR_PROTECTED_AREA']}"
AuthUserFile {$htpasswdPath}
Require valid-user

# Allow HTML and assets for authenticated users
<FilesMatch "\\.(html|css|js|png|jpg|gif|svg)$">
    Satisfy Any
</FilesMatch>


HTACCESS;
            $this->output("   ✓ {$this->lang['GENERATOR_AUTH_ENABLED']}");
            $this->output("   {$this->lang['GENERATOR_USERS']}:");
            foreach ($this->settings['http_auth'] as $username => $password) {
                $this->output("     - {$username}");
            }
        } else {
            $this->output("   ⚠   {$this->lang['GENERATOR_AUTH_DISABLED']}");
        }

        $htaccess .= <<<HTACCESS
# Block access to PHP files
<FilesMatch "\\.php$">
    Order Allow,Deny
    Deny from all
</FilesMatch>

# Allow access to HTML and assets
<FilesMatch "\\.(html|css|js|png|jpg|gif|svg)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Index files
DirectoryIndex index.html
HTACCESS;

        file_put_contents($this->settings['output_dir'] . '/.htaccess', $htaccess);
    }

    private function getHTMLTemplate($title, $content, $type, $rootPath = '') {
        // Get translations as JSON for JavaScript
        $translationsJson = json_encode($this->translations, JSON_UNESCAPED_UNICODE);
        
        return <<<HTML
<!DOCTYPE html>
<html lang="{$this->settings['language']}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$title - phpDoc</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            background: #1e1e1e;
            color: #d4d4d4;
            line-height: 1.6;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .breadcrumb {
            background: #252526;
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .breadcrumb a {
            color: #007acc;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb .separator {
            color: #858585;
            margin: 0 8px;
        }
        .breadcrumb .current {
            color: #d4d4d4;
        }
        .search-box {
            width: 100%;
            padding: 12px 20px;
            background: #252526;
            border: 1px solid #3e3e42;
            color: #d4d4d4;
            font-size: 16px;
            border-radius: 4px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .search-box:focus {
            outline: none;
            border-color: #007acc;
        }
        .file-header {
            border-bottom: 2px solid #007acc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        h1 { 
            color: #007acc;
            font-size: 32px;
            margin-bottom: 10px;
        }
        h2 {
            color: #007acc;
            font-size: 24px;
            margin: 30px 0 15px 0;
        }
        h3 {
            color: #dcdcaa;
            font-size: 18px;
            margin: 20px 0 10px 0;
        }
        .file-path {
            color: #858585;
            font-size: 14px;
        }
        .icon {
            vertical-align: middle;
            margin-right: 6px;
            color: #007acc;
        }
        .class {
            background: #252526;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #007acc;
            border-radius: 4px;
        }
        .methods-list {
            margin-top: 20px;
        }
        .method-item, .function {
            background: #2d2d30;
            margin: 10px 0;
            border-left: 3px solid #007acc;
            border-radius: 4px;
        }
        .method-header {
            padding: 12px 15px;
            cursor: pointer;
            user-select: none;
        }
        .method-header:hover {
            background: #3e3e42;
        }
        .toggle-icon {
            display: inline-block;
            width: 16px;
            color: #007acc;
            font-size: 12px;
            transition: transform 0.2s;
        }
        .toggle-icon.expanded {
            transform: rotate(90deg);
        }
        .method-details {
            padding: 0 15px 15px 15px;
        }
        .keyword {
            color: #c586c0;
            font-weight: bold;
        }
        .class-name {
            color: #4ec9b0;
        }
        .function-name {
            color: #dcdcaa;
        }
        .params-preview {
            color: #ce9178;
            margin-left: 4px;
        }
        .type {
            color: #4ec9b0;
        }
        .var {
            color: #9cdcfe;
        }
        .description {
            color: #d4d4d4;
            margin: 10px 0;
            padding: 10px;
            background: #1e1e1e;
            border-left: 2px solid #007acc;
        }
        .parameters {
            margin: 15px 0;
        }
        .param {
            background: #1e1e1e;
            padding: 8px 12px;
            margin: 5px 0;
            border-left: 2px solid #ce9178;
            border-radius: 3px;
        }
        .param-desc {
            color: #858585;
        }
        .return {
            color: #c586c0;
            margin: 10px 0;
            padding: 8px;
            background: #1e1e1e;
            border-radius: 3px;
        }
        .header-main { 
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3px 30px;
            background: #252526;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #007acc;
			position: relative;
        }
        .logo {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .logo img {
            height: 40px;
            width: auto;
        }
        .logo a {
            display: block;
            text-decoration: none;
        }
        .logo small {
            color: #858585;
            font-size: 11px;
        }
        .language-picker {
           position: absolute;
			top: 45px; left: 152px;
        }
        .lang-current {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: #1e1e1e;
            border: 1px solid #3e3e42;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .lang-current:hover {
            background: #2d2d30;
            border-color: #007acc;
        }
        .lang-current svg {
            width: 30px;
            height: 18px;
        }
        .lang-name {
            color: #d4d4d4;
            font-size: 14px;
            white-space: nowrap;
        }
        .lang-arrow {
            color: #858585;
            font-size: 10px;
            margin-left: 4px;
            transition: transform 0.2s;
        }
        .lang-current.active .lang-arrow {
            transform: rotate(180deg);
        }
        .lang-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 4px;
            background: #252526;
            border: 1px solid #3e3e42;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 1000;
            min-width: 100%;
        }
        .lang-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .lang-option:hover {
            background: #2d2d30;
        }
        .lang-option svg {
            width: 30px;
            height: 18px;
        }
        .stats-header {
            display: flex;
            gap: 40px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 42px;
            color: #007acc;
            font-weight: bold;
            display: block; 
        }
        .stat-label {
            color: #858585;
            font-size: 14px;
        }
        .directory-index, .main-tree {
            background: #252526;
            padding: 30px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tree {
            margin-left: 20px;
        }
        .tree-item {
            padding: 8px 12px;
            margin: 4px 0;
            background: #1e1e1e;
            border-left: 3px solid #007acc;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .tree-item:hover {
            background: #2d2d30;
        }
        .tree-item a {
            color: #9cdcfe;
            text-decoration: none;
        }
        .tree-item a:hover {
            color: #4ec9b0;
        }
        .tree-dir .tree-children {
            margin-left: 30px;
            margin-top: 8px;
        }
        .folder-toggle {
            color: #007acc;
            cursor: pointer;
            user-select: none;
            display: inline-block;
            width: 12px;
            transition: transform 0.2s;
        }
        .folder-toggle.expanded {
            transform: rotate(90deg);
        }
    </style>
<link rel="icon" type="image/x-icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAACXBIWXMAAC4jAAAuIwF4pT92AAAEbUlEQVR4nO2VfUwbdRjH79rr9b13ZUhLO2gdFZCM0TJkUYZxRpbMgexfF5M5NnXzP18GjEWd8qcvi3G4AVuyOGMmCDNmw2ECyej+aCkJhZaXCgys0DfoGy3tXbkXfyeEkCldFjNNDJfLpf3e83s+v+/zPPkdUli0G3qcF/JYs28DtgH/BsC/+9WorlJ3t1kY9/4jAMtDCExHCRUwxEIsg64E0LiPhXmkYicEwSSWuyrJRBOLnAjBhHIXLZT/uYwRJJaEMc/DAZQQ8xcfBelgloFgSJAIZo53SUJTlFjJCMQ+0+sQyyLJsMrxnTg07d/zWkqeDdIDNpIM7XD9hM1bHgYQYWBfmNuMz90FGJ/x2HLOczyKYBAx5r6Hz/bH1cZgwSvJjDywZQLXyz2DGdO9KbnGV3IsnHdQ7h3m0WQ6QEqqgmBY6neIwzPCqDtYUMPwURLLoQUSmc8uDt8HFoEJ4IzbO8tIFieBCO6l/BoGEbE8PkRv7QCUNaXQ8okoKD0Hk2evipRS/yglwkFv0BjXXhAAnmjME1eX8FNxUdQN/gKvtAiTBMZ4q8l0JeI6zFWfSmQWJHc8Fc2pACnknqGI/gWEjIIqgwBSrkGICJKKkZgOeE0qdxG4bnnns8CWcrafG400ANDGVWkWJcSXCo+s9U09cg3MBo3IJL4JPk3SAiklUIhC92GGSsnUNCoL5tfALIymYtlDV6WLYw8k5fP5DMOwLLsOAE1blTyBuwcypn7mJCLCo1MZmVlVqnkRnyWUzzMwzxOzzTiGk4gczBU2ay6ODRnLSnEeFRMonU7Ngmd9UpVKZfkzZTKZLJkkQqGgxTrIAWKaMmBDHJpZ68HaRSbj5fnaFw8c+Li5WSwSHT1UuVRe1NI3DZNkqQp5s7bWarNZHE6TyXi2saG1/YrD4VCpVI31Z4bt9gGzubCw8FxTU03tEQ4AhkcacEqCv262ubKSmJicNBpL7PaRRCLhdI5duPB5UqZp6+x6v+G4d2r0zp1eEDa/sGAwGE6feuudd987eaIOESDfXP8W6HNzvxXk56+XSOGx/X1/+HwezEMQLsYfCFgs1kOV+we6rxkN2p7O6xthNttQVdVLe4qLS0tNN250bOjfd3RCj3TYBQIBTKHQ6/VCFF2OLm/yugL2kavLRQVoJBLZ0H0+36MBcBxfjsV8Xh+ZSikwxYYuk0kZhp7/fZ6iKJUq64FV6QAUTTMsA5aB3xiGlZpMvb2/TM/MOEYdYFT6+vrXwvbtKweifWRkZHS0uvrwD13dBEEAvajo6fHxiS0BYrH4Sb0+W63eX1ERCofK9u61WK0dHZ1g8aXWthN1x6sPvwz6D6ZIo9G0tFwiSbK1rf2T8x+Bobp16zawqNVq0wGAWTA83Td/NBjywuEMs/nepMtF09yJ43K5LrZ8/cbJurdPn7IO2j797AuvlztOwLO+obG+/szFr7683dNz+XJbuhKBOWu/cnWrt263+4MPz/9VD0ciZ5vObVb+60/mNuD/APgD2WkPFjbIceMAAAAASUVORK5CYII=">
</head>
<body>
    <div class="container">
        $content
    </div>
    <script>
        // Translations data
        const translations = $translationsJson;
        
        // Get current language from localStorage or default
        let currentLang = localStorage.getItem('phpdoc_lang') || '{$this->settings['language']}';
        
        // Apply translations
        function applyTranslations() {
            const lang = translations[currentLang] || translations['en'];
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (lang[key]) {
                    el.textContent = lang[key];
                }
            });
            
            // Update search placeholder
            const searchBox = document.getElementById('search');
            if (searchBox && lang['GENERATOR_SEARCH_PLACEHOLDER']) {
                searchBox.placeholder = lang['GENERATOR_SEARCH_PLACEHOLDER'];
            }
        }
        
        // Change language
        function changeLang(newLang) {
            currentLang = newLang;
            localStorage.setItem('phpdoc_lang', newLang);
            applyTranslations();
            toggleLanguagePicker();
        }
        
        // Toggle language picker dropdown
        function toggleLanguagePicker() {
            const dropdown = document.getElementById('langDropdown');
            const current = document.querySelector('.lang-current');
            
            if (dropdown.style.display === 'none') {
                dropdown.style.display = 'block';
                current.classList.add('active');
            } else {
                dropdown.style.display = 'none';
                current.classList.remove('active');
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const picker = document.querySelector('.language-picker');
            if (picker && !picker.contains(e.target)) {
                const dropdown = document.getElementById('langDropdown');
                const current = document.querySelector('.lang-current');
                if (dropdown) dropdown.style.display = 'none';
                if (current) current.classList.remove('active');
            }
        });
        
        // Toggle method/function details
        function toggleMethod(id) {
            const details = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (details.style.display === 'none') {
                details.style.display = 'block';
                icon.textContent = '▼';
                icon.classList.add('expanded');
            } else {
                details.style.display = 'none';
                icon.textContent = '▶';
                icon.classList.remove('expanded');
            }
        }
        
        // Toggle folder in tree
        function toggleFolder(element) {
            const treeItem = element.closest('.tree-item');
            const children = treeItem.querySelector('.tree-children');
            
            if (children) {
                if (children.style.display === 'none') {
                    children.style.display = 'block';
                    element.textContent = '▼';
                    element.classList.add('expanded');
                } else {
                    children.style.display = 'none';
                    element.textContent = '▶';
                    element.classList.remove('expanded');
                }
            }
        }
        
        // Search functionality
        const searchBox = document.getElementById('search');
        if (searchBox) {
            searchBox.addEventListener('input', function(e) {
                const searchText = e.target.value.toLowerCase();
                const items = document.querySelectorAll('.method-item, .function');
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchText) || searchText === '') {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
        
        // Apply translations on page load
        applyTranslations();
    </script>
</body>
</html>
HTML;
    }
}

// ===== EXECUTION =====
$generator = new phpDocGenerator($settings, $translations, $languages);
$generator->generate();
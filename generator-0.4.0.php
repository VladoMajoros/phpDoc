<?php
/**
 * phpDocGenerator v0.4.0
 * PHP Documentation Output Creator
 * Generuje HTML dokumentáciu z PHP súborov
 */

// ============================================================================
// KONFIGURÁCIA - upravte podľa potreby
// ============================================================================
echo '<pre>';
//var_dump( $_SERVER['DOCUMENT_ROOT']);
$settings = [
    // Adresáre na analyzovanie (budú sa prechádzať rekurzívne)
    'directories' => [
        '../../../ci4cms/app/Controllers',
        '../../../ci4cms/app/Models',
        '../../../ci4cms/app/Helpers',
        '../../../ci4cms/app/Views',
    ],

    // Výstupný adresár pre dokumentáciu (relatívne k generator.php)
    'output_dir' => 'output',

    // Adresáre, ktoré sa majú preskočiť (napr. vendor, cache)
    'exclude_dirs' => [
        'vendor',
        'cache',
        'logs',
        'tmp',
        'node_modules',
    ],

    // HTTP autentifikácia - môžete pridať viacero userov
    // Nechajte prázdne pole pre verejný prístup
    'http_auth' => [
        // Formát: 'username' => 'password'
        // 'admin' => 'heslo123',
        // 'user' => 'pass456',
    ],

    // Aktívny jazyk (sk, en, de)
    'language' => 'sk',
];

// ============================================================================
// JAZYKOVÉ PREKLADY
// ============================================================================

$translations = [
    'sk' => [
        'home' => 'Domov',
        'files' => 'Súborov',
        'classes' => 'Tried',
        'functions' => 'Funkcií',
        'project_structure' => 'Štruktúra projektu',
        'parameters' => 'Parametre',
        'return' => 'return',
        'search_placeholder' => '🔍 Hľadať funkcie...',
        'class' => 'class',
        'function' => 'function',
        'protected_area' => 'Chránená oblasť',
        'auth_enabled' => 'HTTP autentifikácia zapnutá',
        'auth_disabled' => 'HTTP autentifikácia vypnutá - verejný prístup',
        'users' => 'Používatelia',
    ],
    'en' => [
        'home' => 'Home',
        'files' => 'Files',
        'classes' => 'Classes',
        'functions' => 'Functions',
        'project_structure' => 'Project Structure',
        'parameters' => 'Parameters',
        'return' => 'return',
        'search_placeholder' => '🔍 Search functions...',
        'class' => 'class',
        'function' => 'function',
        'protected_area' => 'Protected Area',
        'auth_enabled' => 'HTTP authentication enabled',
        'auth_disabled' => 'HTTP authentication disabled - public access',
        'users' => 'Users',
    ],
    'de' => [
        'home' => 'Startseite',
        'files' => 'Dateien',
        'classes' => 'Klassen',
        'functions' => 'Funktionen',
        'project_structure' => 'Projektstruktur',
        'parameters' => 'Parameter',
        'return' => 'return',
        'search_placeholder' => '🔍 Funktionen suchen...',
        'class' => 'class',
        'function' => 'function',
        'protected_area' => 'Geschützter Bereich',
        'auth_enabled' => 'HTTP-Authentifizierung aktiviert',
        'auth_disabled' => 'HTTP-Authentifizierung deaktiviert - öffentlicher Zugang',
        'users' => 'Benutzer',
    ],
];

// ============================================================================
// GENERÁTOR DOKUMENTÁCIE - neupravujte nižšie, pokiaľ neviete čo robíte
// ============================================================================

class phpDocGenerator {
    private $settings = [];
    private $files = [];
    private $documentation = [];
    private $allClasses = [];
    private $allFunctions = [];
    private $fileTree = [];
    private $baseDir = null;
    private $lang = [];

    public function __construct($settings, $translations) {
        $this->settings = $settings;
        $this->lang = $translations[$settings['language']] ?? $translations['en'];
        $this->validateSettings();
    }

    private function validateSettings() {
        if (empty($this->settings['directories'])) {
            die("❌ V settings chýba 'directories'!\n");
        }
        if (empty($this->settings['output_dir'])) {
            $this->settings['output_dir'] = 'output';
        }
    }

    public function generate() {
        echo "🚀 Spúšťam phpDocGenerator...\n\n";

        $this->scanDirectories();
        $this->baseDir = $this->findCommonBasePath();
        $this->parseFiles();
        $this->buildFileTree();
        $this->createOutputStructure();
        $this->generateHTMLFiles();
        $this->generateDirectoryIndexes();
        $this->generateMainIndex();
        $this->createHtaccess();

        echo "\n✅ Hotovo! Otvorte {$this->settings['output_dir']}/index.html v prehliadači.\n";
    }

    private function scanDirectories() {
        echo "📂 Skenujem adresáre...\n";
        foreach ($this->settings['directories'] as $dir) {
            if (!is_dir($dir)) {
                echo "⚠️  Adresár neexistuje: $dir\n";
                continue;
            }
            $this->scanDirectory($dir);
        }
        echo "   Nájdených " . count($this->files) . " PHP súborov\n\n";
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
        echo "🔍 Analyzujem PHP súbory...\n";
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
        echo "🌳 Vytvárам stromovú štruktúru...\n";

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
        echo "📁 Vytvárам štruktúru adresárov...\n";

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
        echo "📄 Generujem HTML súbory...\n";

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
        $content = $this->generateFileContent($file, $doc);

        return $this->getHTMLTemplate(basename($file), $header . $breadcrumb . $content, 'file');
    }

    private function generateBreadcrumb($path, $rootPath = '') {
        $parts = explode('/', $path);
        $breadcrumb = '<div class="breadcrumb">';
        $breadcrumb .= '<a href="' . $rootPath . 'index.html">' . $this->lang['home'] . '</a>';

        $currentPath = '';
        foreach ($parts as $index => $part) {
            if ($index === count($parts) - 1) {
                // Posledná časť - aktuálny súbor
                $breadcrumb .= ' <span class="separator">›</span> <span class="current">' . htmlspecialchars($part) . '</span>';
            } else {
                // Adresár
                $currentPath .= ($currentPath ? '/' : '') . $part;
                $breadcrumb .= ' <span class="separator">›</span> <a href="' . $rootPath . $currentPath . '/index.html">' . htmlspecialchars($part) . '</a>';
            }
        }

        $breadcrumb .= '</div>';
        return $breadcrumb;
    }

    private function generateHeader($rootPath = '') {
        $html = "<div class='header-main'>\n";
        $html .= "<div class='logo'><a href='{$rootPath}index.html'><img src='https://contentigniter.kukis.sk/phpDoc/phpdoc-app-logo.png' alt='phpDOC'></a></div>\n";
        $html .= "<div class='stats-header'>\n";
        $html .= "<div class='stat-item'><span class='stat-number'>" . count($this->files) . "</span><span class='stat-label'>" . $this->lang['files'] . "</span></div>\n";
        $html .= "<div class='stat-item'><span class='stat-number'>" . count($this->allClasses) . "</span><span class='stat-label'>" . $this->lang['classes'] . "</span></div>\n";
        $html .= "<div class='stat-item'><span class='stat-number'>" . count($this->allFunctions) . "</span><span class='stat-label'>" . $this->lang['functions'] . "</span></div>\n";
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
            $html .= "<h2><span class='keyword'>" . $this->lang['class'] . "</span> <span class='class-name'>" . htmlspecialchars($class['name']) . "</span></h2>\n";

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
        $html .= "<span class='keyword'>" . $this->lang['function'] . "</span> <span class='function-name'>" . htmlspecialchars($method['name']) . "</span>";
        $html .= "<span class='params-preview'>" . $params . "</span>\n";
        $html .= "</div>\n";

        $html .= "<div class='method-details' id='$id' style='display:none;'>\n";

        if ($method['comment'] && !empty($method['comment']['description'])) {
            $html .= "<div class='description'>" . htmlspecialchars($method['comment']['description']) . "</div>\n";
        }

        if ($method['comment'] && !empty($method['comment']['params'])) {
            $html .= "<div class='parameters'><strong>" . $this->lang['parameters'] . ":</strong>\n";
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
            $html .= "<div class='return'><span class='keyword'>" . $this->lang['return'] . "</span> " . htmlspecialchars($method['comment']['return']) . "</div>\n";
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
        $html .= "<span class='keyword'>" . $this->lang['function'] . "</span> <span class='function-name'>" . htmlspecialchars($function['name']) . "</span>";
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
        echo "📂 Generujem indexy adresárov...\n";
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

                $html = $this->getHTMLTemplate($dirName, $content, 'directory');
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
        echo "🏠 Generujem hlavný index.html...\n";

        $header = $this->generateHeader('');

        $content = "<div class='main-tree'>\n";
        $content .= "<h2>" . $this->lang['project_structure'] . "</h2>\n";
        $content .= $this->generateFullTreeHTML($this->fileTree, '');
        $content .= "</div>\n";

        $html = $this->getHTMLTemplate('phpDocGenerator', $header . $content, 'main');
        file_put_contents($this->settings['output_dir'] . '/index.html', $html);
    }

    private function generateFullTreeHTML($tree, $path) {
        $html = "<div class='tree'>\n";

        if (!empty($tree['dirs'])) {
            ksort($tree['dirs']);
            foreach ($tree['dirs'] as $dirName => $subTree) {
                $dirPath = $path ? $path . '/' . $dirName : $dirName;
                $html .= "<div class='tree-item tree-dir'>\n";
                $html .= $this->getFolderIcon() . " <a href='" . htmlspecialchars($dirPath) . "/index.html'>" . htmlspecialchars($dirName) . "</a>\n";
                $html .= $this->generateFullTreeHTML($subTree, $dirPath);
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
        echo "🔒 Vytvárам .htaccess...\n";

        $htaccess = '';

        if (!empty($this->settings['http_auth'])) {
            $htpasswdContent = '';
            foreach ($this->settings['http_auth'] as $username => $password) {
                $htpasswdContent .= $username . ':' . crypt($password, base64_encode($password)) . "\n";
            }
            file_put_contents($this->settings['output_dir'] . '/.htpasswd', trim($htpasswdContent));

            $htpasswdPath = realpath($this->settings['output_dir'] . '/.htpasswd');

            $htaccess = <<<HTACCESS
# HTTP Autentifikácia
AuthType Basic
AuthName "phpDocGenerator - {$this->lang['protected_area']}"
AuthUserFile {$htpasswdPath}
Require valid-user

# Povoliť HTML a assets aj pre autentifikovaných
<FilesMatch "\\.(html|css|js|png|jpg|gif|svg)$">
    Satisfy Any
</FilesMatch>


HTACCESS;
            echo "   ✓ {$this->lang['auth_enabled']}\n";
            echo "   {$this->lang['users']}:\n";
            foreach ($this->settings['http_auth'] as $username => $password) {
                echo "     - {$username}\n";
            }
        } else {
            echo "   ⚠ {$this->lang['auth_disabled']}\n";
        }

        $htaccess .= <<<HTACCESS
# Zakázať prístup k PHP súborom
<FilesMatch "\\.php$">
    Order Allow,Deny
    Deny from all
</FilesMatch>

# Povoliť prístup k HTML a assets
<FilesMatch "\\.(html|css|js|png|jpg|gif|svg)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Index súbory
DirectoryIndex index.html
HTACCESS;

        file_put_contents($this->settings['output_dir'] . '/.htaccess', $htaccess);
    }

    private function getHTMLTemplate($title, $content, $type) {
        $searchBar = ($type === 'file') ? '<input type="text" id="search" placeholder="' . $this->lang['search_placeholder'] . '" class="search-box">' : '';

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
            padding: 0 30px;
            background: #252526;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #007acc;
        }
        .logo img {
            height: 40px;
            width: auto;
        }
        .logo a {
            display: block;
            text-decoration: none;
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
        .tree-dir .tree {
            margin-left: 30px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        $searchBar
        $content
    </div>
    <script>
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
    </script>
</body>
</html>
HTML;
    }
}

// ===== SPUSTENIE =====
$generator = new phpDocGenerator($settings, $translations);
$generator->generate();
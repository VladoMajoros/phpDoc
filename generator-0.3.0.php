<?php
/**
 * phpDocGenerator v0.3.0
 * PHP Documentation Output Creator
 * Generuje HTML dokumentáciu z PHP súborov
 */

// ============================================================================
// KONFIGURÁCIA - upravte podľa potreby
// ============================================================================


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
        $breadcrumb = $this->generateBreadcrumb($relativePath);
        $header = $this->generateHeader($relativePath);
        $content = $this->generateFileContent($file, $doc);

        return $this->getHTMLTemplate(basename($file), $header . $breadcrumb . $content, 'file', $relativePath);
    }

    private function generateBreadcrumb($path) {
        $parts = explode('/', $path);
        $breadcrumb = '<div class="breadcrumb">';
        $breadcrumb .= '<a href="' . $this->getRelativeRoot($path) . 'index.html">' . $this->lang['home'] . '</a>';

        $currentPath = '';
        foreach ($parts as $index => $part) {
            if ($index === count($parts) - 1) {
                $breadcrumb .= ' <span class="separator">›</span> <span class="current">' . htmlspecialchars($part) . '</span>';
            } else {
                $currentPath .= ($currentPath ? '/' : '') . $part;
                $breadcrumb .= ' <span class="separator">›</span> <a href="' . $this->getRelativeRoot($path) . $currentPath . '/index.html">' . htmlspecialchars($part) . '</a>';
            }
        }

        $breadcrumb .= '</div>';
        return $breadcrumb;
    }

    private function getRelativeRoot($path) {
        $depth = substr_count($path, '/');
        return $depth > 0 ? str_repeat('../', $depth) : './';
    }

    private function generateHeader($relativePath = '') {
        $rootPath = $relativePath ? $this->getRelativeRoot($relativePath) : './';

        $html = "<div class='header-main'>\n";
        $html .= "<div class='logo'><a href='{$rootPath}index.html'>" . $this->getLogo() . "</a></div>\n";
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

                $breadcrumb = $this->generateBreadcrumb($dirPath);
                $header = $this->generateHeader($dirPath);
                $treeHtml = $this->generateTreeHTML($subTree, $dirPath);
                $content = $header . $breadcrumb . "<div class='directory-index'><h1>" . $this->getFolderIcon() . " " . htmlspecialchars($dirName) . "</h1>" . $treeHtml . "</div>";

                $html = $this->getHTMLTemplate($dirName, $content, 'directory', $dirPath);
                file_put_contents($outputFile, $html);

                $this->generateDirIndex($subTree, $dirPath);
            }
        }
    }

    private function generateTreeHTML($tree, $basePath = '') {
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

        $header = $this->generateHeader();

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

    private function getLogo() {
        return '<img src="data:image/png;base64,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" alt="phpDOC" style="height: 50px; width: auto;"></a>';
    }

    private function createHtaccess() {
        echo "🔒 Vytvárам .htaccess...\n";

        $htaccess = '';

        // Ak sú zadané prihlasovacie údaje, generuj HTTP autentifikáciu
        if (!empty($this->settings['http_auth'])) {

            // Generovanie .htpasswd súboru pre viacero používateľov
            $htpasswdContent = '';
            foreach ($this->settings['http_auth'] as $username => $password) {
                $htpasswdContent .= $username . ':' . crypt($password, base64_encode($password)) . "\n";
            }
            file_put_contents('.htpasswd', trim($htpasswdContent));

            $htpasswdPath = realpath('.htpasswd');

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

        // Vždy zakázať prístup k PHP súborom
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

        file_put_contents('.htaccess', $htaccess);
    }

    private function getHTMLTemplate($title, $content, $type, $relativePath = '') {
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
            padding: 20px 30px;
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
  <link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAC4jAAAuIwF4pT92AAAEh0lEQVR4nO3WeUwUVwAG8Jk9kF3OBZdFwHIv5YgcghKaao8USEsaQNsIrTYqCFFTWmL7B6lpijU09Ui1NemNoRWKgNZGI8FQIqQlVUAEJCDHciwCC+xud9mDYZjtN9mZlpJUwMSYJrzklzc77828b968mVkRUdRCPMkieqKjrwVYC7AWYJUBnoVGeB9OPK4AUeAKJNAwDiNc22auZiARtNAHNnCHcO44lgl6wbKaABK4AkGL9hnhGGG/Yj7ASa6moBLegtfg6yXnbuX2q1YaYCMEQA18Aj7wORyFCxANA7CbC1sKmZAP8dw5MkADO6AQcqFopQEiQAC1wH8g8uAlCOFchmaujZ3eMZjnAqjhKmG/dVYugMfDBl8aII6r+cGdIRa6uW32qm9zbQEQDBdBCk/DDW5wtmzj6j9WE4AdjOJOxs5GFmyAd0HJ9Wnn6kju2GYuCBtiDl7hjv0A7hH2GVtRAG8I5X6XEfZbMUHYp7GSoJnvsdbHsL7vEiI00TYlISRN+H2L+GdxZmB/Gh4KXATZhPog+upXGmA7BHKDHyfsUzkFJqlY4Jge7dEpEQuGrTSTjCCMzrqgaVQZk2YppgN9DmMfTTC27c+HuobG+UqVJElMqPVUTM09/YN5xsbfFsLbWeSVHiFLk4hIRzNts/RPWwf4APvAARqgf3FCap6hjXMLHRdeD7y6t2Zof6fa1Jsc7v5c8Ys+ZwuvjR5tHDBuxkwMfZzimxzhJQkoqlUfM1PMXH6SV84bMZ57sioG98zSjHmTQhJRujPgm1NNk59d6zfUbg1ySajYFVTBB/gWzkP90ilCfLp5xNSKqzb0TFnvt2qs7a2aCXYtCGveDP457FTXkShvie/bSV4FkWe6N43+SbEvL6KobuyjroKIO4XbFAXFv46XfJXh/+WNfkNDeYe2im0f7dJdSXrKOZEPUPWw+yQWkmK83kiRgPx70X7XMnP+wxd8ilPC3Ka2+jmF9M3MqfjB+VLXZ6jbESnbWdWlq473lW45cl393uL2s82T5x75Y2SYWzDqrbQuUOYQ7u0iDpg20zNL+0yZ6GmZRCgLlK3zxwUIdBb6X4tySEepHzkAFqWjs4PQRaWlVJ5S0fpQT5eQpX3kTiL5DIKN6KlRoYAUKJzFim6NtXdxnxUFmF+wsW87G7XAPmL28mq4W5rWQk9d79HXDeupkdz49Tn+7g5+2FbzfVKVbilld2bKusfM99vHzW15W+QHGgaNjXx77AZp1LIBHEhCnODnFLdOREpTla7JtnmGCfOWKF/GydN/GMjUU4zh95HZWyU3J0pOpPqVHKt/UIKnwJybKN/bojbdPtM0+QUjIm37a4ZzyncFln+a6ne8+q72ksJVLE/Y6BS3bAB3qchld4xHZn2/8Res2ljcT5/OCUtP7qWhgwaKMfH9EOBk4TOKQxXZwaVCkhA2qmab9lUPHaDtn2+ibdzckf3TYFZlVvCPhxLleTdVxob8y8PvLBtAY6K12RdVh5frx5bTv02eY/1Xe9u4pTP0dFf04n3/q79kawHWAjyW8he3hb1GMM1EkgAAAABJRU5ErkJggg==" />  
  <link rel="shortcut icon" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAC4jAAAuIwF4pT92AAAEh0lEQVR4nO3WeUwUVwAG8Jk9kF3OBZdFwHIv5YgcghKaao8USEsaQNsIrTYqCFFTWmL7B6lpijU09Ui1NemNoRWKgNZGI8FQIqQlVUAEJCDHciwCC+xud9mDYZjtN9mZlpJUwMSYJrzklzc77828b968mVkRUdRCPMkieqKjrwVYC7AWYJUBnoVGeB9OPK4AUeAKJNAwDiNc22auZiARtNAHNnCHcO44lgl6wbKaABK4AkGL9hnhGGG/Yj7ASa6moBLegtfg6yXnbuX2q1YaYCMEQA18Aj7wORyFCxANA7CbC1sKmZAP8dw5MkADO6AQcqFopQEiQAC1wH8g8uAlCOFchmaujZ3eMZjnAqjhKmG/dVYugMfDBl8aII6r+cGdIRa6uW32qm9zbQEQDBdBCk/DDW5wtmzj6j9WE4AdjOJOxs5GFmyAd0HJ9Wnn6kju2GYuCBtiDl7hjv0A7hH2GVtRAG8I5X6XEfZbMUHYp7GSoJnvsdbHsL7vEiI00TYlISRN+H2L+GdxZmB/Gh4KXATZhPog+upXGmA7BHKDHyfsUzkFJqlY4Jge7dEpEQuGrTSTjCCMzrqgaVQZk2YppgN9DmMfTTC27c+HuobG+UqVJElMqPVUTM09/YN5xsbfFsLbWeSVHiFLk4hIRzNts/RPWwf4APvAARqgf3FCap6hjXMLHRdeD7y6t2Zof6fa1Jsc7v5c8Ys+ZwuvjR5tHDBuxkwMfZzimxzhJQkoqlUfM1PMXH6SV84bMZ57sioG98zSjHmTQhJRujPgm1NNk59d6zfUbg1ySajYFVTBB/gWzkP90ilCfLp5xNSKqzb0TFnvt2qs7a2aCXYtCGveDP457FTXkShvie/bSV4FkWe6N43+SbEvL6KobuyjroKIO4XbFAXFv46XfJXh/+WNfkNDeYe2im0f7dJdSXrKOZEPUPWw+yQWkmK83kiRgPx70X7XMnP+wxd8ilPC3Ka2+jmF9M3MqfjB+VLXZ6jbESnbWdWlq473lW45cl393uL2s82T5x75Y2SYWzDqrbQuUOYQ7u0iDpg20zNL+0yZ6GmZRCgLlK3zxwUIdBb6X4tySEepHzkAFqWjs4PQRaWlVJ5S0fpQT5eQpX3kTiL5DIKN6KlRoYAUKJzFim6NtXdxnxUFmF+wsW87G7XAPmL28mq4W5rWQk9d79HXDeupkdz49Tn+7g5+2FbzfVKVbilld2bKusfM99vHzW15W+QHGgaNjXx77AZp1LIBHEhCnODnFLdOREpTla7JtnmGCfOWKF/GydN/GMjUU4zh95HZWyU3J0pOpPqVHKt/UIKnwJybKN/bojbdPtM0+QUjIm37a4ZzyncFln+a6ne8+q72ksJVLE/Y6BS3bAB3qchld4xHZn2/8Res2ljcT5/OCUtP7qWhgwaKMfH9EOBk4TOKQxXZwaVCkhA2qmab9lUPHaDtn2+ibdzckf3TYFZlVvCPhxLleTdVxob8y8PvLBtAY6K12RdVh5frx5bTv02eY/1Xe9u4pTP0dFf04n3/q79kawHWAjyW8he3hb1GMM1EkgAAAABJRU5ErkJggg==" />  
  <link rel="apple-touch-icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAC4jAAAuIwF4pT92AAAEh0lEQVR4nO3WeUwUVwAG8Jk9kF3OBZdFwHIv5YgcghKaao8USEsaQNsIrTYqCFFTWmL7B6lpijU09Ui1NemNoRWKgNZGI8FQIqQlVUAEJCDHciwCC+xud9mDYZjtN9mZlpJUwMSYJrzklzc77828b968mVkRUdRCPMkieqKjrwVYC7AWYJUBnoVGeB9OPK4AUeAKJNAwDiNc22auZiARtNAHNnCHcO44lgl6wbKaABK4AkGL9hnhGGG/Yj7ASa6moBLegtfg6yXnbuX2q1YaYCMEQA18Aj7wORyFCxANA7CbC1sKmZAP8dw5MkADO6AQcqFopQEiQAC1wH8g8uAlCOFchmaujZ3eMZjnAqjhKmG/dVYugMfDBl8aII6r+cGdIRa6uW32qm9zbQEQDBdBCk/DDW5wtmzj6j9WE4AdjOJOxs5GFmyAd0HJ9Wnn6kju2GYuCBtiDl7hjv0A7hH2GVtRAG8I5X6XEfZbMUHYp7GSoJnvsdbHsL7vEiI00TYlISRN+H2L+GdxZmB/Gh4KXATZhPog+upXGmA7BHKDHyfsUzkFJqlY4Jge7dEpEQuGrTSTjCCMzrqgaVQZk2YppgN9DmMfTTC27c+HuobG+UqVJElMqPVUTM09/YN5xsbfFsLbWeSVHiFLk4hIRzNts/RPWwf4APvAARqgf3FCap6hjXMLHRdeD7y6t2Zof6fa1Jsc7v5c8Ys+ZwuvjR5tHDBuxkwMfZzimxzhJQkoqlUfM1PMXH6SV84bMZ57sioG98zSjHmTQhJRujPgm1NNk59d6zfUbg1ySajYFVTBB/gWzkP90ilCfLp5xNSKqzb0TFnvt2qs7a2aCXYtCGveDP457FTXkShvie/bSV4FkWe6N43+SbEvL6KobuyjroKIO4XbFAXFv46XfJXh/+WNfkNDeYe2im0f7dJdSXrKOZEPUPWw+yQWkmK83kiRgPx70X7XMnP+wxd8ilPC3Ka2+jmF9M3MqfjB+VLXZ6jbESnbWdWlq473lW45cl393uL2s82T5x75Y2SYWzDqrbQuUOYQ7u0iDpg20zNL+0yZ6GmZRCgLlK3zxwUIdBb6X4tySEepHzkAFqWjs4PQRaWlVJ5S0fpQT5eQpX3kTiL5DIKN6KlRoYAUKJzFim6NtXdxnxUFmF+wsW87G7XAPmL28mq4W5rWQk9d79HXDeupkdz49Tn+7g5+2FbzfVKVbilld2bKusfM99vHzW15W+QHGgaNjXx77AZp1LIBHEhCnODnFLdOREpTla7JtnmGCfOWKF/GydN/GMjUU4zh95HZWyU3J0pOpPqVHKt/UIKnwJybKN/bojbdPtM0+QUjIm37a4ZzyncFln+a6ne8+q72ksJVLE/Y6BS3bAB3qchld4xHZn2/8Res2ljcT5/OCUtP7qWhgwaKMfH9EOBk4TOKQxXZwaVCkhA2qmab9lUPHaDtn2+ibdzckf3TYFZlVvCPhxLleTdVxob8y8PvLBtAY6K12RdVh5frx5bTv02eY/1Xe9u4pTP0dFf04n3/q79kawHWAjyW8he3hb1GMM1EkgAAAABJRU5ErkJggg==" />  
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
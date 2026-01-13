#!/usr/bin/env php
<?php

/**
 * Code Quality Checker
 * 
 * Script untuk check code quality metrics
 */

echo "\n";
echo "╔══════════════════════════════════════════╗\n";
echo "║   PPDB Code Quality Checker v2.0        ║\n";
echo "╚══════════════════════════════════════════╝\n";
echo "\n";

$projectRoot = __DIR__;

// Count lines of code
function countLines($directory, $extension) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    $totalLines = 0;
    $fileCount = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === $extension) {
            $totalLines += count(file($file->getPathname()));
            $fileCount++;
        }
    }
    
    return ['lines' => $totalLines, 'files' => $fileCount];
}

// Check for long methods
function checkMethodLength($file) {
    $content = file_get_contents($file);
    $lines = explode("\n", $content);
    
    $inMethod = false;
    $methodStart = 0;
    $braceCount = 0;
    $longMethods = [];
    $currentMethod = '';
    
    foreach ($lines as $lineNum => $line) {
        if (preg_match('/function\s+(\w+)\s*\(/', $line, $matches)) {
            $inMethod = true;
            $methodStart = $lineNum + 1;
            $currentMethod = $matches[1];
            $braceCount = 0;
        }
        
        if ($inMethod) {
            $braceCount += substr_count($line, '{') - substr_count($line, '}');
            
            if ($braceCount === 0 && strpos($line, '{') !== false) {
                $methodLength = ($lineNum + 1) - $methodStart;
                if ($methodLength > 50) {
                    $longMethods[] = [
                        'method' => $currentMethod,
                        'length' => $methodLength,
                        'line' => $methodStart
                    ];
                }
                $inMethod = false;
            }
        }
    }
    
    return $longMethods;
}

// Main checks
echo "📊 Analyzing codebase...\n\n";

// 1. Count PHP files
$phpStats = countLines($projectRoot . '/app', 'php');
echo "✓ PHP Files: {$phpStats['files']} files, {$phpStats['lines']} lines\n";

// 2. Check Services
$servicesDir = $projectRoot . '/app/Services';
if (is_dir($servicesDir)) {
    $serviceFiles = glob($servicesDir . '/*.php');
    echo "✓ Services: " . count($serviceFiles) . " service classes\n";
} else {
    echo "✗ Services: Directory not found\n";
}

// 3. Check DTOs
$dtosDir = $projectRoot . '/app/DTOs';
if (is_dir($dtosDir)) {
    $dtoFiles = glob($dtosDir . '/*.php');
    echo "✓ DTOs: " . count($dtoFiles) . " DTO classes\n";
} else {
    echo "✗ DTOs: Directory not found\n";
}

// 4. Check Exceptions
$exceptionsDir = $projectRoot . '/app/Exceptions';
if (is_dir($exceptionsDir)) {
    $exceptionFiles = glob($exceptionsDir . '/*.php');
    echo "✓ Exceptions: " . count($exceptionFiles) . " exception classes\n";
} else {
    echo "✗ Exceptions: Directory not found\n";
}

// 5. Check Helpers
$helpersDir = $projectRoot . '/app/Helpers';
if (is_dir($helpersDir)) {
    $helperFiles = glob($helpersDir . '/*.php');
    echo "✓ Helpers: " . count($helperFiles) . " helper classes\n";
} else {
    echo "✗ Helpers: Directory not found\n";
}

// 6. Check Validation
$validationDir = $projectRoot . '/app/Validation';
if (is_dir($validationDir)) {
    $validationFiles = glob($validationDir . '/*.php');
    echo "✓ Validation: " . count($validationFiles) . " validation classes\n";
} else {
    echo "✗ Validation: Directory not found\n";
}

echo "\n";
echo "🔍 Code Quality Checks:\n\n";

// Check for long methods
$controllersDir = $projectRoot . '/app/Controllers';
$longMethodsFound = [];

if (is_dir($controllersDir)) {
    $controllerFiles = glob($controllersDir . '/*.php');
    
    foreach ($controllerFiles as $file) {
        $longMethods = checkMethodLength($file);
        if (!empty($longMethods)) {
            $longMethodsFound[basename($file)] = $longMethods;
        }
    }
}

if (empty($longMethodsFound)) {
    echo "✓ Method Length: All methods are under 50 lines ✅\n";
} else {
    echo "⚠ Long Methods Found:\n";
    foreach ($longMethodsFound as $file => $methods) {
        echo "  $file:\n";
        foreach ($methods as $method) {
            echo "    - {$method['method']}() - {$method['length']} lines (line {$method['line']})\n";
        }
    }
}

// Check for direct model usage in controllers
$directModelUsage = [];
foreach (glob($controllersDir . '/*.php') as $file) {
    $content = file_get_contents($file);
    if (preg_match('/new\s+(User|Applicant|Payment|Document)\s*\(/', $content) && 
        !preg_match('/Service/', $content)) {
        $directModelUsage[] = basename($file);
    }
}

if (empty($directModelUsage)) {
    echo "✓ Model Usage: Controllers use services (not direct models) ✅\n";
} else {
    echo "⚠ Direct Model Usage in Controllers:\n";
    foreach ($directModelUsage as $file) {
        echo "  - $file\n";
    }
}

echo "\n";
echo "📈 Architecture Score:\n\n";

$score = 100;
$checks = [
    'Services' => is_dir($servicesDir) && count($serviceFiles) >= 3,
    'DTOs' => is_dir($dtosDir) && count($dtoFiles) >= 3,
    'Exceptions' => is_dir($exceptionsDir) && count($exceptionFiles) >= 4,
    'Helpers' => is_dir($helpersDir) && count($helperFiles) >= 1,
    'Validation' => is_dir($validationDir) && count($validationFiles) >= 1,
    'Clean Controllers' => empty($directModelUsage),
    'Method Length' => empty($longMethodsFound),
];

foreach ($checks as $check => $passed) {
    if ($passed) {
        echo "  ✓ $check\n";
    } else {
        echo "  ✗ $check\n";
        $score -= 15;
    }
}

echo "\n";
echo "══════════════════════════════════════════\n";
echo " Overall Score: $score/100\n";
echo "══════════════════════════════════════════\n";

if ($score >= 90) {
    echo "\n🎉 Excellent! Clean code architecture implemented.\n";
} elseif ($score >= 70) {
    echo "\n👍 Good! Most clean code practices are in place.\n";
} elseif ($score >= 50) {
    echo "\n⚠️  Fair. Some refactoring needed.\n";
} else {
    echo "\n❌ Needs improvement. Major refactoring required.\n";
}

echo "\n✨ For details, see CLEAN_CODE_REFACTORING.md\n";
echo "\n";

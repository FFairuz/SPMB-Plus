#!/bin/bash

# Script untuk membersihkan file-file yang tidak diperlukan
# Dibuat: 15 Januari 2026

echo "=========================================="
echo "CLEANUP: Menghapus File Tidak Diperlukan"
echo "=========================================="
echo ""

# Backup dulu ke folder backup
BACKUP_DIR="backup_before_cleanup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

echo "1. Membuat backup file yang akan dihapus..."

# File-file testing/debugging yang akan dihapus
FILES_TO_DELETE=(
    # Testing PHP files
    "check_*.php"
    "test_*.php"
    "fix_*.php"
    "debug_*.php"
    
    # Batch files
    "*.bat"
    "cleanup_files.bat"
    
    # SQL files (kecuali migrations)
    "*.sql"
    
    # Text files
    "cookies.txt"
    "migrate_output.txt"
    "SUMMARY.txt"
    
    # Dokumentasi development (banyak sekali)
    "*_SUMMARY.md"
    "*_CHECKLIST.md"
    "*_GUIDE.md"
    "*_REPORT.md"
    "*_UPDATE.md"
    "*_FIX.md"
    "*_COMPLETE.md"
    "*_COMPARISON.md"
    "BEFORE_AFTER_*.md"
    "CARA_*.md"
    "CLEAN_CODE_*.md"
    "COMPLETION_*.md"
    "DASHBOARD_*.md"
    "DEVELOPER_*.md"
    "DOKUMENTASI_*.md"
    "FIX_*.md"
    "INDEX_*.md"
    "KELOLA_*.md"
    "MENU_*.md"
    "PERBAIKAN_*.md"
    "QUICK_*.md"
    "README_*.md"
    "SOLUSI_*.md"
    "START_*.md"
    "TESTING_*.md"
    "TROUBLESHOOTING_*.md"
    
    # Keep only essential docs:
    # - README.md (main)
    # - CHANGELOG.md (if exists)
    # - LICENSE
)

# Copy files to backup
echo "   Copying files to backup folder..."
for pattern in "${FILES_TO_DELETE[@]}"; do
    for file in $pattern; do
        if [ -f "$file" ]; then
            cp "$file" "$BACKUP_DIR/" 2>/dev/null
        fi
    done
done

echo "   ✓ Backup created in: $BACKUP_DIR"
echo ""

# Count files before cleanup
BEFORE_COUNT=$(ls -1 *.md *.txt *.bat *.sql *.php 2>/dev/null | wc -l)
echo "2. File sebelum cleanup: $BEFORE_COUNT file"
echo ""

# Delete files
echo "3. Menghapus file..."
DELETED_COUNT=0
for pattern in "${FILES_TO_DELETE[@]}"; do
    for file in $pattern; do
        if [ -f "$file" ]; then
            # Don't delete essential files
            if [[ "$file" != "README.md" && "$file" != "CHANGELOG.md" && "$file" != "LICENSE" && "$file" != "composer.json" && "$file" != "phpunit.xml.dist" ]]; then
                rm -f "$file"
                echo "   ✓ Deleted: $file"
                ((DELETED_COUNT++))
            fi
        fi
    done
done

echo ""
echo "4. Total file dihapus: $DELETED_COUNT file"

# Count after cleanup
AFTER_COUNT=$(ls -1 *.md *.txt *.bat *.sql *.php 2>/dev/null | wc -l)
echo "5. File setelah cleanup: $AFTER_COUNT file"
echo ""

# Show remaining files
echo "6. File yang tersisa di root directory:"
ls -1 *.md *.txt *.php 2>/dev/null | head -20

echo ""
echo "=========================================="
echo "CLEANUP SELESAI!"
echo "=========================================="
echo ""
echo "Backup location: $BACKUP_DIR"
echo "File dihapus: $DELETED_COUNT"
echo ""
echo "File penting yang TIDAK dihapus:"
echo "  - README.md"
echo "  - CHANGELOG.md (jika ada)"
echo "  - LICENSE"
echo "  - composer.json"
echo "  - phpunit.xml.dist"
echo "  - spark"
echo ""

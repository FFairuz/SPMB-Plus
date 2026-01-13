@echo off
REM Login as bendahara and access verifikasi pembayaran

set COOKIE_JAR=cookies.txt
set BASE_URL=http://localhost:8080

REM Step 1: Get CSRF token from login page
curl -s -c "%COOKIE_JAR%" "%BASE_URL%/login" > nul

REM Step 2: Login as bendahara
curl -s -b "%COOKIE_JAR%" -c "%COOKIE_JAR%" -X POST "%BASE_URL%/login" ^
  -H "Content-Type: application/x-www-form-urlencoded" ^
  -d "email=bendahara@ppdb.local&password=password123" ^
  -L > nul

REM Step 3: Access verifikasi pembayaran
echo Accessing: %BASE_URL%/bendahara/verifikasi-pembayaran
curl -s -b "%COOKIE_JAR%" "%BASE_URL%/bendahara/verifikasi-pembayaran" | find "Verifikasi Pembayaran"

echo.
echo Done! Check browser at %BASE_URL%/bendahara/verifikasi-pembayaran

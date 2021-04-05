@echo off
cls
cd..
IF EXIST "c:\php\php.exe" (
  echo using existing .\Output\mechs.csv	
  c:\php\php.exe --no-php-ini -d memory_limit=4096M .\php\dumpstats.php
  c:\php\php.exe --no-php-ini -d memory_limit=4096M .\php\aitag.php
) ELSE (
  echo You should have a php 7 install in c:\php. Get https://windows.php.net/downloads/releases/php-7.4.15-Win32-vc15-x64.zip and extract to c:\php
)
pause
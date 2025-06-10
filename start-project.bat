@echo off
title E-Board - Dev com Mailhog

echo Iniciando servidor Laravel...
start cmd /k "php artisan serve"

echo Iniciando Vite (npm run dev)...
start cmd /k "npm run dev"

echo Iniciando MailHog (via mailhog/mailhog.exe)...
start cmd /k "mailhog\mailhog.exe"

echo.
echo ✅ Ambiente iniciado com sucesso!
echo -------------------------------------
echo Laravel:  http://localhost:8000
echo Mailhog:  http://localhost:8025

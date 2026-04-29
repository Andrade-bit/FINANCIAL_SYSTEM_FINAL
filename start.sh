#!/bin/bash
php artisan config:clear
php artisan cache:clear
apache2-foreground

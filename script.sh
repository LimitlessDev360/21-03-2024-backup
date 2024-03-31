#!/bin/bash
(crontab -l | grep -v "/usr/bin/php C:/xampp/htdocs/butcher/21-03-2024-backup/artisan dm:disbursement") | crontab -

(crontab -l | grep -v "/usr/bin/php C:/xampp/htdocs/butcher/21-03-2024-backup/artisan restaurant:disbursement") | crontab -


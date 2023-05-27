:: Run easy-coding-standard (ecs) via this batch file inside your IDE e.g. PhpStorm (Windows only)
:: Install inside PhpStorm the  "Batch Script Support" plugin
cd..
cd..
cd..
cd..
cd..
cd..
php vendor\bin\ecs check vendor/markocupic/nav-page-container/src --fix --config vendor/markocupic/nav-page-container/tools/ecs/config.php
php vendor\bin\ecs check vendor/markocupic/nav-page-container/contao --fix --config vendor/markocupic/nav-page-container/tools/ecs/config.php
php vendor\bin\ecs check vendor/markocupic/nav-page-container/config --fix --config vendor/markocupic/nav-page-container/tools/ecs/config.php
php vendor\bin\ecs check vendor/markocupic/nav-page-container/tests --fix --config vendor/markocupic/nav-page-container/tools/ecs/config.php

<?php
echo file_exists('app/Http/Controllers/PublicWeb/HomeController.php') ? "HomeController found\n" : "HomeController not found\n";
echo file_exists('app/Services/Lims/CoaPdfGeneratorService.php') ? "CoaPdfGeneratorService found\n" : "CoaPdfGeneratorService not found\n";

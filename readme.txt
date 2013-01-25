 Clix Framework
****************
micro-framework designed for creating micro-sites and small web applications

Author: Petr Kratina <petr.kratina@gmail.com>
Website: http://clix.red-pill.cz/
Project home: http://code.google.com/p/clix-framework/

Installation:
1) set-up your web server to rewrite all request to "index.php"
    (except those wich point inside "public" folder)
2) copy Clix.php to root of your website
3) create "views" and "public" folders
4) create "index.phtml" inside "views" folder
5) create "index.php" inside root folder and fill with this code:
    <?php
    require_once 'Clix.php';
    new Clix();
6) enjoy your first web build on Clix Framework ;)

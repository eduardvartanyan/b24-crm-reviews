<?php
declare(strict_types=1);

use App\CRest;
use App\Logger;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {

    switch ($uri) {
        case '/index.php':
            if ($method == 'POST') {
                $result = CRest::call('profile');
                echo '<pre>'; print_r($result); echo '</pre>';
            }
            break;

        case '/activities/getreviewlink':
            if ($method == 'POST') {
                Logger::info('Запрос из бизнес-процесса', $_SERVER);
                Logger::info('Параметры из запроса', $_POST);
                echo 'Get review link';
            }
            break;
    }
} catch (Throwable $e) {
    echo $e->getMessage();
}

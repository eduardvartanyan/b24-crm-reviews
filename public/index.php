<?php
declare(strict_types=1);

use App\Container;
use App\CRest;
use App\Services\B24Service;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    /** @var Container $container */

    switch ($uri) {
        case '/index.php':
            if ($method == 'POST') {
                $result = CRest::call('profile');
                echo '<pre>'; print_r($result); echo '</pre>';
            }
            break;

        case '/activities/getreviewlink':
            if (
                $method == 'POST'
                && isset($_POST['document_id']) && is_array($_POST['document_id']) && count($_POST['document_id']) >= 3
            ) {

                echo 'Get review link';
            }
            break;

        case '/test':
            $b24service = $container->get(B24Service::class);
            $b24service->getDealContactIds(172176);
            break;
    }
} catch (Throwable $e) {
    echo $e->getMessage();
}

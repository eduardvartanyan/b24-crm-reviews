<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\B24Service;
use App\Services\LinkService;
use App\Support\Logger;

class LinkController
{
    public function __construct(private LinkService $linkService) { }

    public function getReviewLinks(): void
    {
        if (
            empty($_REQUEST['document_id'])
            || !is_array($_REQUEST['document_id'])
            || count($_REQUEST['document_id']) < 3
        ) {
            http_response_code(400);
            return;
        }

        $dealId = (int) str_replace('DEAL_', '', $_REQUEST['document_id'][2]);

        $dealReviewLinks = $this->linkService->getDealReviewLinks($dealId, $_REQUEST['auth']['domain']);

        $url = $_REQUEST['auth']['client_endpoint'] . 'bizproc.event.send.json?' . http_build_query([
                'auth' => $_REQUEST['auth']['access_token'],
                'event_token' => $_REQUEST['event_token'],
                'return_values' => [
                    'link' => $dealReviewLinks,
                ]
            ]);
        $result = file_get_contents($url);

        Logger::info('/activities/getreviewlinks', [
            'request'  => $_REQUEST,
            'response' => $url,
            'result'   => $result,
        ]);
    }
}
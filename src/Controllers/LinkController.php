<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\LinkService;

readonly class LinkController
{
    public function __construct(private LinkService $linkService) { }

    public function sendReviewLinks(): void
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
        $this->linkService->sendReviewLinks($dealId);
    }
}
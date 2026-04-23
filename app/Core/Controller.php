<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    public function __construct(protected Request $request, protected Response $response)
    {
    }

    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }
}

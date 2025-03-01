<?php

namespace Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../App/Views/' . $view . '.php';
    }
}

?>
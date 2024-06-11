<?php

namespace App\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;

class PdfService
{
    private $pdf;
    private $twig;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function generatePdf(string $template, array $data): string
    {
        $html = $this->twig->render($template, $data);
        return $this->pdf->getOutputFromHtml($html);
    }
}
<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class DocumentationController extends Controller
{
    public function generate()
    {
        $mdPath = base_path('DOCUMENTATION.md');
        if (!File::exists($mdPath)) {
            return "DOCUMENTATION.md not found.";
        }

        $content = File::get($mdPath);

        // Simple Markdown to HTML conversion for the PDF
        $html = "
        <html>
        <head>
            <style>
                body { font-family: 'DejaVu Sans', sans-serif; line-height: 1.6; color: #333; }
                h1 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
                h2 { color: #0056b3; margin-top: 30px; border-bottom: 1px solid #ddd; }
                h3 { color: #333; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background-color: #f8f9fa; }
                .footer { text-align: center; font-size: 12px; color: #777; margin-top: 50px; }
            </style>
        </head>
        <body>
            " . $this->parseMarkdown($content) . "
            <div class='footer'>Entrepreneur ERP - Documentation Officielle</div>
        </body>
        </html>
        ";

        $pdf = Pdf::loadHTML($html);
        $outputPath = public_path('DOCUMENTATION_FONCTIONNELLE.pdf');
        $pdf->save($outputPath);

        return "Documentation PDF generated at: " . $outputPath;
    }

    private function parseMarkdown($text)
    {
        // Very basic manual parsing for the specific structure of DOCUMENTATION.md
        $text = e($text);

        // Headers
        $text = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $text);
        $text = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $text);

        // Bold
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);

        // Horizontal rule
        $text = preg_replace('/^---$/m', '<hr>', $text);

        // Tables (Specific for our table in DOCUMENTATION.md)
        if (preg_match('/\| Table \| Rôle Fonctionnel \|/', $text)) {
            $lines = explode("\n", $text);
            $inTable = false;
            $tableHtml = "<table><thead>";
            $newLines = [];

            foreach ($lines as $line) {
                if (strpos($line, '| Table |') !== false) {
                    $inTable = true;
                    $tableHtml .= "<tr><th>Table</th><th>Rôle Fonctionnel</th></tr></thead><tbody>";
                    continue;
                }
                if ($inTable && strpos($line, '| :--- |') !== false) {
                    continue;
                }
                if ($inTable && preg_match('/^\| `(.*?)` \| (.*?) \|$/', $line, $matches)) {
                    $tableHtml .= "<tr><td><code>{$matches[1]}</code></td><td>{$matches[2]}</td></tr>";
                    continue;
                }
                if ($inTable && trim($line) == "") {
                    $inTable = false;
                    $tableHtml .= "</tbody></table>";
                    $newLines[] = $tableHtml;
                    continue;
                }
                if (!$inTable) {
                    $newLines[] = $line;
                }
            }
            $text = implode("\n", $newLines);
        }

        // Lists
        $text = preg_replace('/^- (.*)$/m', '<li>$1</li>', $text);
        $text = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $text);

        // Numbered lists
        $text = preg_replace('/^\d+\. (.*)$/m', '<li>$1</li>', $text);
        // Note: this simple list parsing might be buggy but should work for our specific MD

        // Newlines to <br> for non-html lines
        $text = nl2br($text);

        return $text;
    }
}

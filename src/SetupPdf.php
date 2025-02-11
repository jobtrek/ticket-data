<?php

namespace TicketData;

use InvalidArgumentException;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\RicherScopeGetTypeHelper;
use Ramsey\Uuid\Uuid;
use TCPDF;

class SetupPdf extends TCPDF
{
    private Sticker $sticker;
    public int $number_of_stickers_per_type = 1;
    public int $size_of_datamatrix = 20;
    public int $top_margin;
    public int $left_margin;
    public int $right_margin;
    public int $space;

    public function __construct(Sticker $sticker, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $left_margin = 0, $right_margin = 0, $top_margin = 0,$space = 0)
    {
        parent::__construct();
        $this->sticker = $sticker;
        
        $this->left_margin = $left_margin;
        $this->right_margin = $right_margin;
        $this->top_margin = $top_margin;
        
        $this->SetMargins($this->left_margin, $this->top_margin, $this->right_margin);
        $this->space = $space;
    }
    
    public function calculate_column($width_of_content): int
    {
        return floor((($this->getPageWidth() - ($this->right_margin + $this->left_margin)) / ($width_of_content + $this->space)));
    }
    
    public function calculate_line($height_of_content): int
    {
        return floor((($this->getPageHeight() - $this->top_margin ) / ($height_of_content + $this->space)));
    }

    public function generate_uuid(): string
    {
        $uuid = Uuid::uuid4()->toString();
        return str_replace('-', '', $uuid);
    }

    public function ask_number_of_sticker_per_type(): void
    {
        echo "How many stickers per type do you want to generate ?\n";
        $value = trim(fgets(STDIN));
        $this->number_of_stickers_per_type = $value;
    }

    public function generateDataMatrix(array $array_of_x_and_y): void
    {
        foreach ($array_of_x_and_y as $array_position) {
            $x = $array_position["x"];
            $y = $array_position["y"];
            $this->SetXY($x, $y);
            $uuid = $array_position["uuid"] ?? $this->generate_uuid();
            $this->write2DBarcode(
                $uuid,
                'DATAMATRIX',
                $this->GetX(),
                $this->GetY(),
                $this->size_of_datamatrix,
                $this->size_of_datamatrix,
                [
                    'border' => 0,
                    'vpadding' => 0,
                    'hpadding' => 0,
                    'fgcolor' => [0, 0, 0],
                    'bgcolor' => false,
                    'module_width' => 1,
                    'module_height' => 1,
                ],
                'N');
        }
    }
    public function calculate_position($content_width, $content_height): array
    {
        $positions = [];
        $number_of_columns = $this->calculate_column($content_width);
        $number_of_lines = $this->calculate_line($content_height);

        $y = $this->top_margin;
        for ($line = 0; $line < $number_of_lines; $line++) {
            $x = $this->left_margin;
            for ($column = 0; $column < $number_of_columns; $column++) {
                
                if ($x > (int)$this->getPageWidth() || $y > (int)$this->getPageHeight()) {
                    continue;
                }
                
                $positions[] = [
                    "x" => $x,
                    "y" => $y,
                ];
                
                $x += $this->space + $content_width;
            }
            $y += $this->space + $content_height;
        }
        
        return $positions;
    }
    
    
}
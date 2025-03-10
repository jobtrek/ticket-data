<?php

namespace TicketData;

use Ramsey\Uuid\Uuid;
use TCPDF;

class SetupPdf
{
    public int $numberOfSticker = 1;
    public array $listOfDeviceName;
    public int $size_of_datamatrix = 12;
    public int $top_margin = 3;
    public int $left_margin = 3;
    public int $right_margin = 0;
    public int $space = 2;
    public Sticker $sticker;
    public TCPDF $tcpdf;
    
    public function __construct(
        TCPDF $tcpdf,
        Sticker $sticker,
        int $left_margin = 3,
        int $right_margin = 0,
        int $top_margin = 3,
        int $space = 2,
        int $size_of_datamatrix = 12
    )
    {
        
        $this->left_margin = $left_margin;
        $this->right_margin = $right_margin;
        $this->top_margin = $top_margin;
        
        $this->sticker = $sticker;
        $this->tcpdf = $tcpdf;
        
        $this->tcpdf->SetMargins($this->left_margin, $this->top_margin, $this->right_margin);
        $this->space = $space;
        $this->size_of_datamatrix = $size_of_datamatrix;
    }
    
    public function calculate_columns(int $width_of_content): int
    {
        return (int)floor((($this->tcpdf->getPageWidth() - ($this->right_margin + $this->left_margin)) / ($width_of_content + $this->space)));
    }
    
    public function calculate_lines(int $height_of_content): int
    {
        return (int)floor((($this->tcpdf->getPageHeight() - $this->top_margin) / ($height_of_content + $this->space)));
    }

    public function generate_uuid(): string
    {
        return Uuid::uuid4()->getHex()->toString();
    }

    public function askNumberOfSticker(): void
    {
        echo "Combien d'étiquette voulez vous générer ?\n";
        $value = trim(fgets(STDIN));
        $this->numberOfSticker = (int)$value;
    }

    public function askNameOfDevice(): void
    {
        echo "Veuillez fournir le numéro du/des devices\n";
        $value = trim(fgets(STDIN));
        $this->listOfDeviceName = (array)$value;
    }

    public function cropMarks($array_of_x_and_y): void
    {
        $this->tcpdf->setLineStyle([
            'width' => 0.2,
            'cap' => 'square',
            'join' => 'miter',
            'dash' => 2,
            'color' => [0, 0, 0],
        ]);
        foreach ($array_of_x_and_y as $array_position) {

            $x = $array_position["x"];
            $y = $array_position["y"];

            $this->tcpdf->Rect($x, $y, $this->sticker->getWidth(), $this->sticker->getHeight());
        }
    }
    

    public function place_text(string $textToPrint, string $position = 'B'): void
    {
        switch ($position){
            case 'B':
                $this->tcpdf->Text($this->tcpdf->GetX() + $this->size_of_datamatrix + 2, $this->tcpdf->GetY() + $this->size_of_datamatrix - $this->tcpdf->getFontSize(), $textToPrint);
                break;
            case 'T':
                $this->tcpdf->Text($this->tcpdf->GetX() + $this->size_of_datamatrix + 2, $this->tcpdf->GetY(), $textToPrint);
                break;
            case 'M':
                $this->tcpdf->Text($this->tcpdf->GetX() + $this->size_of_datamatrix + 2, $this->tcpdf->GetY() + $this->tcpdf->getFontSize(), $textToPrint);
                break;
        }
    }

    /**
     * @param array<int, array{x: int, y: int}> $array
     * @return void
     */
    public function generatedatamatrix(array $array): void
    {
        $arrayLength = count($array);
        
        for ($i = 0; $i < $arrayLength; $i++) {
            $this->generateOneDatamatrix();
            $i++;
        }
    }

    public function generateOneDatamatrix(string $uuid = null):void
    {
        if ($uuid === null) {
            $uuid = $this->generate_uuid();
        }
        
        $this->tcpdf->write2DBarcode(
            $uuid,
            'DATAMATRIX',
            $this->tcpdf->GetX(),
            $this->tcpdf->GetY(),
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
        public function generateManyDatamatrix(int $numberOf = null): void
        {
                
                $array_of_positions = $this->calculatePositionInPdf($this->size_of_datamatrix, $this->size_of_datamatrix);
                $this->generatedatamatrix(array_slice($array_of_positions, 0, $numberOf));
        }

    /**
     * @param array<int, array{x: int, y: int, inventory?: string}> $array
     * @return void
     */
    public function generateDatamatrixWithText(array $array): void
    {
        $positionInPdf = $this->calculatePositionInPdf($this->sticker->getWidth(), $this->sticker->getHeight());
        
        $this->cropMarks(array_slice($positionInPdf, 0, count($array)));
        
        $positionInSticker = $this->centerDatamatrixInStickers($positionInPdf);
        
        $finalArray = $this->merge_array_of_position_and_array_of_content($positionInSticker, $array);
        
            foreach ($finalArray as $iValue) {

                $x = $iValue["x"];
                $y = $iValue["y"];

                $this->tcpdf->SetXY($x, $y);
                $this->generateOneDatamatrix();

                $this->tcpdf->SetXY($x, $y);
                $this->place_text($iValue['inventory']);
                
            }
            
    }

    /**
     * @param array<int, array{x: int, y: int}> $array_of_positions array of positions x and y where the content will be placed
     * @param array<int, array{inventory: string}> $array_of_content array of content to place in the pdf
     * @return array<int, array{x: int, y: int, inventory: string}> array of positions x and y where the content will be placed
     */
    public function merge_array_of_position_and_array_of_content(array $array_of_positions, array $array_of_content): array
    {
        $array_of_positions_with_content = [];
        
        foreach ($array_of_content as $i => $iValue) {
            
            $array_of_positions_with_content[] = [
                "x" => $array_of_positions[$i]["x"],
                "y" => $array_of_positions[$i]["y"],
                "inventory" => $iValue["inventory"],
            ];
            
        }
        return $array_of_positions_with_content;
    }
    
    
    /**
     * @param array<int, array{x: int, y: int}> $positionsInPdf
     * @return array<int, array{x: int, y: int}>
     */
    public function centerDatamatrixInStickers(array $positionsInPdf): array
    {
        $positions = [];
        $availableSpace = $this->sticker->getHeight() - $this->size_of_datamatrix;
        $offset = (int) ($availableSpace / 2);
        
        foreach ($positionsInPdf as $position) {
            $x = $position["x"] + $offset;
            $y = $position["y"] + $offset;
            $positions[] = [
                "x" => $x,
                "y" => $y,
            ];
        }
        return $positions;
    }

    /**
     * @param int $content_width the width of the content to place in the pdf
     * @param int $content_height the height of the content to place in the pdf
     * @return array<int, array{x: int, y: int}> array of positions x and y where the content will be placed
     */
    public function calculatePositionInPdf(int $content_width, int $content_height): array
    {
        $positions = [];
        $number_of_columns = $this->calculate_columns($content_width);
        $number_of_lines = $this->calculate_lines($content_height);
        
        $y = $this->top_margin;
        
        for ($line = 0; $line < $number_of_lines; $line++) {
            
            $x = $this->left_margin;
            
            if (count($positions) === 100){
                echo "You can't generate more than 100 stickers at once\n";
                break;
            }
            
            for ($column = 0; $column < $number_of_columns; $column++) {
                
                if ($x > (int)$this->tcpdf->getPageWidth()) {
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
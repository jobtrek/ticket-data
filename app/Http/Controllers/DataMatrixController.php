<?php

namespace App\Http\Controllers;

use App\Services\SetupPdfService;
use App\Services\StickerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use TCPDF;

class DataMatrixController extends Controller
{
    /**
     * Display the Data Matrix page.
     */
    public function index(): \Illuminate\View\View
    {
        return view('forms.datamatrix', [
            'datamatrix' => Arr::flatten(Cache::get('datamatrix', []), 1),
        ]);
    }

    public function deleteOneNumber(Request $request): RedirectResponse
    {
        $datamatrix = Cache::get('datamatrix', []);
        array_splice($datamatrix, $request->input('key'), 1);
        Cache::put('datamatrix', $datamatrix);
        return redirect()->route('data')->with('success', 'Datamatrix supprimée avec succès.');
    }

    /**
     * Handle the Data Matrix generation request.
     */
    public function cacheNewNumber(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'data' => 'required|string|max:11',
        ]);

        $array = Cache::get('datamatrix', []);

        $array[] = $data;

        Cache::put('datamatrix', $array);

        return redirect()->route('data')->with('success', 'Datamatrix mise en cache avec succès.');
    }
    
    public function generateDataMatrix(Request $request): RedirectResponse
    {
        $datamatrix = Cache::get('datamatrix', []);
        $use = $request->get("quantity");
        $resultat = collect($datamatrix)->flatMap(function ($sousTableau) use ($use) {
            return array_fill(0, $use, $sousTableau);
        });
        $datamatrix = $resultat->toArray();
        
        $tcpdf = new TCPDF();
        $sticker = new StickerService(45, 25);
        $setupPdf = new SetupPdfService($tcpdf, $sticker, 5,0,5);
        $tcpdf->setPrintHeader(false);
        $tcpdf->setPrintFooter(false);
        $tcpdf->setAutoPageBreak(true,0);
        $tcpdf->SetFont('helvetica', 'B', 10);
        $tcpdf->AddPage();
        $positionSticker = $setupPdf->calculatePositionInPdf($sticker->getWidth(), $sticker->getHeight());
        $positionInSticker = $setupPdf->centerDatamatrixInStickers($positionSticker);
        $finalPosition = $setupPdf->merge_array_of_position_and_array_of_content($positionInSticker, $datamatrix);
        $setupPdf->generateDatamatrixWithText($finalPosition);
        $tcpdf->Output(public_path('/pdfs/datamatrix'. $setupPdf->returnNumberOfPdf() . '.pdf'), 'F');
        Cache::flush();
        return redirect()->route('data')->with('success', 'Les datamatrix ont été générées avec succès.');
    }
}

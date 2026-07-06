<?php

namespace App\Modul\SEO\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modul\SEO\Services\SEOAnalyzer;
use Illuminate\Http\Request;

class SEOController extends Controller
{
    public function periksa(Request $request)
    {
        $analyzer = new SEOAnalyzer();
        $hasil = $analyzer->analisis($request->all());
        
        return response()->json($hasil);
    }
}

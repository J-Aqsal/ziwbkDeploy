<?php

namespace App\Http\Controllers\user_page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class LayananPengaduanController extends Controller
{
    public function index(){
        $contents = Content::where('status', 'Aktif')
        ->whereHas('content_categories', function ($query) {
            $query->where('nama', 'Layanan Pengaduan');
        })->get();
        $pageConfigs = ['myLayout' => 'front'];
        return view('user_page.layanan-pengaduan', compact('contents'), ['pageConfigs' => $pageConfigs]);
    }
}
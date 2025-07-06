<?php

namespace App\Http\Controllers;

use App\DataTables\AbsenDataTable;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\PresenceDetail;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug, AbsenDataTable $dataTable)
    {
        $presence=Presence::where('slug', $slug)->first();
       
        return $dataTable->render('pages.absen.index', compact('presence'));
    }

    public function save(Request $request,  string $id)
    {
        $presence = Presence::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'asal_instansi' => 'required',
            'signature' => 'required',
        ]);

    $presenceDetail = new PresenceDetail();
    $presenceDetail->presence_id = $presence->id;
    $presenceDetail->nama = $request->nama;
    $presenceDetail->jabatan = $request->jabatan;
    $presenceDetail->asal_instansi = $request->asal_instansi;
    
    $base64_Image = $request->signature;
    @list($type, $file_data) = explode(';', $base64_Image);
    @list(, $file_data) = explode(',', $file_data);

    //generate files name
    $uniqChar = date('YmdHis') . uniqid();
    $signature="tanda-tangan/{$uniqChar}.png";

    //simpan gambar ke public folder
    Storage::disk('public_uploads')->put($signature, base64_decode($file_data));
   $presenceDetail->tanda_tangan = $signature;
    $presenceDetail->save();

    return redirect()->back();


        

       
    }
}

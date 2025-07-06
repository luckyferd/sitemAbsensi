<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\PresenceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PresenceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exportPdf(string $id)
    
    {
        $presence = Presence::findOrFail($id);
        $presenceDetails=PresenceDetail::where('presence_id', $id)->get();
        
        $pdf = Pdf::setOption(['isRemoteEnabled'=>true])
        ->loadView('pages.presence.detail.export-pdf', compact('presence','presenceDetails'))
        ->setPaper('A4', 'portrait');
        return $pdf->stream( "{$presence->nama_kegiatan }.pdf", ['Attachment' => 0]);
    exit();
    }
     public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $presenceDetail = PresenceDetail::findOrFail($id);
        if($presenceDetail->tanda_tangan) {
            // Hapus file tanda tangan dari storage
            Storage::disk('public_uploads')->delete($presenceDetail->tanda_tangan);
        }
        $presenceDetail->delete();
        return response()->json([
            'status' => 'success','message' => 'Data berhasil dihapus.'
        ]);
    }
}

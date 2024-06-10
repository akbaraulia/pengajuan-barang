<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Traits\ApproveRejectTrait;

class FinancePengajuanController extends Controller
{
    use ApproveRejectTrait;

    public function index()
    {
        $pengajuans = Pengajuan::where('status', 'approved_manager')->with('user')->get();
        return response()->json($pengajuans, 200);
    }




    public function approvePengajuan(Request $request, $id)
    {
        $request->validate([
            'proof_of_transfer' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        if ($request->hasFile('proof_of_transfer')) {
            $path = $request->file('proof_of_transfer')->store('proofs', 'public');
            $pengajuan->proof_of_transfer = asset('storage/' . $path);
            $pengajuan->save();
        }

        $this->approve($id, 'finance');

        return response()->json([
            'message' => 'Pengajuan approved successfully',
            'proof_of_transfer_url' => $pengajuan->proof_of_transfer,
        ], 200);
    }


    public function rejectPengajuan(Request $request, $id)
    {
        $this->reject($id, $request->input('reason'), 'finance');
        return response()->json(['message' => 'Pengajuan rejected successfully'], 200);
    }
}
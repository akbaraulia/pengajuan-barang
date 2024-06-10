<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Traits\ApproveRejectTrait;

class ManagerPengajuanController extends Controller
{
    use ApproveRejectTrait;

    public function index()
    {
        $pengajuans = Pengajuan::where('status', 'pending')->with('user')->get();
        return response()->json($pengajuans, 200);
    }


    public function approvePengajuan(Request $request, $id)
    {
        $this->approve($id, 'manager');
        return response()->json(['message' => 'Pengajuan approved successfully'], 200);
    }

    public function rejectPengajuan(Request $request, $id)
    {

        $this->reject($id, $request->input('reason'), 'manager');
        return response()->json(['message' => 'Pengajuan rejected successfully'], 200);
    }
}
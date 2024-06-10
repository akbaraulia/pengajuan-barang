<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{



    public function index()
    {
        $pengajuans = Pengajuan::with('user')->get();
        return response()->json($pengajuans);
    }


    public function show($id)
    {
        $pengajuan = Pengajuan::with('user')->findOrFail($id);
        $pengajuan->proof_of_transfer_url = $pengajuan->getProofOfTransferUrlAttribute();
        return response()->json($pengajuan);
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|max:2147483647',
            'price' => 'required|numeric|max:2147483647',
            'status' => 'required|in:pending,approved_manager,approved_finance,rejected',
            'rejection_reason' => 'nullable|string',
            'proof_of_transfer' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['total_price'] = $request->price * $request->quantity;

        $pengajuan = Pengajuan::create($data);
        return response()->json($pengajuan, 201);
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $request->validate([
            'user_id' => 'exists:users,id',
            'item_name' => 'string|max:255',
            'quantity' => 'integer',
            'price' => 'numeric',
            'status' => 'in:pending,approved_manager,approved_finance,rejected',
            'rejection_reason' => 'nullable|string',
            'proof_of_transfer' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        if ($request->has('price') || $request->has('quantity')) {
            $price = $request->has('price') ? $request->price : $pengajuan->price;
            $quantity = $request->has('quantity') ? $request->quantity : $pengajuan->quantity;
            $data['total_price'] = $price * $quantity;
        }

        $pengajuan->update($data);
        return response()->json($pengajuan);
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->delete();
        return response()->json(['message' => 'Pengajuan deleted successfully'], 200);
    }
}
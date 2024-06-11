<?php
namespace App\Traits;

trait ApproveRejectTrait
{
    public function approve($id, $role)
    {
        $pengajuan = \App\Models\Pengajuan::findOrFail($id);
        if ($role == 'manager') {
            $pengajuan->status = 'approved_manager';
            $pengajuan->approved_by_manager = auth()->user()->id;
        } elseif ($role == 'finance') {
            $pengajuan->status = 'approved_finance';
            $pengajuan->approved_by_finance = auth()->user()->id;
        }
        $pengajuan->save();
    }

    public function reject($id, $reason, $role)
    {
        $pengajuan = \App\Models\Pengajuan::findOrFail($id);
        $pengajuan->status = 'rejected';
        $pengajuan->rejection_reason = $reason;
        $pengajuan->save();
    }
}
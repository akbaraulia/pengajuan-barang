<?php

namespace App\Traits;

trait ApproveRejectTrait
{
    public function approve($id, $role)
    {
        $pengajuan = \App\Models\Pengajuan::findOrFail($id);
        if ($role == 'manager') {
            $pengajuan->status = 'approved_manager';
        } elseif ($role == 'finance') {
            $pengajuan->status = 'approved_finance';
        }
        $pengajuan->save();
    }


    public function reject($id, $reason, $role)
    {
        $pengajuan = \App\Models\Pengajuan::findOrFail($id);
        $pengajuan->status = 'rejected';
        $pengajuan->rejection_reason = $reason;
        $pengajuan->rejected_by = $role;
        $pengajuan->save();
    }

}
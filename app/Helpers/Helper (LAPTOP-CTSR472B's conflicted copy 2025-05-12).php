<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\FileModel;

function totalnotification($id_pendaftaran)
{
    $userId = Auth::user()->id_user;
    $total =  FileModel::where('id_pendaftaran', $id_pendaftaran)->where('id_user', $userId)->count();
    return $total;
}
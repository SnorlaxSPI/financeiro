<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Financeiro extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'a_pagar', 'pago'];
}

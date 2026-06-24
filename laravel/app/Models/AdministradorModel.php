<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministradorModel extends Model
{
    use HasFactory;
    protected $table = 'administrador';
    protected $fillable = ['nome', 'email', 'telefone', 'cpf', 'usuario', 'senha', 'status'];
}

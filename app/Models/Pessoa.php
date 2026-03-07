<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pessoa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pessoa'; // Chave primária customizada

    protected $fillable = [
        'nome',
        'sobrenome',
        'cpf',
        'tipo_pessoa',
        'usuario_id'
    ];

    protected $attributes = ['tipo_pessoa' => 'APICULTOR'];

    // Relação com usuário
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
    
        // Relação com pessoa (1:N)
    public function apiarios()
    {
        return $this->hasMany(Apiario::class, 'pessoa_id', 'id_pessoa')->chaperone();
    }

    // Relação com endereços (1:N)
    public function enderecos()
    {
        return $this->hasMany(EnderecoPessoa::class, 'pessoa_id', 'id_pessoa');
    }
}

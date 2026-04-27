<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
    
    public function apiarios(): HasMany
    {
        return $this->hasMany(Apiario::class, 'pessoa_id', 'id_pessoa');
    }

    public function enderecos(): HasMany
    {
        return $this->hasMany(EnderecoPessoa::class, 'pessoa_id', 'id_pessoa');
    }

    public function colmeias(): hasOneThrough
    {
        return $this->hasOneThrough(
            Colmeia::class, Apiario::class,
            'pessoa_id', 'apiario_id', 'id_pessoa', 'id_apiario'
        );
    }
    
    public function getEnderecoPrincipal()
    {
        return $this->enderecos()->first();
    }

}

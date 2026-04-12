<?php

namespace App\Models;

use App\Http\Requests\Apiario\StoreRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnderecoApiario extends Model
{
    protected $table = 'enderecos_apiarios';
    protected $primaryKey = 'id_endereco';

    protected $fillable = [
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'apiario_id'
    ];

    public function apiario(): BelongsTo
    {
        return $this->belongsTo(Apiario::class, 'apiario_id', 'id_apiario');
    }

    public function getEstadoNomeAttribute()
    {
        $ufs = (new StoreRequest())->ufs();
        return $ufs[$this->estado] ?? $this->estado;
    }
}

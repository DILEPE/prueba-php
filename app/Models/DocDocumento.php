<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocDocumento extends Model
{
    protected  $table  = 'doc_documento';
    protected   $fillable = ['nombre','codigo','contenido','tipo_id','proceso_id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->codigo = self::generateCodigo($model->tipo_id, $model->proceso_id);

        });
        static::updating(function ($model){
            if($model->isDirty('tipo_id') || $model ->isDirty('proceso_id')){
                $model->codigo = self::generateCodigo($model->tipo_id, $model->proceso_id);

            }

        });
    }
        public static function generateCodigo($tipoId, $procesoId){

            $tipo = TipTipoDoc::findOrFail($tipoId);
            $proceso = ProProceso::findOrFail($procesoId);

            $lastDocumento = self::where('doc_documento' ,$tipoId)->where('pproceso_id',$procesoId)->orderBy('id', 'desc')->first();
            $consecutivo = $lastDocumento ? intval(substr($lastDocumento->codigo, -1)) + 1 : 1;

            return sprintf('%s-%s-%d' ,$tipo->prefijo, $proceso->prefijo, $consecutivo);

 } 
 public function tipo() 
 {
     return $this->belongsTo(TipTipDoc::class);
 }
 public function proceso() 
 {
    return $this->belongsTo(proceso::class);
 }
}  



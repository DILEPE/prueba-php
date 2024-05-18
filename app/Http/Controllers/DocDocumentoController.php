<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocDocumento;
use App\Models\TipTipDoc;
use App\Models\ProProceso;

class DocDocumentoController extends Controller
{
     
    public function index()
    {
        $document = DocDocument::all();
        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        $tipos = TipTipoDoc::all();
        $tipos =  ProProceso::all();
        return view('documentos.create', compact('tipos', 'procesos'));
    }
    
    public function store(Request $request)
    {
        $validated =   $request->validate([
            'nombre' =>'required|string|max255',
            'contenido' => 'required',
            'ttipo_id' => 'required|exists:tip_tipo_doc,id',
            'proceso_id' => 'required|exists:pro_procesos,id',
        ]);

        DocDocumento::create($validated);

        return redirect()->route('documentos.index')->with('success', 'Documento creado con exito'); 

}

public function edit($id)
{
    $documento = DocDocumento::findOrFail($id);
    $tipos = TipTipoDoc::all();
    $procesos = ProProceso::all();
    return view('documentos.edit', compact('documento','tipos', 'procesos'));
}

public function update(Request $request ,$id)
{
    $validated =   $request->validate([
        'nombre' =>'required|string|max255',
        'contenido' => 'required',
        'ttipo_id' => 'required|exists:tip_tipo_doc,id',
        'proceso_id' => 'required|exists:pro_procesos,id',
    ]);

    $documento = DocDocumento::findOrFail($id);
    $documento->update($validated);

    return redirect()->route('documentos.index')->with('success', 'Docuemnto actualizado con exito');

}

public function destroy($id)
{

    $documento = DocDocumento::findOrFail($id);
    $documento->delete();

    return redirect()->route('documentos.index',)->with('success', 'Docuemto eliminado exitosamente');

  }
}  


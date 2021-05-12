<?php

namespace App\Http\Controllers;

use App\Custom\HardCodeMenu;
use App\Models\Compania;
use App\Models\Extraccion;
use App\Models\Tipodoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use stdClass;

class ExtraccionController extends Controller
{
    //

    public function index()
    {
        $extracciones = Extraccion::all();
        $companias = Compania::all();
        $tipodocs = Tipodoc::all();
        $docs = $this->readXML($tipodocs);

        return Inertia::render('Extraccion',[
            'companias' => $companias,
            'tipodocs' => $tipodocs,
            'extracciones' => $extracciones,
            'docsxml' => $docs,
            'menus' => HardCodeMenu::get_menu()]);
    }

    public function store(Request $request)
    {
        // validacion
        Extraccion::create($request->all());
        return redirect()->back()
            ->with('message','Extracción creado con éxito');
    }

    public function update(Request $request,$id)
    {
        // validacion
        Extraccion::whereId($request->id)->update($request->all());
        return redirect()->back()
            ->with('message','Extracción actualizado con éxito');
    }

    public function destroy($extraccionId)
    {
        $extraccion = Extraccion::find($extraccionId);
        $extraccion->delete();
        return redirect()->back()
        ->with('message','Extracción eliminado con exito');
    }

    /*
        funciones privadas del controlador
    */

    private function readXML($tipodocs)
    {
        
        $docs = [];

        foreach($tipodocs as $index => $tipodoc)
        {
            $nodo = new stdClass();
            $pathfile = "/xml/{$tipodoc->dir_xsd}";
            $xmlString = Storage::get($pathfile);                
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            $nodo->tipodoc = $tipodoc;
            $nodo->xml = $json;
            $docs[] = $nodo;
        }

        return $docs;        
        
    }
/*
$xmlString = file_get_contents(public_path('sample.xml'));
        $xmlObject = simplexml_load_string($xmlString);
                   
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true); 
   
        dd($phpArray);
*/


}

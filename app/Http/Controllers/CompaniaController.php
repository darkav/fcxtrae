<?php

namespace App\Http\Controllers;

use App\Custom\HardCodeMenu;
use App\Models\Compania;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompaniaController extends Controller
{
    //
    public function index()
    {
        $companias = Compania::all();
        return Inertia::render('Compania',['companias' => $companias,'menus' => HardCodeMenu::get_menu()]);
    }

    public function store(Request $request)
    {
        // validacion
        Compania::create($request->all());
        return redirect()->back()
            ->with('message','Compañía creado con éxito');
    }

    public function update(Request $request,$id)
    {
        // validacion
        Compania::whereId($request->id)->update($request->all());
        return redirect()->back()
            ->with('message','Compañía actualizado con éxito');
    }

    public function destroy($companiaId)
    {
        $compania = Compania::find($companiaId);
        $compania->delete();
        return redirect()->back()
        ->with('message','Companía eliminado con exito');
    }
}

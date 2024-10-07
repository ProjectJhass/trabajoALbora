<?php 

namespace App\Http\Controllers;

use App\Models\apps\nexus\ModelEmpresa;
use Illuminate\Http\Request;

class ControllerEmpresa extends Controller
{
    // Mostrar una lista de empresas
    public function index()
    {
        $empresas = ModelEmpresa::all(); // Obtener todas las empresas
        return view('empresas.index', compact('empresas')); // Retornar la vista con las empresas
    }


    
    // Mostrar el formulario para crear una nueva empresa
    public function create()
    {
        return view('empresas.create'); // Retornar la vista del formulario de creación
    }

    // Almacenar una nueva empresa
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validatedData = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'descripcion_empresa' => 'nullable|string',
        ]);

        // Crear una nueva empresa con los datos validados
        ModelEmpresa::create($validatedData);

        // Redirección con mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
    }

    // Mostrar los detalles de una empresa específica
    public function show(ModelEmpresa $empresa)
    {
        return view('empresas.show', compact('empresa')); // Retornar la vista con la empresa
    }

    // Mostrar el formulario para editar una empresa
    public function edit(ModelEmpresa $empresa)
    {
        return view('empresas.edit', compact('empresa')); // Retornar la vista del formulario de edición
    }

    // Actualizar una empresa existente
    public function update(Request $request, ModelEmpresa $empresa)
    {
        // Validación de los datos recibidos
        $validatedData = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'descripcion_empresa' => 'nullable|string',
        ]);

        // Actualizar la empresa con los datos validados
        $empresa->update($validatedData);

        // Redirección con mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada exitosamente.');
    }

    // Eliminar una empresa
    public function destroy(ModelEmpresa $empresa)
    {
        $empresa->delete(); // Eliminar la empresa

        // Redirección con mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada exitosamente.');
    }
}

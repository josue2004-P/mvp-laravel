<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctores = Doctor::all();
        return view('doctores.index', compact('doctores'));
    }

    public function create()
    {
        return view('doctores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:doctores,nombre',
        ]);

        Doctor::create([
            'nombre' => $request->nombre,
            'activo' => true,
            'fechaCreacion' => now(),
            'fechaActualizacion' => now(),
        ]);

        return redirect()->route('doctores.index')->with('success', 'Doctor creado correctamente');
    }

    public function edit(Doctor $doctor)
    {
        return view('doctores.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:doctores,nombre,' . $doctor->id,
        ]);

        $doctor->update([
            'nombre' => $request->nombre,
            'activo' => $request->activo ?? true,
            'fechaActualizacion' => now(),
        ]);

        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado correctamente');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado correctamente');
    }
}

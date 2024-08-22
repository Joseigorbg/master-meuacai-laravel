<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Complemento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PointController extends Controller
{
    use AuthorizesRequests;

    public function loadUserPoints()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('auth.form')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $points = Point::where('user_id', $userId)
            ->whereHas('complemento', function ($query) {
                $query->where('status', 1);
            })
            ->with(['endereco', 'complemento'])
            ->take(3)
            ->get();

        return $points;
    }
    public function loadAllPoints()
    {
        $points = Point::with(['endereco', 'complemento', 'products'])->get();
        return $points;
    }
    

    public function index()
    {
        $points = $this->loadUserPoints();
        return view('profile.manager.manager-point', compact('points'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'tel_contato' => 'required|string|max:19',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'pais' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('auth.form')->with('error', 'Você precisa estar logado para cadastrar um ponto.');
        }

        $point = Point::create([
            'user_id' => $userId,
            'name' => $validatedData['name'],
            'tel_contato' => $validatedData['tel_contato'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        $point->endereco()->create([
            'user_id' => $userId,
            'cep' => $validatedData['cep'],
            'logradouro' => $validatedData['logradouro'],
            'numero' => $validatedData['numero'],
            'complemento' => $validatedData['complemento'],
            'bairro' => $validatedData['bairro'],
            'cidade' => $validatedData['cidade'],
            'estado' => $validatedData['estado'],
            'pais' => $validatedData['pais'],
        ]);

        Complemento::create([
            'point_id_fk' => $point->id,
            'status' => 1,
        ]);

        return redirect()->route('profile.manager.point')->with('success', 'Ponto cadastrado com sucesso!');
    }

    public function edit(Point $point)
    {
        $this->authorize('update', $point);
        $points = $this->loadUserPoints();
        return view('profile.manager.edit-point', compact('point', 'points'));
    }

    public function destroy(Point $point)
    {
        $this->authorize('delete', $point);
        $point->delete();
        return redirect()->route('profile.manager.point')->with('success', 'Ponto excluído com sucesso!');
    }

    public function update(Request $request, Point $point)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'tel_contato' => 'required|string|max:19',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'pais' => 'required|string|max:255',
        ]);

        $this->authorize('update', $point);

        $point->update([
            'name' => $validatedData['name'],
            'tel_contato' => $validatedData['tel_contato'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        $point->endereco->update([
            'cep' => $validatedData['cep'],
            'logradouro' => $validatedData['logradouro'],
            'numero' => $validatedData['numero'],
            'complemento' => $validatedData['complemento'],
            'bairro' => $validatedData['bairro'],
            'cidade' => $validatedData['cidade'],
            'estado' => $validatedData['estado'],
            'pais' => $validatedData['pais'],
        ]);

        return redirect()->route('profile.manager.point')->with('success', 'Ponto atualizado com sucesso!');
    }

    public function loadHighlightedMarkers()
    {
        $highlightedPoints = Point::where('is_highlighted', 1)
            ->with(['endereco', 'complemento', 'products'])
            ->get();

        return response()->json($highlightedPoints);
    }
    public function updateHighlightedPoints()
    {
    // Desmarcar todos os pontos como não destacados
    Point::where('is_highlighted', 1)->update(['is_highlighted' => 0]);

    // Selecionar os 3 pontos com mais likes e marcá-los como destacados
    $highlightedPoints = Point::orderByDesc('likes_count')
        ->take(3)
        ->get();

    foreach ($highlightedPoints as $point) {
        $point->update(['is_highlighted' => 1]);
    }
    }

    public function like(Request $request, $id)
    {
        $point = Point::findOrFail($id);
    
        // Incrementar o contador de likes
        $point->increment('likes_count');
    
        // Retornar a contagem atualizada de likes
        return response()->json(['likes_count' => $point->likes_count]);
    }
    
}

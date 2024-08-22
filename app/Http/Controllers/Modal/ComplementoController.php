<?php

namespace App\Http\Controllers\Modal;

use App\Http\Controllers\Controller;
use App\Models\Complemento;
use Illuminate\Http\Request;

class ComplementoController extends Controller
{
    // Exibe uma lista de todos os complementos.
    public function index()
    {
        $complementos = Complemento::with('point')->get();
        return response()->json($complementos);
    }

    // Exibe um complemento específico.
    public function show($id)
    {
        $complemento = Complemento::with('point')->findOrFail($id);
        return response()->json($complemento);
    }

    // Cria um novo complemento.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'point_id_fk' => 'required|exists:points,id',
            'days_hours' => 'nullable|array',
            'days_hours.day' => 'nullable|array',
            'days_hours.hours' => 'nullable|array',
            'videos' => 'nullable|array',
            'videos.*' => 'file|mimes:mp4,mov,avi|max:102400', // 100MB max por vídeo
            'status' => 'required|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB max por imagem
        ]);

        // Handle file uploads
        if ($request->hasFile('images')) {
            $validatedData['images'] = $this->uploadFiles($request->file('images'), 'images');
        }

        if ($request->hasFile('videos')) {
            $validatedData['videos'] = $this->uploadFiles($request->file('videos'), 'videos');
        }

        $complemento = Complemento::create($validatedData);

        return response()->json($complemento, 201);
    }

    // Atualiza um complemento específico.
    public function update(Request $request, $id)
    {
        $complemento = Complemento::findOrFail($id);
    
        // Valida os dados do request
        $validatedData = $request->validate([
            'status' => 'required|boolean',
            'days_hours' => 'nullable|array',
            'days_hours.day.*' => 'nullable|string',
            'days_hours.hours.*' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'videos.*' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
        ]);
    
        // Atualiza o status
        $complemento->status = $validatedData['status'];
    
        // Converte `days_hours` para JSON
        if ($request->has('days_hours')) {
            $complemento->days_hours = json_encode([
                'day' => $validatedData['days_hours']['day'] ?? [],
                'hours' => $validatedData['days_hours']['hours'] ?? []
            ]);
        }
    
        // Processa as imagens
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('complementos/images', 'public');
                $images[] = $path;
            }
            $complemento->images = json_encode($images);
        }
    
        // Processa os vídeos
        if ($request->hasFile('videos')) {
            $videos = [];
            foreach ($request->file('videos') as $video) {
                $path = $video->store('complementos/videos', 'public');
                $videos[] = $path;
            }
            $complemento->videos = json_encode($videos);
        }
    
        // Salva as atualizações no banco de dados
        $complemento->save();
        
        return redirect()->route('profile.manager.point')->with('success', 'Configurações atualizadas com sucesso!');
    }    

    public function updateDaysHours(Request $request, $id)
    {
        $complemento = Complemento::findOrFail($id);
        $complemento->days_hours = $request->input('days_hours');
        $complemento->save();

        return redirect()->back()->with('success', 'Dias e horas atualizados com sucesso!');
    }

    // Remove um complemento específico.
    public function destroy($id)
    {
        $complemento = Complemento::findOrFail($id);
        $complemento->delete();

        return response()->json(null, 204);
    }

    // Função para fazer o upload de arquivos.
    private function uploadFiles($files, $directory)
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $file->store($directory, 'public');
        }
        return $paths;
    }

    // Adiciona imagens a um complemento específico.
    public function addImages(Request $request, $id)
    {
        $validatedData = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $complemento = Complemento::findOrFail($id);

        if ($request->hasFile('images')) {
            $existingImages = $complemento->images ? json_decode($complemento->images, true) : [];
            $newImages = $this->uploadFiles($request->file('images'), 'images');
            $complemento->images = json_encode(array_merge($existingImages, $newImages));
        }

        $complemento->save();

        return response()->json($complemento);
    }

    // Adiciona vídeos a um complemento específico.
    public function addVideos(Request $request, $id)
    {
        $validatedData = $request->validate([
            'videos.*' => 'file|mimes:mp4,mov,avi|max:102400',
        ]);

        $complemento = Complemento::findOrFail($id);

        if ($request->hasFile('videos')) {
            $existingVideos = $complemento->videos ? json_decode($complemento->videos, true) : [];
            $newVideos = $this->uploadFiles($request->file('videos'), 'videos');
            $complemento->videos = json_encode(array_merge($existingVideos, $newVideos));
        }
        $complemento->save();

        return response()->json($complemento);
    }
}

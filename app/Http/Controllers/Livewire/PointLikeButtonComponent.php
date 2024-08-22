<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;
use App\Models\Point;

class PointLikeButtonComponent extends Component
{
    public $pointId;
    public $likesCount;

    protected $listeners = ['renderLikeButton' => 'renderLikeButton'];

    public function mount($pointId)
    {
        $this->pointId = $pointId;
        $this->likesCount = Point::find($pointId)->likes_count;
    }

    public function renderLikeButton($pointId)
    {
        if ($this->pointId == $pointId) {
            $this->render();
        }
    }

    public function incrementLike()
    {
        $point = Point::find($this->pointId);
        $point->likes_count++;
        $point->save();

        $this->likesCount = $point->likes_count;

        // Atualizar destaques
        $this->updateHighlightedPoints();

        $this->emit('likeButtonClicked', $this->pointId);
    }

    private function updateHighlightedPoints()
    {
        // Remove o destaque de todos os pontos
        Point::where('is_highlighted', 1)->update(['is_highlighted' => 0]);

        // Seleciona os 3 pontos com maior quantidade de likes
        $highlightedPoints = Point::orderByDesc('likes_count')->take(3)->get();

        // Define os 3 pontos como destacados
        foreach ($highlightedPoints as $highlightedPoint) {
            $highlightedPoint->update(['is_highlighted' => 1]);
        }
    }

    public function render()
    {
        return view('livewire.point-like-button-component');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Point;

class LikeButton extends Component
{
    public $pointId;
    public $likesCount;
    public $liked;

    public function load($pointId)
    {
        $point = Point::find($pointId);
        if ($point) {
            $this->pointId = $pointId;
            $this->likesCount = $point->likes_count;
            $this->liked = session()->has("liked_{$pointId}");
        }
    }

    public function like()
    {
        if (!$this->liked) {
            $this->likesCount++;
            Point::where('id', $this->pointId)->increment('likes_count');
            $this->liked = true;
            session()->put("liked_{$this->pointId}", true);
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}

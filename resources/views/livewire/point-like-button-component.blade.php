<button class="btn btn-primary like-btn" data-id="${point.id}" data-likes="${point.likes_count}" ${sessionStorage.getItem(`liked_${point.id}`) ? 'disabled' : ''} style="background-color: purple;">
    Curtir <span class="like-count">${point.likes_count}</span>
</button>

document.addEventListener('DOMContentLoaded', function () {
    const pointsList = document.getElementById('points-list');

    if (pointsList) {
        const points = pointsList.getElementsByClassName('point-item');
        const itemsToShow = 3;

        function showPoints(startIndex = 0) {
            for (let i = 0; i < points.length; i++) {
                points[i].style.display = (i >= startIndex && i < startIndex + itemsToShow) ? 'block' : 'none';
            }
        }

        // Initialize points view
        showPoints();
    }
});

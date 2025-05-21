document.addEventListener('DOMContentLoaded',function(){
    if(typeof google === 'undefined' || typeof window.CLMP_LOCATIONS === 'undefined') return;
    var center = {lat: 23.6850, lng: 90.3563};
    var locations = window.CLMP_LOCATIONS;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: center
    });
    var modal = document.getElementById('custom-modal');
    var modalContent = document.getElementById('modal-content');
    var closeModal = document.getElementById('close-modal');
    closeModal.onclick = function() {
        modal.style.display = 'none';
    };
    map.addListener('click', function() {
        modal.style.display = 'none';
    });
    modal.onclick = function(event) {
        event.stopPropagation();
    };
    locations.forEach(function(loc) {
        if(!loc.lat || !loc.lng) return;
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(loc.lat), lng: parseFloat(loc.lng)},
            map: map,
            title: loc.name
        });
        var infoContent = `
      <strong>${loc.name}</strong>
      ${loc.image ? `<img src="${loc.image}" alt="${loc.name}">` : ''}
      <div style="margin-bottom:8px;">${loc.address}</div>
      ${loc.gmaps ? `<a href="${loc.gmaps}" target="_blank" style="color:#4285F4;text-decoration:none;font-weight:bold;display:inline-block;">Directions &#8599;</a><br>` : ''}
      ${loc.website ? `<a href="${loc.website}" target="_blank" style="color:#34a853;text-decoration:none;font-size: 14px;">${loc.website}</a>` : ''}
    `;
        marker.addListener('click', function(e) {
            modal.style.display = 'block';
            modalContent.innerHTML = infoContent;
            if(e) e.stop = true;
        });
    });
});
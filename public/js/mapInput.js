function initialize() {

    const locationInputs = document.getElementsByClassName("map-input");


    const input = locationInputs[0];
    const isEdit = document.getElementById('address-latitude').value != '' && document.getElementById('address-longitude').value != '';

    const lat = parseFloat(document.getElementById('address-latitude').value);
    const lon = parseFloat(document.getElementById('address-longitude').value);

    const latt = $('#address-latitude');
    const longg = $('#address-longitude');


    const latitude = parseFloat(document.getElementById('address-latitude').value) || 1.5631314567645018;
    const longitude = parseFloat(document.getElementById('address-longitude').value) || 110.31978340501898;
    

    const map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: latitude, lng: longitude},
        zoom: 13
    });
    const marker = new google.maps.Marker({
        map: map,
        draggable:true,
        animation: google.maps.Animation.DROP,
        position: {lat: latitude, lng: longitude},
    });

    $('#address-latitude').on('keyup change', function(){
         
        const lati = this.value;
        
        navigator.geolocation.getCurrentPosition(function(position) {
            const lon = parseFloat(document.getElementById('address-longitude').value) || position.coords.longitude;
        // Center on user's current location if geolocation prompt allowed
            var initialLocation = new google.maps.LatLng(lati, lon);
            map.setCenter(initialLocation);
            map.setZoom(13);
            marker.setPosition(initialLocation);
            // lat.value =  position.coords.latitude;
            // lon.value =  position.coords.longitude;
            marker.setVisible(true);
        
      }, function(positionError) {
        map.setCenter(new google.maps.LatLng(latitude, longitude));
        map.setZoom(5);
        marker.setVisible(true);
      });
        
    });

    $('#address-longitude').on('keyup change', function(){
        
        const longi = this.value;
        navigator.geolocation.getCurrentPosition(function(position) {
        // Center on user's current location if geolocation prompt allowed
            const lat = parseFloat(document.getElementById('address-latitude').value) || position.coords.latitude;
            var initialLocation = new google.maps.LatLng(lat, longi);
            map.setCenter(initialLocation);
            map.setZoom(13);
            marker.setPosition(initialLocation);
            // lat.value =  position.coords.latitude;
            // lon.value =  position.coords.longitude;
            marker.setVisible(true);
        
      }, function(positionError) {
        map.setCenter(new google.maps.LatLng(latitude, longitude));
        map.setZoom(5);
        marker.setVisible(true);
      });
    });

    google.maps.event.addListener(map, "click", (position) => {

        navigator.geolocation.getCurrentPosition(function(position) {
        // Center on user's current location if geolocation prompt allowed
        
        if(latt.val() == '' && longg.val() == ''){
            var initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(initialLocation);
            map.setZoom(13);
            marker.setPosition(initialLocation);
            document.getElementById('address-latitude').value =  position.coords.latitude;
            document.getElementById('address-longitude').value =  position.coords.longitude;
            marker.setVisible(true);
        }
        
      }, function(positionError) {
        map.setCenter(new google.maps.LatLng(latitude, longitude));
        map.setZoom(5);
        marker.setVisible(true);
      });
        
    });

    
    google.maps.event.addListener(marker, 'dragend', function (evt) {
        document.getElementById('address-latitude').value =  evt.latLng.lat();
        document.getElementById('address-longitude').value =  evt.latLng.lng();
    });

    // $('#address-input').on('keyup', function(){
    //     const add_input = this.value;
    //     const latt = $('#address-latitude');
    //     const longg = $('#address-longitude');
    //     $.ajax({
    //         url: '/api/developer/geo_code',
    //         data: {
    //           q: add_input
    //         },
    //         success: function (data) {
    //             // alert(data[0].latitude);
    //             navigator.geolocation.getCurrentPosition(function() {
    //         // Center on user's current location if geolocation prompt allowed
    //             var initialLocation = new google.maps.LatLng(data[0].lat, data[0].lon);
    //             map.setCenter(initialLocation);
    //             map.setZoom(13);
    //             marker.setPosition(initialLocation);
    //             document.getElementById('address-latitude').value =  data[0].lat;
    //             document.getElementById('address-longitude').value = data[0].lon;
    //             marker.setVisible(true);
            
    //           }, function(positionError) {
    //             map.setCenter(new google.maps.LatLng(latitude, longitude));
    //             map.setZoom(5);
    //             marker.setVisible(true);
    //           });
    //         }
    //       })
    //     // .done(function(data) {
    //     //     // alert(data.data[0]);
    //     //     latt.value =  data.data[0];
            
    //     //     console.log(JSON.parse(data));
    //       });
    // // });

    marker.setVisible(isEdit);
    

}

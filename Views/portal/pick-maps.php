<div class="modal-body">
    <!-- <div class="form-horizontal" style="width: 550px"> -->
    <h6 id="title_map" class="title_map" style="display:none;">Loaded Map</h6>
    <div id="map_inits" style="width: 100%; height: 400px;"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group _lat-block">
                <label for="_lat" class="form-control-label">Latitude</label>
                <input type="text" class="form-control" id="_lat" name="_lat" placeholder="Latitude . . ." onFocus="inputFocus(this);" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group _long-block">
                <label for="_long" class="form-control-label">Longitude</label>
                <input type="text" class="form-control" id="_long" name="_long" placeholder="Longitude . . ." onFocus="inputFocus(this);" readonly>
            </div>
        </div>
    </div>
    <script>
        // var map = L.map("map_inits").setView([-4.97661, 105.21306], 12);
        // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        //     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://kntechline.id">Kntechline.id</a>'
        // }).addTo(map);

        // var lat = -4.97661;
        // var lon = 105.21306;
        // var marker;

        // marker = L.marker({
        //     lat: -4.97661,
        //     lng: 105.21306
        // }, {
        //     draggable: true
        // }).addTo(map);
        // document.getElementById('_lat').value = lat;
        // document.getElementById('_long').value = lon;

        // var onDrag = function(e) {
        //     var latlng = marker.getLatLng();
        //     document.getElementById('_lat').value = latlng.lat;
        //     document.getElementById('_long').value = latlng.lng;
        // };

        // // var onClick = function(e) {
        // //     map.off('click', onClick); //turn off listener for map click
        // //     marker = L.marker(e.latlng, {
        // //         draggable: true
        // //     }).addTo(map);
        // //     lat = e.latlng.lat;
        // //     lon = e.latlng.lng;
        // //     document.getElementById('outlat').innerHTML = e.latlng.lat;
        // //     document.getElementById('outlon').innerHTML = e.latlng.lng;

        // //     marker.on('drag', onDrag);
        // // };
        // marker.on('drag', onDrag);
        // // map.on('click', onClick);

        // setTimeout(function() {
        //     map.invalidateSize();
        // }, 3);



        // $('#us3').locationpicker({
        //     location: {
        //         latitude: 46.15242437752303,
        //         longitude: 2.7470703125
        //     },
        //     radius: 300,
        //     inputBinding: {
        //         latitudeInput: $('#us3-lat'),
        //         longitudeInput: $('#us3-lon'),
        //         radiusInput: $('#us3-radius'),
        //         locationNameInput: $('#us3-address')
        //     },
        //     enableAutocomplete: true,
        //     markerIcon: 'http://www.iconsdb.com/icons/preview/tropical-blue/map-marker-2-xl.png'
        // });
        // $('#us6-dialog').on('shown.bs.modal', function() {
        //     $('#us3').locationpicker('autosize');
        // });
    </script>
    <!-- </div> -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" onclick="takedKoordinat()" class="btn btn-primary">Simpan Koordinat</button>
</div>
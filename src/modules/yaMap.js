const yaMap = () => {
  'use strict';
  //Карта
  if (document.getElementById('map')) {
    ymaps.ready(function() {
      var myMap = new ymaps.Map("map", {
          center: [55.776142, 37.648167],
          zoom: 17
        }, {
          searchControlProvider: 'yandex#search'
        }),
        // Создаем геообъект с типом геометрии "Точка".
        myGeoObject = new ymaps.GeoObject({
          // Описание геометрии.
          geometry: {
            type: "Point",
            coordinates: [55.776142, 37.648167]
          }
        });
      myMap.geoObjects.add(myGeoObject);
    });
  }
}

export default yaMap;

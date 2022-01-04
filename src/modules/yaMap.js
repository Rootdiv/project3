/* eslint-disable no-var */
const yaMap = () => {
  'use strict';
  //Карта
  if (document.getElementById('map')) {
    window.ymaps.ready(() => {
      var myMap = new window.ymaps.Map("map", {
          center: [55.776142, 37.648167],
          zoom: 17
        }, {
          searchControlProvider: 'yandex#search'
        }),
        // Создаем геообъект с типом геометрии "Точка".
        myGeoObject = new window.ymaps.GeoObject({
          // Описание геометрии.
          geometry: {
            type: "Point",
            coordinates: [55.776142, 37.648167]
          }
        });
      myMap.geoObjects.add(myGeoObject);
    });
  }
};

export default yaMap;

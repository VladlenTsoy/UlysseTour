import * as moment from 'moment';
import 'moment-timezone';

// Закрыть все открыть все
window.openAllProgram = () => {
    $('.block-content .collapse').collapse('toggle');
    $('.openall').fadeToggle(0);
    $('.closeall').fadeToggle(0);
};

// Открыть карту
window.initMap = () => {
    // Основная карта
    if ($('#map', document)) {
        let myLatLng = {lat: 41.289057, lng: 69.275128};
        let map = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: myLatLng});
        new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Ulysse Tour!'
        });
    }

    // Карта одного маркера
    if ($('#map-marker', document).length) {
        let myLatLng = locations;
        let map = new google.maps.Map(document.getElementById('map-marker'), {
            zoom: 10,
            center: myLatLng
        });
        new google.maps.Marker({
            position: myLatLng,
            map: map,
        });
    }

    // Карта машрута
    if ($('#map-route', document).length) {
        let directionsDisplay = new google.maps.DirectionsRenderer();
        let directionsService = new google.maps.DirectionsService();
        let map = new google.maps.Map(document.getElementById('map-route'), {
            zoom: 10,
            center: new google.maps.LatLng(41.31159, 69.27927),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        directionsDisplay.setMap(map);

        let infowindow = new google.maps.InfoWindow();

        let marker, i;
        let request = {travelMode: google.maps.TravelMode.DRIVING};

        // locations = locations.splice(0,3);

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));

            if (i === 0) request.origin = marker.getPosition();
            else if (i === locations.length - 1) request.destination = marker.getPosition();
            else {
                if (!request.waypoints)
                    request.waypoints = [];
                else
                    request.waypoints.push({location: marker.getPosition(), stopover: true});
            }
        }
        directionsService.route(request, function (result, status) {
            if (status === google.maps.DirectionsStatus.OK)
                directionsDisplay.setDirections(result);
        });
    }
};

function sendDate(type) {
    $('.wrap-rasp').fadeIn();

    let from = $('#from_schedule').find(':selected').val(),
        to = $('#to_schedule').find(':selected').val(),
        transport_types = $('#transport_types').find(':selected').val(),
        date = $('#date').val(),
        dateTo = $('#dateTo').val(),

        link = "https://api.rasp.yandex.net/v3.0/search/?" +
            "from=" + from +
            "&to=" + to +
            "&format=json" +
            "&lang=ru_RU" +
            "&transport_types=" + type +
            "&apikey=e81f1678-6f51-4792-8136-6a0055a666bf" +
            "&date=" + date,
        linkIn = "https://api.rasp.yandex.net/v3.0/search/?" +
            "from=" + to +
            "&to=" + from +
            "&format=json" +
            "&lang=ru_RU" +
            "&transport_types=" + type +
            "&apikey=e81f1678-6f51-4792-8136-6a0055a666bf" +
            "&date=" + dateTo;

    $('#outputSchedule' + type).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>');

    $.ajax({
        url: '/schedule',
        method: 'post',
        data: {link: link},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')
        },
        success: function (response) {
            render(response, type);

            if (dateTo) {
                $('.wrap-obr-' + type).fadeIn();
                $('#inputSchedule' + type).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>');

                $.ajax({
                    url: '/schedule',
                    method: 'post',
                    data: {link: linkIn},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')
                    },
                    success: function (response) {
                        renderFrom(response, type);
                    },
                    error: function () {
                        $('#inputSchedule' + type).html('<p>' + langSchedule.error + '!</p>');
                    }
                });
            } else
                $('.wrap-obr-' + type).fadeOut();
        },
        error: function () {
            $('#outputSchedule' + type).html('<p>' + langSchedule.error + '!</p>');
        }
    });
}

function ci(n) {
    return n < 9 ? '0' + n : n;
}

function updateRaspApi() {
    sendDate('plane');
    sendDate('train');
}

function render(response, type) {
    let dateArrival, dateDeparture, arrival, departure;

    if (!response.segments.length)
        $('#outputSchedule' + type).html('<p>' + langSchedule.empty + '</p>');
    else {
        $('#outputSchedule' + type).html('<table class="table-ras table table-bordered table-sm table-responsive-sm">' +
            '<th>' + langSchedule.company + '</th>' +
            '<th>' + langSchedule.room + '</th>' +
            '<th>' + langSchedule.route + '</th>' +
            '<th>' + langSchedule.departure + '</th>' +
            '<th>' + langSchedule.arrival + '</th>' +
            '</table>');

        for (let i in response.segments) {
            let tempTran = response.segments[i];
            if (tempTran.arrival.length >= 20) {
                dateArrival = new Date(tempTran.arrival);
                dateDeparture = new Date(tempTran.departure);
                arrival = ci(dateArrival.getDate()) + '-' + ci(dateArrival.getMonth() + 1) + '-' + dateArrival.getFullYear() + ' ' + ci(dateArrival.getHours()) + ':' + ci(dateArrival.getMinutes());
                departure = ci(dateDeparture.getDate()) + '-' + ci(dateDeparture.getMonth() + 1) + '-' + dateDeparture.getFullYear() + ' ' + ci(dateDeparture.getHours()) + ':' + ci(dateDeparture.getMinutes());
            } else {
                arrival = tempTran.arrival.substring(0, 5);
                departure = tempTran.departure.substring(0, 5);
            }

            $('#outputSchedule' + type + ' .table-ras').append('<tr>' +
                '<td><img src="' + tempTran.thread.carrier.logo_svg + '" alt="" width="20px"> ' +
                '<a href="' + tempTran.thread.carrier.url + '" target="_blank">' + tempTran.thread.carrier.title + '</a></td>' +
                '<td>' + tempTran.thread.number + '</td>' +
                '<td>' + tempTran.thread.short_title + '</td>' +
                '<td><span class="mainColor">' + arrival + '</span> ' + tempTran.from.title + ' ' + tempTran.from.station_type_name + '</td>' +
                '<td><span class="mainColor">' + departure + '</span> ' + tempTran.to.title + ' ' + tempTran.to.station_type_name + '</td>' +
                '</tr>');
        }
    }

}

function renderFrom(response, type) {
    let dateArrival, dateDeparture, arrival, departure;
    if (!response.segments.length)
        $('#inputSchedule' + type).html('<p>' + langSchedule.empty + '</p>');
    else {
        $('#inputSchedule' + type).html('<table class="table-ras table table-bordered">' +
            '<th>' + langSchedule.company + '</th>' +
            '<th>' + langSchedule.room + '</th>' +
            '<th>' + langSchedule.route + '</th>' +
            '<th>' + langSchedule.departure + '</th>' +
            '<th>' + langSchedule.arrival + '</th>' +
            '</table>');

        for (let i in response.segments) {
            let tempTran = response.segments[i];
            if (tempTran.arrival.length >= 20) {
                dateArrival = new Date(tempTran.arrival);
                dateDeparture = new Date(tempTran.departure);
                arrival = ci(dateArrival.getDate()) + '-' + ci(dateArrival.getMonth() + 1) + '-' + dateArrival.getFullYear() + ' ' + ci(dateArrival.getHours()) + ':' + ci(dateArrival.getMinutes());
                departure = ci(dateDeparture.getDate()) + '-' + ci(dateDeparture.getMonth() + 1) + '-' + dateDeparture.getFullYear() + ' ' + ci(dateDeparture.getHours()) + ':' + ci(dateDeparture.getMinutes());
            } else {
                arrival = tempTran.arrival;
                departure = tempTran.departure;
            }

            $('#inputSchedule' + type + ' .table-ras').append('<tr>' +
                '<td><img src="' + tempTran.thread.carrier.logo_svg + '" alt="" width="20px"> ' +
                '<a href="' + tempTran.thread.carrier.url + '" target="_blank">' + tempTran.thread.carrier.title + '</a></td>' +
                '<td>' + tempTran.thread.number + '</td>' +
                '<td>' + tempTran.thread.short_title + '</td>' +
                '<td><span class="mainColor">' + arrival + '</span> ' + tempTran.from.title + ' ' + tempTran.from.station_type_name + '</td>' +
                '<td><span class="mainColor">' + departure + '</span> ' + tempTran.to.title + ' ' + tempTran.to.station_type_name + '</td>' +
                '</tr>');
        }
    }
}

// Погода
function weather(id) {
    let weather = $.ajax({
        type: 'POST',
        async: false,
        url: 'http://api.openweathermap.org/data/2.5/weather?id=' + id + '&APPID=2326bb344551950d645e91890bd120ed',
        dataType: 'json',
        success: function (data) {

        }
    });

    let temp = weather.responseJSON.main.temp;
    return Math.floor(temp - 273.15);
}

// Отправка формы
function sendForm(objForm) {
    let inpAllObj = {};
    $('input, textarea, select', objForm).each(function () {
        if (!$(this).attr('disabled')) {
            this.checkbox = this.type === 'checkbox' ? this.checked : true;
            this.radio = this.type === 'radio' ? this.checked : true;
            if (this.name && this.name !== '' && this.checkbox && this.radio) {
                if (typeof inpAllObj[this.name] === 'undefined') {
                    inpAllObj[this.name] = $(this).val();
                } else {
                    if (typeof inpAllObj[this.name] !== "object") {
                        let tmp = inpAllObj[this.name];
                        inpAllObj[this.name] = [];
                        inpAllObj[this.name].push(tmp);
                    }
                    inpAllObj[this.name].push($(this).val());
                }
            }
        }
    });
    return inpAllObj;
}

// Доллар
async function cursDollar() {
    let currency = await $.ajax({
        type: 'POST',
        async: false,
        url: 'https://openexchangerates.org/api/latest.json?app_id=cc43b63517454bdd9907000524e0c373',
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                $('#cartCntItems').html(data['cntItems']);

            }
        }
    });

    let UZS = currency.rates.UZS;
    let EUR = currency.rates.EUR;
    let EUR_DOL = UZS / EUR;
    $('.dollar_usz').html(UZS);
    $('.dollar_eur').html(EUR_DOL);
}

$(document).ready(function () {
    $('.hot-offers').owlCarousel({
        loop: false,
        responsiveClass: true,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1,
                margin: 10,
            },
            600: {
                items: 2,
                margin: 50,
            },
            1000: {
                items: 3,
                margin: 50,
            }
        }
    });
    $('.block-tours').owlCarousel({
        loop: false,
        responsiveClass: true,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1,
                margin: 10,
            },
            600: {
                items: 1,
                margin: 50,
            },
            1000: {
                items: 1,
                margin: 100,
            },
            1100: {
                items: 2,
                margin: 100,
            }
        }
    });
    $('.block-pluses').owlCarousel({
        loop: false,
        responsiveClass: true,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1,
                margin: 10,
            },
            600: {
                items: 2,
                margin: 20,
            },
            1000: {
                items: 3,
                margin: 30,
            }
        }
    });
    $('.block-news').owlCarousel({
        loop: false,
        responsiveClass: true,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1,
                margin: 10,
            },
            600: {
                items: 2,
                margin: 15,
            },
            1000: {
                items: 3,
                margin: 15,
            }
        }
    });

    let tashkent = weather('1512569'),
        samarkand = weather('1216265'),
        bukhara = weather('1217662'),
        hiva = weather('1513604');

    $('.wethTas').append(tashkent + ' °C');
    $('.wethSam').append(samarkand + ' °C');
    $('.wethBukh').append(bukhara + ' °C');
    $('.wethKhiw').append(hiva + ' °C');

    cursDollar();

    $(".main-nav .nav-link").click(function (e) {
        $('.nav-item').removeClass('active');
        $(this).parents('.nav-item').addClass('active');
        let selectBlock = $(this).attr('href').split('#');
        if (selectBlock[1] && selectBlock[1] !== '')
            $('html, body').animate({
                scrollTop: $('#' + selectBlock[1]).offset().top - 100
            }, 550);
    });


    let dateOp = new Date();
    let tash = moment.tz("Asia/Tashkent");
    let current = parseInt(dateOp.getHours()) - parseInt(tash.format('H'));

    $('.timeFrom').text('0' + (9 + current) + ':00');
    $('.timeTo').text((18 + current) + ':00');

    $('#carouselExampleControls').on('slid.bs.carousel', function () {
        let image = $('.carousel-hm.active').attr('image');
        $('.wrap-top-slide').css({'background': 'url("' + image + '") center no-repeat', 'background-size': 'cover'})
    });

    $(document).on('click', '#checkDateTo', function (e) {
        if ($(e.currentTarget).is(':checked'))
            $('#dateTo').removeAttr('disabled');
        else
            $('#dateTo').attr('disabled', 'disabled');
    });

    $(document).on('click', '#send', updateRaspApi);


    if ($('.selectMultiple'))
        if ($('.selectMultiple').select2)
            $('.selectMultiple').select2({width: '100%'});


    $(document).on('submit', '#createTour', function (e) {
        e.preventDefault();
        let data = sendForm($(e.currentTarget));
        console.log(data);

        $.ajax({
            method: "POST",
            url: "/book_it/send_mail_message/create_tour",
            data: data,
        });

        $('.alert-message').fadeIn();
        $("#createTour")[0].reset();

        return false;
    });


});

$(document).ready(() => $('.loader', document).fadeOut(500));


// $(document).ready(function () {
//     function a(s) {
//         $('.wrap-rasp').fadeIn();
//         let t = $('#from_schedule').find(':selected').val(), u = $('#to_schedule').find(':selected').val(),
//             v = $('#transport_types').find(':selected').val(), w = $('#date').val(), x = $('#dateTo').val();
//         $('#outputSchedule' + s).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>'), $.ajax({
//             url: '/schedule',
//             method: 'post',
//             data: {link: 'https://api.rasp.yandex.net/v3.0/search/?from=' + t + '&to=' + u + '&format=json&lang=ru_RU&transport_types=' + s + '&apikey=e81f1678-6f51-4792-8136-6a0055a666bf&date=' + w},
//             dataType: 'json',
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')},
//             success: function (A) {
//                 d(A, s), x ? ($('.wrap-obr-' + s).fadeIn(), $('#inputSchedule' + s).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>'), $.ajax({
//                     url: '/schedule',
//                     method: 'post',
//                     data: {link: 'https://api.rasp.yandex.net/v3.0/search/?from=' + u + '&to=' + t + '&format=json&lang=ru_RU&transport_types=' + s + '&apikey=e81f1678-6f51-4792-8136-6a0055a666bf&date=' + x},
//                     dataType: 'json',
//                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')},
//                     success: function (B) {
//                         f(B, s)
//                     },
//                     error: function () {
//                         $('#inputSchedule' + s).html('<p>' + langSchedule.error + '!</p>')
//                     }
//                 })) : $('.wrap-obr-' + s).fadeOut()
//             },
//             error: function () {
//                 $('#outputSchedule' + s).html('<p>' + langSchedule.error + '!</p>')
//             }
//         })
//     }
//
//     function b(s) {
//         return 9 > s ? '0' + s : s
//     }
//
//     function d(s, t) {
//         if (!s.segments.length) $('#outputSchedule' + t).html('<p>' + langSchedule.empty + '</p>'); else for (let u in $('#outputSchedule' + t).html('<table class="table-ras table table-bordered table-sm table-responsive-sm"><th>' + langSchedule.company + '</th><th>' + langSchedule.room + '</th><th>' + langSchedule.route + '</th><th>' + langSchedule.departure + '</th><th>' + langSchedule.arrival + '</th></table>'), s.segments) {
//             let v = s.segments[u];
//             if (20 <= v.arrival.length) let w = new Date(v.arrival), x = new Date(v.departure),
//                 y = b(w.getDate()) + '-' + b(w.getMonth() + 1) + '-' + w.getFullYear() + ' ' + b(w.getHours()) + ':' + b(w.getMinutes()),
//                 z = b(x.getDate()) + '-' + b(x.getMonth() + 1) + '-' + x.getFullYear() + ' ' + b(x.getHours()) + ':' + b(x.getMinutes()); else let y = v.arrival.substring(0, 5),
//                 z = v.departure.substring(0, 5);
//             $('#outputSchedule' + t + ' .table-ras').append('<tr><td><img src="' + v.thread.carrier.logo_svg + '" alt="" width="20px"> <a href="' + v.thread.carrier.url + '" target="_blank">' + v.thread.carrier.title + '</a></td><td>' + v.thread.number + '</td><td>' + v.thread.short_title + '</td><td><span class="mainColor">' + y + '</span> ' + v.from.title + ' ' + v.from.station_type_name + '</td><td><span class="mainColor">' + z + '</span> ' + v.to.title + ' ' + v.to.station_type_name + '</td></tr>')
//         }
//     }
//
//     function f(s, t) {
//         if (!s.segments.length) $('#inputSchedule' + t).html('<p>' + langSchedule.empty + '</p>'); else for (let u in $('#inputSchedule' + t).html('<table class="table-ras table table-bordered"><th>' + langSchedule.company + '</th><th>' + langSchedule.room + '</th><th>' + langSchedule.route + '</th><th>' + langSchedule.departure + '</th><th>' + langSchedule.arrival + '</th></table>'), s.segments) {
//             let v = s.segments[u];
//             if (20 <= v.arrival.length) let w = new Date(v.arrival), x = new Date(v.departure),
//                 y = b(w.getDate()) + '-' + b(w.getMonth() + 1) + '-' + w.getFullYear() + ' ' + b(w.getHours()) + ':' + b(w.getMinutes()),
//                 z = b(x.getDate()) + '-' + b(x.getMonth() + 1) + '-' + x.getFullYear() + ' ' + b(x.getHours()) + ':' + b(x.getMinutes()); else let y = v.arrival,
//                 z = v.departure;
//             $('#inputSchedule' + t + ' .table-ras').append('<tr><td><img src="' + v.thread.carrier.logo_svg + '" alt="" width="20px"> <a href="' + v.thread.carrier.url + '" target="_blank">' + v.thread.carrier.title + '</a></td><td>' + v.thread.number + '</td><td>' + v.thread.short_title + '</td><td><span class="mainColor">' + y + '</span> ' + v.from.title + ' ' + v.from.station_type_name + '</td><td><span class="mainColor">' + z + '</span> ' + v.to.title + ' ' + v.to.station_type_name + '</td></tr>')
//         }
//     }
//
//     $('.hot-offers').owlCarousel({
//         loop: !1,
//         responsiveClass: !0,
//         nav: !1,
//         dots: !1,
//         responsive: {0: {items: 1, margin: 10}, 600: {items: 2, margin: 50}, 1e3: {items: 3, margin: 50}}
//     }), $('.block-tours').owlCarousel({
//         loop: !1,
//         responsiveClass: !0,
//         nav: !1,
//         dots: !1,
//         responsive: {
//             0: {items: 1, margin: 10},
//             600: {items: 1, margin: 50},
//             1e3: {items: 1, margin: 100},
//             1100: {items: 2, margin: 100}
//         }
//     }), $('.block-pluses').owlCarousel({
//         loop: !1,
//         responsiveClass: !0,
//         nav: !1,
//         dots: !1,
//         responsive: {0: {items: 1, margin: 10}, 600: {items: 2, margin: 20}, 1e3: {items: 3, margin: 30}}
//     }), $('.block-news').owlCarousel({
//         loop: !1,
//         responsiveClass: !0,
//         nav: !0,
//         dots: !1,
//         responsive: {0: {items: 1, margin: 10}, 600: {items: 2, margin: 15}, 1e3: {items: 3, margin: 15}}
//     }), $('.main-nav .nav-link').click(function () {
//         $('.nav-item').removeClass('active'), $(this).parents('.nav-item').addClass('active');
//         let t = $(this).attr('href');
//         '#' !== t && $('html, body').animate({scrollTop: $(t).offset().top}, 550)
//     });
//     let g = $.ajax({
//         type: 'POST',
//         async: !1,
//         url: 'https://openexchangerates.org/api/latest.json?app_id=cc43b63517454bdd9907000524e0c373',
//         dataType: 'json',
//         success: function (s) {
//             s.success && $('#cartCntItems').html(s.cntItems)
//         }
//     }), h = weather('1512569'), j = weather('1216265'), k = weather('1217662'), l = weather('1513604');
//     $('.wethTas').append(h + ' \xB0C'), $('.wethSam').append(j + ' \xB0C'), $('.wethBukh').append(k + ' \xB0C'), $('.wethKhiw').append(l + ' \xB0C');
//     let m = g.responseJSON.rates.UZS, o = g.responseJSON.rates.EUR;
//     $('.dollar_usz').html(m), $('.dollar_eur').html(m / o);
//     let q = new Date, r = parseInt(q.getHours()) - parseInt(timeTashkent.getHours());
//     $('.timeFrom').text('0' + (9 + r) + ':00'), $('.timeTo').text(18 + r + ':00'), $(document).on('click', '#checkDateTo', function (s) {
//         $(s.currentTarget).is(':checked') ? $('#dateTo').removeAttr('disabled') : $('#dateTo').attr('disabled', 'disabled')
//     }), $(document).on('click', '#send', function () {
//         a('plane'), a('train')
//     }), $('.selectMultiple') && $('.selectMultiple').select2 && $('.selectMultiple').select2({width: '100%'})
// });
//
// function weather(a) {
//     let b = $.ajax({
//         type: 'POST',
//         async: !1,
//         url: 'http://api.openweathermap.org/data/2.5/weather?id=' + a + '&APPID=2326bb344551950d645e91890bd120ed',
//         dataType: 'json',
//         success: function () {
//         }
//     }), c = b.responseJSON.main.temp;
//     return c = Math.floor(c - 273.15), c
// }
//
// function openAllProgram() {
//     $('.collapse').collapse('toggle'), $('.openall').fadeToggle(0), $('.closeall').fadeToggle(0)
// }
//
// $(document).on('submit', '#book_it_form', function (a) {
//     a.preventDefault();
//     let b = sendForm($(a.currentTarget));
//     return $.ajax({
//         method: 'POST',
//         url: '/book_it/send_mail_message/tour',
//         data: b
//     }), $('.alert-message').fadeIn(), $('#book_it_form')[0].reset(), !1
// }), $(document).on('submit', '#createTour', function (a) {
//     a.preventDefault();
//     let b = sendForm($(a.currentTarget));
//     return console.log(b), $.ajax({
//         method: 'POST',
//         url: '/book_it/send_mail_message/create_tour',
//         data: b
//     }), $('.alert-message').fadeIn(), $('#createTour')[0].reset(), !1
// });
//
// function sendForm(a) {
//     let b = {};
//     return $('input, textarea, select', a).each(function () {
//         if (!$(this).attr('disabled') && (this.checkbox = 'checkbox' !== this.type || this.checked, this.radio = 'radio' !== this.type || this.checked, this.name && '' !== this.name && this.checkbox && this.radio)) if ('undefined' == typeof b[this.name]) b[this.name] = $(this).val(); else {
//             if ('object' != typeof b[this.name]) {
//                 let c = b[this.name];
//                 b[this.name] = [], b[this.name].push(c)
//             }
//             b[this.name].push($(this).val())
//         }
//     }), b
// }
//
// window.initMap = function initMap() {
//     if ($('#map')) let a = {lat: 41.289057, lng: 69.275128},
//         b = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: a}),
//         c = new google.maps.Marker({position: a, map: b, title: 'Ulysse Tour!'});
//     if ($('#map-marker').length) let a = locations,
//         b = new google.maps.Map(document.getElementById('map-marker'), {zoom: 12, center: a}),
//         c = new google.maps.Marker({position: a, map: b}); else if ($('#map-route').length) {
//         let b, f, g = new google.maps.DirectionsService;
//         f = new google.maps.DirectionsRenderer, b = new google.maps.Map(document.getElementById('map-route'), {
//             zoom: 10,
//             center: new google.maps.LatLng(41.31159, 69.27927),
//             mapTypeId: google.maps.MapTypeId.ROADMAP
//         }), f.setMap(b);
//         let c, j, h = new google.maps.InfoWindow, k = {travelMode: google.maps.TravelMode.DRIVING};
//         for (j = 0; j < locations.length; j++) c = new google.maps.Marker({position: new google.maps.LatLng(locations[j][1], locations[j][2])}), google.maps.event.addListener(c, 'click', function (l, m) {
//             return function () {
//                 h.setContent(locations[m][0]), h.open(b, l)
//             }
//         }(c, j)), 0 == j ? k.origin = c.getPosition() : j == locations.length - 1 ? k.destination = c.getPosition() : (!k.waypoints && (k.waypoints = []), k.waypoints.push({
//             location: c.getPosition(),
//             stopover: !0
//         }));
//         g.route(k, function (l, m) {
//             m == google.maps.DirectionsStatus.OK && f.setDirections(l)
//         })
//     }
// }
// $(document).ready(() => $('.loader', document).fadeOut(500));
//
// $(document).ready(function () {
//
//     $('.hot-offers').owlCarousel({
//         loop: false,
//         responsiveClass: true,
//         nav: false,
//         dots: false,
//         responsive: {
//             0: {
//                 items: 1,
//                 margin: 10,
//             },
//             600: {
//                 items: 2,
//                 margin: 50,
//             },
//             1000: {
//                 items: 3,
//                 margin: 50,
//             }
//         }
//     });
//
//     $('.block-tours').owlCarousel({
//         loop: false,
//         responsiveClass: true,
//         nav: false,
//         dots: false,
//         responsive: {
//             0: {
//                 items: 1,
//                 margin: 10,
//             },
//             600: {
//                 items: 1,
//                 margin: 50,
//             },
//             1000: {
//                 items: 1,
//                 margin: 100,
//             },
//             1100: {
//                 items: 2,
//                 margin: 100,
//             }
//         }
//     });
//
//     $('.block-pluses').owlCarousel({
//         loop: false,
//         responsiveClass: true,
//         nav: false,
//         dots: false,
//         responsive: {
//             0: {
//                 items: 1,
//                 margin: 10,
//             },
//             600: {
//                 items: 2,
//                 margin: 20,
//             },
//             1000: {
//                 items: 3,
//                 margin: 30,
//             }
//         }
//     });
//
//     $('.block-news').owlCarousel({
//         loop: false,
//         responsiveClass: true,
//         nav: true,
//         dots: false,
//         responsive: {
//             0: {
//                 items: 1,
//                 margin: 10,
//             },
//             600: {
//                 items: 2,
//                 margin: 15,
//             },
//             1000: {
//                 items: 3,
//                 margin: 15,
//             }
//         }
//     });
//
//     $(".main-nav .nav-link").click(function (e) {
//         $('.nav-item').removeClass('active')
//         $(this).parents('.nav-item').addClass('active');
//         let selectBlock = $(this).attr('href');
//         if (selectBlock !== '#')
//             $('html, body').animate({
//                 scrollTop: $(selectBlock).offset().top
//             }, 550);
//     });
//
//     let currency = $.ajax({
//         type: 'POST',
//         async: false,
//         url: 'https://openexchangerates.org/api/latest.json?app_id=cc43b63517454bdd9907000524e0c373',
//         dataType: 'json',
//         success: function (data) {
//             if (data['success']) {
//                 $('#cartCntItems').html(data['cntItems']);
//
//             }
//         }
//     });
//
//     let tashkent = weather('1512569'),
//         samarkand = weather('1216265'),
//         bukhara = weather('1217662'),
//         hiva = weather('1513604');
//
//     $('.wethTas').append(tashkent + ' °C');
//     $('.wethSam').append(samarkand + ' °C');
//     $('.wethBukh').append(bukhara + ' °C');
//     $('.wethKhiw').append(hiva + ' °C');
//
//
//     let UZS = currency.responseJSON.rates.UZS;
//     let EUR = currency.responseJSON.rates.EUR;
//     let EUR_DOL = UZS / EUR;
//     $('.dollar_usz').html(UZS);
//     $('.dollar_eur').html(EUR_DOL);
//
//     /**** * ****/
//
//     let dateOp = new Date();
//     let current = parseInt(dateOp.getHours()) - parseInt(timeTashkent.getHours());
//
//     $('.timeFrom').text('0' + (9 + current) + ':00');
//     $('.timeTo').text((18 + current) + ':00');
//     /**** * ****/
//
//
//     // $('#carouselExampleControls').on('slid.bs.carousel', function () {
//     //     // do something…
//     //     let image = $('.carousel-hm.active').attr('image');
//     //     $('.wrap-top-slide').css({'background': 'url("' + image + '") center no-repeat', 'background-size': 'cover'})
//     // });
//     /**** * ****/
//
//     $(document).on('click', '#checkDateTo', function (e) {
//         if ($(e.currentTarget).is(':checked'))
//             $('#dateTo').removeAttr('disabled');
//         else
//             $('#dateTo').attr('disabled', 'disabled');
//     });
//
//     function sendDate(type) {
//         $('.wrap-rasp').fadeIn();
//
//         let from = $('#from_schedule').find(':selected').val(),
//             to = $('#to_schedule').find(':selected').val(),
//             transport_types = $('#transport_types').find(':selected').val(),
//             date = $('#date').val(),
//             dateTo = $('#dateTo').val(),
//
//             link = "https://api.rasp.yandex.net/v3.0/search/?" +
//                 "from=" + from +
//                 "&to=" + to +
//                 "&format=json" +
//                 "&lang=ru_RU" +
//                 "&transport_types=" + type +
//                 "&apikey=e81f1678-6f51-4792-8136-6a0055a666bf" +
//                 "&date=" + date,
//             linkIn = "https://api.rasp.yandex.net/v3.0/search/?" +
//                 "from=" + to +
//                 "&to=" + from +
//                 "&format=json" +
//                 "&lang=ru_RU" +
//                 "&transport_types=" + type +
//                 "&apikey=e81f1678-6f51-4792-8136-6a0055a666bf" +
//                 "&date=" + dateTo;
//
//         $('#outputSchedule' + type).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>');
//
//         $.ajax({
//             url: '/schedule',
//             method: 'post',
//             data: {link: link},
//             dataType: 'json',
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')
//             },
//             success: function (response) {
//                 render(response, type);
//
//                 if (dateTo) {
//                     $('.wrap-obr-' + type).fadeIn();
//                     $('#inputSchedule' + type).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>');
//
//                     $.ajax({
//                         url: '/schedule',
//                         method: 'post',
//                         data: {link: linkIn},
//                         dataType: 'json',
//                         headers: {
//                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')
//                         },
//                         success: function (response) {
//                             renderFrom(response, type);
//                         },
//                         error: function () {
//                             $('#inputSchedule' + type).html('<p>' + langSchedule.error + '!</p>');
//                         }
//                     });
//                 } else
//                     $('.wrap-obr-' + type).fadeOut();
//             },
//             error: function () {
//                 $('#outputSchedule' + type).html('<p>' + langSchedule.error + '!</p>');
//             }
//         });
//     }
//
//
//     function ci(n) {
//         return n < 9 ? '0' + n : n;
//     }
//
//     function updateRaspApi() {
//         sendDate('plane');
//         sendDate('train');
//     }
//
//     $(document).on('click', '#send', updateRaspApi);
//
//     function render(response, type) {
//         if (!response.segments.length)
//             $('#outputSchedule' + type).html('<p>' + langSchedule.empty + '</p>');
//         else {
//             $('#outputSchedule' + type).html('<table class="table-ras table table-bordered table-sm table-responsive-sm">' +
//                 '<th>' + langSchedule.company + '</th>' +
//                 '<th>' + langSchedule.room + '</th>' +
//                 '<th>' + langSchedule.route + '</th>' +
//                 '<th>' + langSchedule.departure + '</th>' +
//                 '<th>' + langSchedule.arrival + '</th>' +
//                 '</table>');
//
//             for (let i in response.segments) {
//                 let tempTran = response.segments[i];
//                 if (tempTran.arrival.length >= 20) {
//                     let dateArrival = new Date(tempTran.arrival),
//                         dateDeparture = new Date(tempTran.departure),
//                         arrival = ci(dateArrival.getDate()) + '-' + ci(dateArrival.getMonth() + 1) + '-' + dateArrival.getFullYear() + ' ' + ci(dateArrival.getHours()) + ':' + ci(dateArrival.getMinutes()),
//                         departure = ci(dateDeparture.getDate()) + '-' + ci(dateDeparture.getMonth() + 1) + '-' + dateDeparture.getFullYear() + ' ' + ci(dateDeparture.getHours()) + ':' + ci(dateDeparture.getMinutes());
//                 } else {
//                     let arrival = tempTran.arrival.substring(0, 5),
//                         departure = tempTran.departure.substring(0, 5);
//                 }
//
//                 $('#outputSchedule' + type + ' .table-ras').append('<tr>' +
//                     '<td><img src="' + tempTran.thread.carrier.logo_svg + '" alt="" width="20px"> ' +
//                     '<a href="' + tempTran.thread.carrier.url + '" target="_blank">' + tempTran.thread.carrier.title + '</a></td>' +
//                     '<td>' + tempTran.thread.number + '</td>' +
//                     '<td>' + tempTran.thread.short_title + '</td>' +
//                     '<td><span class="mainColor">' + arrival + '</span> ' + tempTran.from.title + ' ' + tempTran.from.station_type_name + '</td>' +
//                     '<td><span class="mainColor">' + departure + '</span> ' + tempTran.to.title + ' ' + tempTran.to.station_type_name + '</td>' +
//                     '</tr>');
//             }
//         }
//
//     }
//
//     function renderFrom(response, type) {
//         if (!response.segments.length)
//             $('#inputSchedule' + type).html('<p>' + langSchedule.empty + '</p>');
//         else {
//             $('#inputSchedule' + type).html('<table class="table-ras table table-bordered">' +
//                 '<th>' + langSchedule.company + '</th>' +
//                 '<th>' + langSchedule.room + '</th>' +
//                 '<th>' + langSchedule.route + '</th>' +
//                 '<th>' + langSchedule.departure + '</th>' +
//                 '<th>' + langSchedule.arrival + '</th>' +
//                 '</table>');
//
//             for (let i in response.segments) {
//                 let tempTran = response.segments[i];
//                 if (tempTran.arrival.length >= 20) {
//                     let dateArrival = new Date(tempTran.arrival),
//                         dateDeparture = new Date(tempTran.departure),
//                         arrival = ci(dateArrival.getDate()) + '-' + ci(dateArrival.getMonth() + 1) + '-' + dateArrival.getFullYear() + ' ' + ci(dateArrival.getHours()) + ':' + ci(dateArrival.getMinutes()),
//                         departure = ci(dateDeparture.getDate()) + '-' + ci(dateDeparture.getMonth() + 1) + '-' + dateDeparture.getFullYear() + ' ' + ci(dateDeparture.getHours()) + ':' + ci(dateDeparture.getMinutes());
//                 }
//                 else {
//                     let arrival = tempTran.arrival,
//                         departure = tempTran.departure;
//                 }
//
//                 $('#inputSchedule' + type + ' .table-ras').append('<tr>' +
//                     '<td><img src="' + tempTran.thread.carrier.logo_svg + '" alt="" width="20px"> ' +
//                     '<a href="' + tempTran.thread.carrier.url + '" target="_blank">' + tempTran.thread.carrier.title + '</a></td>' +
//                     '<td>' + tempTran.thread.number + '</td>' +
//                     '<td>' + tempTran.thread.short_title + '</td>' +
//                     '<td><span class="mainColor">' + arrival + '</span> ' + tempTran.from.title + ' ' + tempTran.from.station_type_name + '</td>' +
//                     '<td><span class="mainColor">' + departure + '</span> ' + tempTran.to.title + ' ' + tempTran.to.station_type_name + '</td>' +
//                     '</tr>');
//             }
//         }
//     }
//
//     if ($('.selectMultiple'))
//         if ($('.selectMultiple').select2)
//             $('.selectMultiple').select2({width: '100%'});
// });
//
//
// function weather(id) {
//     let weather = $.ajax({
//         type: 'POST',
//         async: false,
//         url: 'http://api.openweathermap.org/data/2.5/weather?id=' + id + '&APPID=2326bb344551950d645e91890bd120ed',
//         dataType: 'json',
//         success: function (data) {
//
//         }
//     });
//
//     let temp = weather.responseJSON.main.temp;
//     temp = Math.floor(temp - 273.15);
//
//     return temp;
//
// }
//
// function initMap() {
//
//     if ($('#map')) {
//         let myLatLng = {lat: 41.289057, lng: 69.275128};
//
//         let map = new google.maps.Map(document.getElementById('map'), {
//             zoom: 12,
//             center: myLatLng
//         });
//
//         let marker = new google.maps.Marker({
//             position: myLatLng,
//             map: map,
//             title: 'Ulysse Tour!'
//         });
//     }
//
//     if ($('#map-marker').length) {
//         let myLatLng = locations;
//
//         let map = new google.maps.Map(document.getElementById('map-marker'), {
//             zoom: 12,
//             center: myLatLng
//         });
//
//         let marker = new google.maps.Marker({
//             position: myLatLng,
//             map: map,
//         });
//     } else if($('#map-route').length) {
//
//         // let map;
//         //
//         // let mapOptions = {
//         //     zoom: 8,
//         //     center: new google.maps.LatLng(56, 37)
//         // };
//         // map = new google.maps.Map(document.getElementById('map-route'), mapOptions);
//         //
//         // let directionsDisplay = new google.maps.DirectionsRenderer();
//         // let directionsService = new google.maps.DirectionsService();
//         // directionsDisplay.setMap(map);
//         // directionsDisplay.setOptions({suppressMarkers: true, suppressInfoWindows: true});
//         //
//         // let start_point = new google.maps.LatLng(56, 37);
//         // let end_point = new google.maps.LatLng(57, 39);
//         //
//         // let marker = new google.maps.Marker({
//         //     position: start_point,
//         //     map: map
//         // });
//         //
//         // let marker = new google.maps.Marker({
//         //     position: end_point,
//         //     map: map
//         // });
//         //
//         // google.maps.event.addListener(marker, 'click', function () {
//         //     infowindow.open(map, this);
//         // });
//         //
//         // let request = {
//         //     origin: start_point,
//         //     destination: end_point,
//         //     travelMode: google.maps.TravelMode.DRIVING,
//         //     unitSystem: google.maps.UnitSystem.METRIC,
//         //     provideRouteAlternatives: true,
//         //     avoidHighways: false,
//         //     avoidTolls: true
//         // };
//         // directionsService.route(request, function (result, status) {
//         //     if (status == google.maps.DirectionsStatus.OK) {
//         //         directionsDisplay.setDirections(result);
//         //         let routes = result.routes;
//         //         let leg = routes[0].legs;
//         //         let lenght = leg[0].distance.text;
//         //         let duration = leg[0].duration.text;
//         //         infowindow = new google.maps.InfoWindow({content: 'Дистанция: ' + lenght + '<br>Продолжительность: ' + duration});
//         //         infowindow.open(map, marker);
//         //     }
//         // });
//
//         // google.maps.event.addDomListener(window, 'load', initialize);
//         let geocoder;
//         let map;
//         let directionsDisplay;
//         let directionsService = new google.maps.DirectionsService();
//
//         directionsDisplay = new google.maps.DirectionsRenderer();
//
//         map = new google.maps.Map(document.getElementById('map-route'), {
//             zoom: 10,
//             center: new google.maps.LatLng(41.31159, 69.27927),
//             mapTypeId: google.maps.MapTypeId.ROADMAP
//         });
//         directionsDisplay.setMap(map);
//         let infowindow = new google.maps.InfoWindow();
//
//         let marker, i;
//         let request = {
//             travelMode: google.maps.TravelMode.DRIVING
//         };
//         for (i = 0; i < locations.length; i++) {
//             marker = new google.maps.Marker({
//                 position: new google.maps.LatLng(locations[i][1], locations[i][2]),
//             });
//
//             google.maps.event.addListener(marker, 'click', (function (marker, i) {
//                 return function () {
//                     infowindow.setContent(locations[i][0]);
//                     infowindow.open(map, marker);
//                 }
//             })(marker, i));
//
//             if (i == 0) request.origin = marker.getPosition();
//             else if (i == locations.length - 1) request.destination = marker.getPosition();
//             else {
//                 if (!request.waypoints) request.waypoints = [];
//                 request.waypoints.push({
//                     location: marker.getPosition(),
//                     stopover: true
//                 });
//             }
//         }
//         directionsService.route(request, function (result, status) {
//             if (status == google.maps.DirectionsStatus.OK) {
//                 directionsDisplay.setDirections(result);
//             }
//         });
//     }
// }
//
// function openAllProgram(status) {
//     $('.collapse').collapse('toggle');
//     $('.openall').fadeToggle(0);
//     $('.closeall').fadeToggle(0);
// }
//
// $(document).on('submit', '#book_it_form', function (e) {
//     e.preventDefault();
//     let data = sendForm($(e.currentTarget));
//
//     $.ajax({
//         method: "POST",
//         url: "/book_it/send_mail_message/tour",
//         data: data,
//     });
//
//     $('.alert-message').fadeIn();
//     $("#book_it_form")[0].reset();
//
//     return false;
// });
//
//
// $(document).on('submit', '#createTour', function (e) {
//     e.preventDefault();
//     let data = sendForm($(e.currentTarget));
//     console.log(data);
//
//     $.ajax({
//         method: "POST",
//         url: "/book_it/send_mail_message/create_tour",
//         data: data,
//     });
//
//     $('.alert-message').fadeIn();
//     $("#createTour")[0].reset();
//
//     return false;
// });
//
//
// function sendForm(objForm) {
//     let inpAllObj = {};
//     $('input, textarea, select', objForm).each(function () {
//         if (!$(this).attr('disabled')) {
//             this.checkbox = this.type === 'checkbox' ? this.checked : true;
//             this.radio = this.type === 'radio' ? this.checked : true;
//             if (this.name && this.name !== '' && this.checkbox && this.radio) {
//                 if (typeof inpAllObj[this.name] === 'undefined') {
//                     inpAllObj[this.name] = $(this).val();
//                 } else {
//                     if (typeof inpAllObj[this.name] !== "object") {
//                         let tmp = inpAllObj[this.name];
//                         inpAllObj[this.name] = [];
//                         inpAllObj[this.name].push(tmp);
//                     }
//                     inpAllObj[this.name].push($(this).val());
//                 }
//             }
//         }
//     });
//     return inpAllObj;
// }

// function book_it(e) {
//     alert(1);
//     e.preventDefault();
//     console.log($(e.currentTarget));
//     return false;
// }
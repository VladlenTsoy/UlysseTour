$(document).ready(function () {
    function a(s) {
        $('.wrap-rasp').fadeIn();
        var t = $('#from_schedule').find(':selected').val(), u = $('#to_schedule').find(':selected').val(),
            v = $('#transport_types').find(':selected').val(), w = $('#date').val(), x = $('#dateTo').val();
        $('#outputSchedule' + s).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>'), $.ajax({
            url: '/schedule',
            method: 'post',
            data: {link: 'https://api.rasp.yandex.net/v3.0/search/?from=' + t + '&to=' + u + '&format=json&lang=ru_RU&transport_types=' + s + '&apikey=e81f1678-6f51-4792-8136-6a0055a666bf&date=' + w},
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')},
            success: function (A) {
                d(A, s), x ? ($('.wrap-obr-' + s).fadeIn(), $('#inputSchedule' + s).html('<p><i class="fa fa-refresh fa-spin fa-5x"></i> <br> ' + langSchedule.load + '...</p>'), $.ajax({
                    url: '/schedule',
                    method: 'post',
                    data: {link: 'https://api.rasp.yandex.net/v3.0/search/?from=' + u + '&to=' + t + '&format=json&lang=ru_RU&transport_types=' + s + '&apikey=e81f1678-6f51-4792-8136-6a0055a666bf&date=' + x},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]', document).attr('content')},
                    success: function (B) {
                        f(B, s)
                    },
                    error: function () {
                        $('#inputSchedule' + s).html('<p>' + langSchedule.error + '!</p>')
                    }
                })) : $('.wrap-obr-' + s).fadeOut()
            },
            error: function () {
                $('#outputSchedule' + s).html('<p>' + langSchedule.error + '!</p>')
            }
        })
    }

    function b(s) {
        return 9 > s ? '0' + s : s
    }

    function d(s, t) {
        if (!s.segments.length) $('#outputSchedule' + t).html('<p>' + langSchedule.empty + '</p>'); else for (var u in $('#outputSchedule' + t).html('<table class="table-ras table table-bordered table-sm table-responsive-sm"><th>' + langSchedule.company + '</th><th>' + langSchedule.room + '</th><th>' + langSchedule.route + '</th><th>' + langSchedule.departure + '</th><th>' + langSchedule.arrival + '</th></table>'), s.segments) {
            var v = s.segments[u];
            if (20 <= v.arrival.length) var w = new Date(v.arrival), x = new Date(v.departure),
                y = b(w.getDate()) + '-' + b(w.getMonth() + 1) + '-' + w.getFullYear() + ' ' + b(w.getHours()) + ':' + b(w.getMinutes()),
                z = b(x.getDate()) + '-' + b(x.getMonth() + 1) + '-' + x.getFullYear() + ' ' + b(x.getHours()) + ':' + b(x.getMinutes()); else var y = v.arrival.substring(0, 5),
                z = v.departure.substring(0, 5);
            $('#outputSchedule' + t + ' .table-ras').append('<tr><td><img src="' + v.thread.carrier.logo_svg + '" alt="" width="20px"> <a href="' + v.thread.carrier.url + '" target="_blank">' + v.thread.carrier.title + '</a></td><td>' + v.thread.number + '</td><td>' + v.thread.short_title + '</td><td><span class="mainColor">' + y + '</span> ' + v.from.title + ' ' + v.from.station_type_name + '</td><td><span class="mainColor">' + z + '</span> ' + v.to.title + ' ' + v.to.station_type_name + '</td></tr>')
        }
    }

    function f(s, t) {
        if (!s.segments.length) $('#inputSchedule' + t).html('<p>' + langSchedule.empty + '</p>'); else for (var u in $('#inputSchedule' + t).html('<table class="table-ras table table-bordered"><th>' + langSchedule.company + '</th><th>' + langSchedule.room + '</th><th>' + langSchedule.route + '</th><th>' + langSchedule.departure + '</th><th>' + langSchedule.arrival + '</th></table>'), s.segments) {
            var v = s.segments[u];
            if (20 <= v.arrival.length) var w = new Date(v.arrival), x = new Date(v.departure),
                y = b(w.getDate()) + '-' + b(w.getMonth() + 1) + '-' + w.getFullYear() + ' ' + b(w.getHours()) + ':' + b(w.getMinutes()),
                z = b(x.getDate()) + '-' + b(x.getMonth() + 1) + '-' + x.getFullYear() + ' ' + b(x.getHours()) + ':' + b(x.getMinutes()); else var y = v.arrival,
                z = v.departure;
            $('#inputSchedule' + t + ' .table-ras').append('<tr><td><img src="' + v.thread.carrier.logo_svg + '" alt="" width="20px"> <a href="' + v.thread.carrier.url + '" target="_blank">' + v.thread.carrier.title + '</a></td><td>' + v.thread.number + '</td><td>' + v.thread.short_title + '</td><td><span class="mainColor">' + y + '</span> ' + v.from.title + ' ' + v.from.station_type_name + '</td><td><span class="mainColor">' + z + '</span> ' + v.to.title + ' ' + v.to.station_type_name + '</td></tr>')
        }
    }

    $('.hot-offers').owlCarousel({
        loop: !1,
        responsiveClass: !0,
        nav: !1,
        dots: !1,
        responsive: {0: {items: 1, margin: 10}, 600: {items: 2, margin: 50}, 1e3: {items: 3, margin: 50}}
    }), $('.block-tours').owlCarousel({
        loop: !1,
        responsiveClass: !0,
        nav: !1,
        dots: !1,
        responsive: {
            0: {items: 1, margin: 10},
            600: {items: 1, margin: 50},
            1e3: {items: 1, margin: 100},
            1100: {items: 2, margin: 100}
        }
    }), $('.block-pluses').owlCarousel({
        loop: !1,
        responsiveClass: !0,
        nav: !1,
        dots: !1,
        responsive: {0: {items: 1, margin: 10}, 600: {items: 2, margin: 20}, 1e3: {items: 3, margin: 30}}
    }), $('.block-news').owlCarousel({
        loop: !1,
        responsiveClass: !0,
        nav: !0,
        dots: !1,
        responsive: {0: {items: 1, margin: 10}, 600: {items: 2, margin: 15}, 1e3: {items: 3, margin: 15}}
    }), $('.main-nav .nav-link').click(function () {
        $('.nav-item').removeClass('active'), $(this).parents('.nav-item').addClass('active');
        var t = $(this).attr('href');
        '#' !== t && $('html, body').animate({scrollTop: $(t).offset().top}, 550)
    });
    var g = $.ajax({
        type: 'POST',
        async: !1,
        url: 'https://openexchangerates.org/api/latest.json?app_id=cc43b63517454bdd9907000524e0c373',
        dataType: 'json',
        success: function (s) {
            s.success && $('#cartCntItems').html(s.cntItems)
        }
    }), h = weather('1512569'), j = weather('1216265'), k = weather('1217662'), l = weather('1513604');
    $('.wethTas').append(h + ' \xB0C'), $('.wethSam').append(j + ' \xB0C'), $('.wethBukh').append(k + ' \xB0C'), $('.wethKhiw').append(l + ' \xB0C');
    var m = g.responseJSON.rates.UZS, o = g.responseJSON.rates.EUR;
    $('.dollar_usz').html(m), $('.dollar_eur').html(m / o);
    var q = new Date, r = parseInt(q.getHours()) - parseInt(timeTashkent.getHours());
    $('.timeFrom').text('0' + (9 + r) + ':00'), $('.timeTo').text(18 + r + ':00'), $(document).on('click', '#checkDateTo', function (s) {
        $(s.currentTarget).is(':checked') ? $('#dateTo').removeAttr('disabled') : $('#dateTo').attr('disabled', 'disabled')
    }), $(document).on('click', '#send', function () {
        a('plane'), a('train')
    }), $('.selectMultiple') && $('.selectMultiple').select2 && $('.selectMultiple').select2({width: '100%'})
});

function weather(a) {
    var b = $.ajax({
        type: 'POST',
        async: !1,
        url: 'http://api.openweathermap.org/data/2.5/weather?id=' + a + '&APPID=2326bb344551950d645e91890bd120ed',
        dataType: 'json',
        success: function () {
        }
    }), c = b.responseJSON.main.temp;
    return c = Math.floor(c - 273.15), c
}

function openAllProgram() {
    $('.collapse').collapse('toggle'), $('.openall').fadeToggle(0), $('.closeall').fadeToggle(0)
}

$(document).on('submit', '#book_it_form', function (a) {
    a.preventDefault();
    var b = sendForm($(a.currentTarget));
    return $.ajax({
        method: 'POST',
        url: '/book_it/send_mail_message/tour',
        data: b
    }), $('.alert-message').fadeIn(), $('#book_it_form')[0].reset(), !1
}), $(document).on('submit', '#createTour', function (a) {
    a.preventDefault();
    var b = sendForm($(a.currentTarget));
    return console.log(b), $.ajax({
        method: 'POST',
        url: '/book_it/send_mail_message/create_tour',
        data: b
    }), $('.alert-message').fadeIn(), $('#createTour')[0].reset(), !1
});

function sendForm(a) {
    let b = {};
    return $('input, textarea, select', a).each(function () {
        if (!$(this).attr('disabled') && (this.checkbox = 'checkbox' !== this.type || this.checked, this.radio = 'radio' !== this.type || this.checked, this.name && '' !== this.name && this.checkbox && this.radio)) if ('undefined' == typeof b[this.name]) b[this.name] = $(this).val(); else {
            if ('object' != typeof b[this.name]) {
                let c = b[this.name];
                b[this.name] = [], b[this.name].push(c)
            }
            b[this.name].push($(this).val())
        }
    }), b
}

window.initMap = function initMap() {
    if ($('#map')) var a = {lat: 41.289057, lng: 69.275128},
        b = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: a}),
        c = new google.maps.Marker({position: a, map: b, title: 'Ulysse Tour!'});
    if ($('#map-marker').length) var a = locations,
        b = new google.maps.Map(document.getElementById('map-marker'), {zoom: 12, center: a}),
        c = new google.maps.Marker({position: a, map: b}); else if ($('#map-route').length) {
        var b, f, g = new google.maps.DirectionsService;
        f = new google.maps.DirectionsRenderer, b = new google.maps.Map(document.getElementById('map-route'), {
            zoom: 10,
            center: new google.maps.LatLng(41.31159, 69.27927),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }), f.setMap(b);
        var c, j, h = new google.maps.InfoWindow, k = {travelMode: google.maps.TravelMode.DRIVING};
        for (j = 0; j < locations.length; j++) c = new google.maps.Marker({position: new google.maps.LatLng(locations[j][1], locations[j][2])}), google.maps.event.addListener(c, 'click', function (l, m) {
            return function () {
                h.setContent(locations[m][0]), h.open(b, l)
            }
        }(c, j)), 0 == j ? k.origin = c.getPosition() : j == locations.length - 1 ? k.destination = c.getPosition() : (!k.waypoints && (k.waypoints = []), k.waypoints.push({
            location: c.getPosition(),
            stopover: !0
        }));
        g.route(k, function (l, m) {
            m == google.maps.DirectionsStatus.OK && f.setDirections(l)
        })
    }
}
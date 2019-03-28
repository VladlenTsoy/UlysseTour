try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic');

    require('bootstrap');
    require('select2');
    require('datatables.net-bs4')();
} catch (e) {
}

$(document).ready(function () {
    // Описание
    if ($('#news-description', document).length)
        ClassicEditor
            .create(document.querySelector('#news-description'), {
                ckfinder: {
                    uploadUrl: '/admin/load/image'
                },
                image: {
                    toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight'],
                    styles: ['full', 'alignLeft', 'alignRight', 'alignCenter']
                }
            }).catch(error => console.error(error));

    //
    if ($('#conditions', document).length)
        ClassicEditor
            .create(document.querySelector('#conditions'), {
                ckfinder: {
                    uploadUrl: '/admin/load/image'
                },
                image: {
                    toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight'],
                    styles: ['full', 'alignLeft', 'alignRight', 'alignCenter']
                }
            }).catch(error => console.error(error));


    // Таблица
    if ($('.table', document).length) $('.table').DataTable({
        "language": {
            "processing": "Подождите...",
            "search": "Поиск:",
            "lengthMenu": "Показать _MENU_ записей",
            "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "infoEmpty": "Записи с 0 до 0 из 0 записей",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "infoPostFix": "",
            "loadingRecords": "Загрузка записей...",
            "zeroRecords": "Записи отсутствуют.",
            "emptyTable": "В таблице отсутствуют данные",
            "paginate": {
                "first": "Первая",
                "previous": "Предыдущая",
                "next": "Следующая",
                "last": "Последняя"
            },
            "aria": {
                "sortAscending": ": активировать для сортировки столбца по возрастанию",
                "sortDescending": ": активировать для сортировки столбца по убыванию"
            }
        },
        "columnDefs": [{
            "targets": -1,
            "orderable": false
        }]
    });


    //
    $(document).on('click', '#addProgram', addProgram);
    $(document).on('click', '.deleteButton', deleteLastProgram);
    let day = 1;
    let dayProgramSetting = {
        ckfinder: {
            uploadUrl: '/admin/load/image'
        },
        image: {
            toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight'],
            styles: ['full', 'alignLeft', 'alignRight', 'alignCenter']
        }
    };

    function update(bl = !1) {
        day = $('.program-block .block-current-program', document).length === 0 ? 1 : $('.program-block .block-current-program', document).length + 1;
        $('.program-block .block-current-program:not(:last-child)', document).find('.deleteButton').css('display', 'none');
        $('.program-block .block-current-program:last-child', document).find('.deleteButton').css('display', 'inline-block');
        if (bl)
            for (let i = 1; i <= day; i++)
                if ($('#day_' + i, document).length)
                    ClassicEditor
                        .create(document.querySelector('#day_' + i), dayProgramSetting)
                        .catch(error => console.error(error));
    }

    function addProgram(e) {
        update();
        $('.program-block', document).append('' + '<div class="block-current-program">\n' + '    <label for="day_title_' + day + '">День ' + day + ' ' + '       <span class="deleteButton"> Удалить</span>' + '   </label>' + '   <div class="form-group">' + '       <input type="text" name="program_title[]" class="form-control" placeholder="Введите заголовок дня программы">' + '   </div>' + '   <div class="form-group">' + '       <textarea class="form-control" name="program_desc[]" id="day_' + day + '"></textarea>' + '   </div>' + '</div>');
        if ($('#day_' + day, document).length)
            ClassicEditor
                .create(document.querySelector('#day_' + day), dayProgramSetting)
                .catch(error => console.error(error));
        day++
    }

    update(!0);

    function deleteLastProgram(e) {
        $(e.currentTarget).parents('.block-current-program', document).remove();
        update();
        day--
    }


    //
    if ($('#image-select', document).length)
        $(document).on('change', '#image-select', changeFunction);

    function changeFunction(event) {
        let img = event.currentTarget.files[0],
            reader = new FileReader();
        $('.image-selection', document).removeClass('success');
        $('.out-image', document).addClass('hideme');
        reader.onload = function () {
            $('#out-image', document).attr('src', reader.result).removeClass('hideme');
            $('.image-selection', document).addClass('success')
        };
        reader.readAsDataURL(img)
    }


    //
    if ($('.js-example-basic-multiple', document).length) {
        $('.js-example-basic-multiple', document).select2();
        $(".js-example-basic-multiple", document).on("select2:select", function (evt) {
            let element = evt.params.data.element;
            let $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change")
        })
    }

    //
    if ($('.js-ad-multiple', document).length) {
        $('.js-ad-multiple', document).select2();
        $(".js-ad-multiple", document).on("select2:select", function (evt) {
            let element = evt.params.data.element;
            let $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change")
        })
    }
});


/*********************************** Карта ********************************************/

window.initMap = function initialize() {
    if (!$('#map', document).length) return;

    let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: {
            lat: 41.31159,
            lng: 69.27927
        }
    });

    google.maps.event.addListener(map, 'click', (event) => addMarker(event.latLng, map, !1));
    updateMapsRoute(map)
};

let labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
let labelIndex = 0;
let markers = [];

function addMarker(location, map, sub) {
    let marker = new google.maps.Marker({
        position: location,
        label: labels[labelIndex++ % labels.length],
        map: map
    });
    markers.push(marker);
    if (!sub)
        $('.inputLocation', document).append('<input type="text" name="lat[]" value="' + marker.position.lat() + '"><input type="text" name="lng[]" value="' + marker.position.lng() + '">')
}

function deleteMarkers() {
    $('.inputLocation', document).html('');
    setMapOnAll(null);
    labelIndex = 0;
    markers = []
}

function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++)
        markers[i].setMap(map)
}

function updateMapsRoute(map) {
    setMapOnAll(null);
    labelIndex = 0;
    markers = [];
    let lngs = $('input[name="lng[]"]');
    $('input[name="lat[]"]')
        .each((key, val) =>
            addMarker({
                lat: parseFloat($(val).val()),
                lng: parseFloat($(lngs[key]).val())
            }, map, !0))
}

$(document).ready(() => $(document).on('click', '.btn-clear', deleteMarkers));

<p><b>Почта:</b> {{$email??''}}</p>
<p><b>Категория:</b> {{$category??''}}</p>
<p><b>Категория гостиниц:</b> {{$category_of_hotels ?? ''}}</p>
<p><b>Питание:</b> {{$food ?? ''}}</p>
<p><b>Услуги гида:</b> {{$guide_sevice ?? ''}}</p>
<p><b>Количество детей:</b> {{$number_of_kids ?? ''}}</p>
<p><b>Количество туристов:</b> {{$number_of_tourists ?? ''}}</p>
<p><b>Сезоны:</b> {{$season ?? ''}}</p>
<p><b>Тир размещения:</b> {{$shooting_range ?? ''}}</p>
<p><b>Дополнительная информация:</b> {{$sub_service ?? ''}}</p>
<p><b>Транспорт:</b> {{$transport ?? ''}}</p>

@if( isset($city) )
    <p><b>Город:</b> {{$city}}</p>
@endif

@if( isset($country) )
    @if(gettype($country) === 'array')
        @foreach($country as $value)
            <p>{{$value}}</p>
        @endforeach
    @else
        <p><b>Страна:</b> {{$country}}</p>
    @endif
@endif

@if( isset($service ) )
    @if(gettype($service) === 'array')
        @foreach($service as $value)
            <p>{{$value}}</p>
        @endforeach
    @else
        <p>{{$service}}</p>
    @endif
@endif
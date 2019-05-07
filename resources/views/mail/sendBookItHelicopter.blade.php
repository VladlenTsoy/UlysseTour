<p>Категория: {{$category}}</p>
<br>
@isset($direction)
    <p><b>Направления:</b> {{$direction}}</p>
@endisset
@isset($charter)
    <p><b>Направления</b></p>
    <p>Машрут: {{$charter->route}}</p>
    <p>Стоимость: {{$charter->cost}}</p>
    <p>Количество туристов : {{$charter->max_qty_tourists}}</p>
@endisset
<br>
@isset($helicopter)
    <p><b>Расписание</b></p>
    <p>Дата: {{$helicopter->date}}</p>
    <p>Название: {{$helicopter->title}}</p>
    <p>Место: {{$helicopter->place}}</p>
    <p>Стоимость: {{$helicopter->cost}}</p>
    <p>Количество туристов : {{$helicopter->max_qty_tourists}}</p>
@endisset
<br>
<p><b>Данные</b></p>
<p>Имя: {{$last_name}}</p>
<p>Фамилия: {{$first_name}}</p>
<p>Почту: {{$email}}</p>
<p>Номер: {{$cellphone}}</p>
<p>Гражданство: {{$citizenship}}</p>
<p>Количество детей: {{$number_of_kids}}</p>
<p>Количество туристов: {{$number_of_tourists}}</p>
<p>Дата: {{$dates}}</p>
<p>Дополнительная информация: {{$additional_info}}</p>
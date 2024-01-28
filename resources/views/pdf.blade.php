<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        <!--
        span.cls_002{font-size:10.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_002{font-size:10.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_003{font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_003{font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_004{font-size:10.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_004{font-size:10.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        -->
    </style>
</head>
<body>
<div style="position:relative;width:100%;height:100%;border-style:none;overflow:hidden">
    <div style="position:absolute;left:0px;top:0px">
        <img src="{{$img}}" width="100%"></div>
        <div style="position:absolute;left:59.53px;top:100.15px" class="cls_002">
            <span class="cls_002">Документ подписан в сервисе </span>
            <A HREF="https://carcity.kz">https://carcity.kz</A>
        </div>
        <div style="position:absolute;left:260.93px;top:128px" class="cls_003">
            <span class="cls_003">Паспорт документа</span>
        </div>
        <div style="position:absolute;left:212.92px;top:160.43px" class="cls_002">
            <span class="cls_002">Название:</span>
        </div>
        <div style="position:absolute;left:297.96px;top:160.43px" class="cls_004">
            <span class="cls_004">{{$application->name}}</span>
        </div>
        <div style="position:absolute;left:80.09px;top:180.27px" class="cls_002">
            <span class="cls_002">Документ</span>
        </div>
        <div style="position:absolute;left:212.92px;top:200.27px" class="cls_002">
            <span class="cls_002">Номер:</span>
        </div>
        <div style="position:absolute;left:297.96px;top:200.27px" class="cls_004">
            <span class="cls_004">{{$application->number}}</span>
        </div>
        <div style="position:absolute;left:212.92px;top:180.27px" class="cls_002">
            <span class="cls_002">Дата:</span>
        </div>
        <div style="position:absolute;left:297.96px;top:180.27px" class="cls_004">
            <span class="cls_004">{{date('d.m.Y',strtotime($application->created_at))}}</span>
        </div>
        <div style="position:absolute;left:80.09px;top:230.96px" class="cls_002">
            <span class="cls_002">Отправитель</span>
        </div>
        <div style="position:absolute;left:212.92px;top:230.96px" class="cls_004">
            <span class="cls_004">ТОО "ТЦ "Car City" (Кар Сити)</span>
        </div>
        <div style="position:absolute;left:212.92px;top:250.96px" class="cls_004">
            <span class="cls_004">БИН / ИИН: 180940005563</span>
        </div>
        <div style="position:absolute;left:80.09px;top:275.64px" class="cls_002">
            <span class="cls_002">Получатель</span>
        </div>
        <div style="position:absolute;left:212.92px;top:275.64px" class="cls_004">
            <span class="cls_004">{{$userData2->company}}</span>
        </div>
        <div style="position:absolute;left:212.92px;top:295.64px" class="cls_004">
            <span class="cls_004">БИН / ИИН: {{$userData2->bin}}</span>
        </div>
        <div style="position:absolute;left:80.09px;top:320px" class="cls_002">
            <span class="cls_002">Статус документа:</span>
        </div>
        <div style="position:absolute;left:212.92px;top:320px" class="cls_004">
            <span class="cls_004">Подписано отправителем и получателем</span>
        </div>
        <div style="position:absolute;left:80.09px;top:345px" class="cls_002">
            <span class="cls_002">Название файла:</span>
        </div>
        <div style="position:absolute;left:212.92px;top:345px" class="cls_004">
            <span class="cls_004">{{$application->id}}.docx</span>
        </div>
        <div style="position:absolute;left:59.53px;top:380px" class="cls_003">
            <span class="cls_003">Детали подписи документа</span>
        </div>
        <div style="position:absolute;left:59.53px;top:410px" class="cls_002">
            <span class="cls_002">Данные по отправителю: </span>
            <span class="cls_004">ТОО "ТЦ "CAR CITY" (КАР СИТИ)</span>
        </div>
        <div style="position:absolute;left:73.70px;top:435px" class="cls_002">
            <span class="cls_002">Подписант № 1</span>
        </div>
        <div style="position:absolute;left:73.70px;top:455px" class="cls_002">
            <span class="cls_002">Владелец сертификата:</span>
        </div>
        <div style="position:absolute;left:270px;top:455px" class="cls_004">
            <span class="cls_004">{{$user1['cert']['chain'][0]['subject']['commonName']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:475px" class="cls_002">
            <span class="cls_002">Издатель:</span>
        </div>
        <div style="position:absolute;left:270px;top:475px" class="cls_004">
            <span class="cls_004">НУЦ РК (RSA)</span>
        </div>
        <div style="position:absolute;left:73.70px;top:495px" class="cls_002">
            <span class="cls_002">Cерийный номер сертификата:</span>
        </div>
        <div style="position:absolute;left:270px;top:495px" class="cls_004">
            <span class="cls_004">{{$user1['cert']['chain'][0]['serialNumber']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:515px" class="cls_002">
            <span class="cls_002">Время действия сертификата:</span>
        </div>
        <div style="position:absolute;left:270px;top:515px" class="cls_004">
            <span class="cls_004">c {{$user1['cert']['chain'][0]['notBefore']}} по {{$user1['cert']['chain'][0]['notAfter']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:535px" class="cls_002">
            <span class="cls_002">Дата и время подписания:</span>
        </div>
        <div style="position:absolute;left:270px;top:535px" class="cls_004">
            <span class="cls_004">{{date('d.m.Y',strtotime($userDate1))}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:555px" class="cls_002">
            <span class="cls_002">На момент подписания:</span>
        </div>
        <div style="position:absolute;left:270px;top:555px" class="cls_004">
            <span class="cls_004">Сертификат действителен и проверен НУЦ РК</span>
        </div>
        <div style="position:absolute;left:59.53px;top:580px" class="cls_002">
            <span class="cls_002">Данные по получателю: </span>
            <span class="cls_004">{{$userData2->company}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:605px" class="cls_002">
            <span class="cls_002">Подписант № 2</span>
        </div>
        <div style="position:absolute;left:73.70px;top:625px" class="cls_002">
            <span class="cls_002">Владелец сертификата:</span>
        </div>
        <div style="position:absolute;left:270px;top:625px" class="cls_004">
            <span class="cls_004">{{$user2['cert']['chain'][0]['subject']['commonName']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:645px" class="cls_002">
            <span class="cls_002">ИИН: подписанта:</span>
        </div>
        <div style="position:absolute;left:270px;top:645px" class="cls_004">
            <span class="cls_004">{{$user2['cert']['chain'][0]['subject']['iin']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:665px" class="cls_002">
            <span class="cls_002">Издатель:</span>
        </div>
        <div style="position:absolute;left:270px;top:665px" class="cls_004">
            <span class="cls_004">НУЦ РК (RSA)</span>
        </div>
        <div style="position:absolute;left:73.70px;top:685px" class="cls_002">
            <span class="cls_002">Cерийный номер сертификата:</span>
        </div>
        <div style="position:absolute;left:270px;top:685px" class="cls_004">
            <span class="cls_004">{{$user2['cert']['chain'][0]['serialNumber']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:705px" class="cls_002">
            <span class="cls_002">Время действия сертификата:</span>
        </div>
        <div style="position:absolute;left:270px;top:705px" class="cls_004">
            <span class="cls_004">c {{$user2['cert']['chain'][0]['notBefore']}} по {{$user2['cert']['chain'][0]['notAfter']}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:725px" class="cls_002">
            <span class="cls_002">Дата и время подписания:</span>
        </div>
        <div style="position:absolute;left:270px;top:725px" class="cls_004">
            <span class="cls_004">{{date('d.m.Y',strtotime($userDate2))}}</span>
        </div>
        <div style="position:absolute;left:73.70px;top:745px" class="cls_002">
            <span class="cls_002">На момент подписания:</span>
        </div>
        <div style="position:absolute;left:270px;top:745px" class="cls_004">
            <span class="cls_004">Сертификат действителен и проверен НУЦ РК</span>
        </div>
        <div style="position:absolute;left:400px;top:880px" class="cls_004">
            <span class="cls_004">Архив сформирован {{$userDate2}}</span>
        </div>
</div>
</body>
</html>

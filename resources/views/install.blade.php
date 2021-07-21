@extends('integration::master')
@section('content')
    <style type="text/css">
        table {
            border-collapse: collapse;
            border: 1px solid black;
        }
        td, th {
            padding: 15px;
            border: 1px solid black;
        }
    </style>

    <div class="container" style="max-width: 1200px; margin:0 auto; display: block;">
        <h1>Install init</h1>
        <table>
            <thead>
                <tr>
                    <th>Команда</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>

                <tr><td>Создание компании</td><td><span id="onCrmCompanyAdd">Не установлено</span></td></tr>
                <tr><td>Создание сделок</td><td><span id="onCrmDealAdd">Не установлено</span></td></tr>
                <tr><td>Создание контакта</td><td><span id="onCrmContactAdd">Не установлено</span></td></tr>
                <tr><td>Создание лидов</td><td><span id="onCrmLeadAdd">Не установлено</span></td></tr>
                <tr><td>Создание товаров</td><td><span id="onCrmProductAdd">Не установлено</span></td></tr>
                <tr><td>Создание дел</td><td><span id="onCrmActivityAdd">Не установлено</span></td></tr>
                <tr><td>Создание реквизитов</td><td><span id="onCrmRequisiteAdd">Не установлено</span></td></tr>
                <tr><td>Создание задач</td><td><span id="OnTaskAdd">Не установлено</span></td></tr>

                <tr><td>Обновление компании</td><td><span id="onCrmCompanyUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление сделок</td><td><span id="onCrmDealUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление контактов</td><td><span id="onCrmContactUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление лидов</td><td><span id="onCrmLeadUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление продуктов</td><td><span id="onCrmProductUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление дел</td><td><span id="onCrmActivityUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление реквизитов</td><td><span id="onCrmRequisiteUpdate">Не установлено</span></td></tr>
                <tr><td>Обновление задач</td><td><span id="OnTaskUpdate">Не установлено</span></td></tr>

                <tr><td>Удаление компании</td><td><span id="onCrmCompanyDelete">Не установлено</span></td></tr>
                <tr><td>Удаление сделок</td><td><span id="onCrmDealDelete">Не установлено</span></td></tr>
                <tr><td>Удаление лидов</td><td><span id="onCrmLeadUpdate">Не установлено</span></td></tr>
                <tr><td>Удаление продуктов</td><td><span id="onCrmProductDelete">Не установлено</span></td></tr>
                <tr><td>Удаление контактов</td><td><span id="onCrmContactDelete">Не установлено</span></td></tr>
                <tr><td>Удаление дел</td><td><span id="onCrmActivityDelete">Не установлено</span></td></tr>
                <tr><td>Удаление реквизитов</td><td><span id="onCrmRequisiteDelete">Не установлено</span></td></tr>
                <tr><td>Удаление задач</td><td><span id="OnTaskDelete">Не установлено</span></td></tr>

            </tbody>
        </table>
    </div>
    <script>
        let events_mas = [ // тут евенты которые будут установлены
            // компании
            'onCrmCompanyAdd',
            'onCrmCompanyUpdate',

            // дела
            'onCrmActivityAdd',
            'onCrmActivityUpdate',

            // задачи
            'OnTaskAdd',
            'OnTaskUpdate',

            // реквизиты
            'onCrmRequisiteAdd',
            'onCrmRequisiteUpdate',

            // контакты
            'onCrmContactAdd',
            'onCrmContactUpdate',

            // сделки
            'onCrmDealAdd',
            'onCrmDealUpdate',

            // товары
            'onCrmProductAdd',
            'onCrmProductUpdate',

        ];
        let counts = events_mas.length;
        let i = 0, errors_flag = false;


        window.onload = function(){
            BX24.ready(function(){
                BX24.init(function(){

                    events_mas.forEach((item)=>{
                        document.getElementById(item).innerHTML = 'Идет установка!';
                        BX24.callMethod(
                            "event.bind",
                            {
                                event: item,
                                event_type : 'offline',
                                auth_connector: 'bxapp',
                            },
                            function(result)
                            {
                                if(result.error()){
                                    document.getElementById(item).innerHTML = 'ОШИБКА (в консоле)';
                                    console.log('event.bind - выполнен с ОШИБКОЙ', item, result.error())
                                    errors_flag = true;
                                }else{
                                    i++;
                                    document.getElementById(item).innerHTML = 'Установлено!';
                                }
                            }
                        );
                    });

                    setInterval(()=>{
                        if(i >= counts){
                            alert('Приложение установлено!');
                            BX24.installFinish();
                        }
                    }, 1111)

                });
            });

        }
    </script>
@stop

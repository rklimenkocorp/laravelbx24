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
        <h1>Установка приложения для интеграции</h1>
        <button onclick="finishInstall()"> Завершить установку </button>
        <br>
        <br>

        <table>
            <thead>
                <tr>
                    <th>Команда</th>
                    <th>Статус</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <tr><td>Создание компании</td><td><span id="onCrmCompanyAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmCompanyAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmCompanyAdd')">Удалить</button></td></tr>
                <tr><td>Создание сделок</td><td><span id="onCrmDealAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmDealAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmDealAdd')">Удалить</button></td></tr>
                <tr><td>Создание контакта</td><td><span id="onCrmContactAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmContactAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmContactAdd')">Удалить</button></td></tr>
                <tr><td>Создание лидов</td><td><span id="onCrmLeadAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmLeadAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmLeadAdd')">Удалить</button></td></tr>
                <tr><td>Создание товаров</td><td><span id="onCrmProductAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmProductAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmProductAdd')">Удалить</button></td></tr>
                <tr><td>Создание дел</td><td><span id="onCrmActivityAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmActivityAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmActivityAdd')">Удалить</button></td></tr>
                <tr><td>Создание реквизитов</td><td><span id="onCrmRequisiteAdd">Не установлено</span></td><td><button onclick="clickButton('onCrmRequisiteAdd')">Установить</button></td><td><button onclick="clickButtonDel('onCrmRequisiteAdd')">Удалить</button></td></tr>
                <tr><td>Создание задач</td><td><span id="OnTaskAdd">Не установлено</span></td><td><button onclick="clickButton('OnTaskAdd')">Установить</button></td><td><button onclick="clickButtonDel('OnTaskAdd')">Удалить</button></td></tr>

                <tr><td>Обновление компании</td><td><span id="onCrmCompanyUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmCompanyUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmCompanyUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление сделок</td><td><span id="onCrmDealUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmDealUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmDealUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление контактов</td><td><span id="onCrmContactUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmContactUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmContactUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление лидов</td><td><span id="onCrmLeadUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmLeadUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmLeadUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление продуктов</td><td><span id="onCrmProductUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmProductUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmProductUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление дел</td><td><span id="onCrmActivityUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmActivityUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmActivityUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление реквизитов</td><td><span id="onCrmRequisiteUpdate">Не установлено</span></td><td><button onclick="clickButton('onCrmRequisiteUpdate')">Установить</button></td><td><button onclick="clickButtonDel('onCrmRequisiteUpdate')">Удалить</button></td></tr>
                <tr><td>Обновление задач</td><td><span id="OnTaskUpdate">Не установлено</span></td><td><button onclick="clickButton('OnTaskUpdate')">Установить</button></td><td><button onclick="clickButtonDel('OnTaskUpdate')">Удалить</button></td></tr>

                <tr><td>Удаление компании</td><td><span id="onCrmCompanyDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmCompanyDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmCompanyDelete')">Удалить</button></td></tr>
                <tr><td>Удаление сделок</td><td><span id="onCrmDealDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmDealDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmDealDelete')">Удалить</button></td></tr>
                <tr><td>Удаление лидов</td><td><span id="onCrmLeadDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmLeadDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmLeadDelete')">Удалить</button></td></tr>
                <tr><td>Удаление продуктов</td><td><span id="onCrmProductDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmProductDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmProductDelete')">Удалить</button></td></tr>
                <tr><td>Удаление контактов</td><td><span id="onCrmContactDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmContactDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmContactDelete')">Удалить</button></td></tr>
                <tr><td>Удаление дел</td><td><span id="onCrmActivityDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmActivityDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmActivityDelete')">Удалить</button></td></tr>
                <tr><td>Удаление реквизитов</td><td><span id="onCrmRequisiteDelete">Не установлено</span></td><td><button onclick="clickButton('onCrmRequisiteDelete')">Установить</button></td><td><button onclick="clickButtonDel('onCrmRequisiteDelete')">Удалить</button></td></tr>
                <tr><td>Удаление задач</td><td><span id="OnTaskDelete">Не установлено</span></td><td><button onclick="clickButton('OnTaskDelete')">Установить</button></td><td><button onclick="clickButtonDel('OnTaskDelete')">Удалить</button></td></tr>

            </tbody>
        </table>
    </div>
    <script>

        function finishInstall(){
            BX24.installFinish();
        }

        function clickButtonDel(item){
            document.getElementById(item).innerHTML = 'Идет удаление!';
            BX24.callMethod(
                "event.unbind",
                {
                    event: item,
                    event_type : 'offline',
                    auth_connector: 'bxapp',
                },
                function(result)
                {
                    if(result.error()){
                        document.getElementById(item).innerHTML =  result.error().error_description;
                        console.log('event.bind - выполнен с ОШИБКОЙ', item, result.error())
                    }else{
                        document.getElementById(item).innerHTML = 'Удалено!';
                    }
                }
            );
        }
        function clickButton(item){
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
                        document.getElementById(item).innerHTML =  result.error().error_description;
                        console.log('event.bind - выполнен с ОШИБКОЙ', item, result.error())
                    }else{
                        document.getElementById(item).innerHTML = 'Установлено!';
                    }
                }
            );
        }

    </script>
@stop

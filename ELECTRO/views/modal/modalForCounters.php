<!-- Modal правки счетчика -->
<div class="modal fade" id="updateCounter" tabindex="-1" aria-labelledby="updateCounterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="updateCounterTitle">Информация по счетчику</h1>
                <form class="deleteForm" action="/counter/delete" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_counter" name="id_delete" id="id_delete">
                    <input type="hidden" class="id_object_delete" name="id_object_delete" id="id_object_delete">
                    <button type="submit" class="btn btn-danger deleteButton">Удалить</button>
                </form>
            </div>
            <form class="mt-4" action="/counter/update" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_counter" name="id_counter" id="id_counter">
                    <input type="hidden" class="id_object" name="id_object" id="id_object">
                    
                    <div class="mb-2">
                        <label for="counter_type" class="form-label">Тип счетчика</label>
                        <select name="counter_type" id="counter_type" class="form-control">
                            <option value="1">электроэнергии</option>
                            <option value="2">тепловой энергии</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="sn">Заводской номер</label>
                        <input type="text" class="form-control" id="sn" name="sn" required>
                    </div>

                    <div class="mb-2">
                        <label for="transform">Коэффициент трансформации</label>
                        <input type="text" class="form-control" id="transform" name="transform" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal добавление счетчика -->
<div class="modal fade" id="addCounter" tabindex="-1" aria-labelledby="addCounterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCounterTitle"></h1>
            </div>
            <form class="mt-4" action="/counter/add" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_object" name="id_object" id="id_object">
                    
                    <div class="mb-2">
                        <label for="counter_type" class="form-label">Тип счетчика</label>
                        <select name="counter_type" id="counter_type" class="form-control">
                            <option value="1">электроэнергии</option>
                            <option value="2">тепловой энергии</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="sn">Заводской номер</label>
                        <input type="text" class="form-control" id="sn" name="sn" required>
                    </div>

                    <div class="mb-2">
                        <label for="transform">Коэффициент трансформации</label>
                        <input type="text" class="form-control" id="transform" name="transform" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal данные счетчиков -->
<div class="modal fade" id="addCounterData" tabindex="-1" aria-labelledby="addCounterDataTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <p class="modal-title fs-5" id="addCounterDataTitle"></p>
                <form class="deleteForm" action="/counter/deleteData" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_counter_delete" name="id_counter_delete" id="id_counter_delete">
                    <input type="hidden" class="id_object_del" name="id_object_del" id="id_object_del">
                    <input type="hidden" class="tab_delete" name="tab_delete" id="tab_delete">
                    <button type="submit" class="btn btn-danger deleteButton">Удалить</button>
                </form>
            </div>
            <form class="mt-4" action="/counter/addData" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_counter" name="id_counter" id="id_counter">
                    <input type="hidden" class="id_object" name="id_object" id="id_object">
                    <input type="hidden" class="tab" name="tab" id="tab">
                    
                    <div class="mb-2">
                        <label class="mb-2" for="value">Показания счетчика</label>
                        <input type="text" class="form-control" id="value" name="value" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal добавление данных по счет-фактуре -->
<div class="modal fade" id="addCounterArenda" tabindex="-1" aria-labelledby="addCounterArendaTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCounterArendaTitle"></h1>
            </div>
            <form class="mt-4" action="/counter/addArenda" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_object" name="id_object_arenda" id="id_object_arenda">
                    
                    <label for="counter_type_arenda" class="form-label">Показания по...</label>
                    <select name="counter_type" id="counter_type_arenda" class="form-control">
                        <option value="1">электроэнергии</option>
                        <option value="2">тепловой энергии</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal данные счетчиков АРЕНДА -->
<div class="modal fade" id="addCounterArendaData" tabindex="-1" aria-labelledby="addCounterArendaDataTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <p class="modal-title fs-5" id="addCounterArendaDataTitle"></p>
                <form class="deleteForm" action="./counter/deleteArendaData" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_counter_deleteArenda" name="id_counter_delete" id="id_counter_deleteArenda">
                    <input type="hidden" class="id_object_delArenda" name="id_object_del" id="id_object_delArenda">
                    <input type="hidden" class="tab_deleteArenda" name="tab_delete" id="tab_deleteArenda">
                    <button type="submit" class="btn btn-danger deleteButton">Удалить</button>
                </form>
            </div>
            <form class="mt-4" action="/counter/addArendaData" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_counterArenda" name="id_counter" id="id_counterArenda">
                    <input type="hidden" class="id_objectArenda" name="id_object" id="id_objectArenda">
                    <input type="hidden" class="tabArenda" name="tab" id="tabArenda">
                    
                    <label class="mb-2" for="value">Потребление по счет-фактуре</label>
                    <input type="text" class="form-control" id="valueArenda" name="value" required>

                    <label class="mb-2" for="pay">Сумма к оплате по счет-фактуре</label>
                    <input type="text" class="form-control" id="pay" name="pay" required>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal фильтр -->
<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Фильтр по годам</h1>
            </div>
            <form class="mt-4" action="/filter" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" name="filter_counter" value="1">
                    <input type="hidden" name="id_object" id="id_object_filter">
                    <div class="mb-3">
                        <label for="year">Выберите год</label>
                        <select name="year" id="year" class="form-control">
                            <?php
                                $date = 2023;
                                for($i=1; $i<150;$i++) {
                                    echo ("<option value=".$date.">$date</option>");
                                    $date++;
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Применить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS -->

<!-- Обработка кнопки вызова модального окна СЧЕТЧИКА -->
<script type="text/javascript">
    const updateCounter = document.getElementById('updateCounter');
    if (updateCounter) {
        updateCounter.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id_counter = button.getAttribute('cnt-id');
        const type = button.getAttribute('cnt-type');
        const sn = button.getAttribute('cnt-sn');
        const id_object = button.getAttribute('obj-id');
        const trans = button.getAttribute('trans');
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const idCounter = updateCounter.querySelector('#id_counter');
        const counterSN = updateCounter.querySelector('#sn');
        const idCounterDelete = updateCounter.querySelector('#id_delete');
        const idObject = updateCounter.querySelector('#id_object');
        const idObjectDelete = updateCounter.querySelector('#id_object_delete');
        const transInfo = updateCounter.querySelector('#transform');


        idCounter.value = id_counter;
        idCounterDelete.value = id_counter;
        counterSN.value = sn;
        idObject.value = id_object;
        idObjectDelete.value = id_object;
        transInfo.value = trans;

        const select = updateCounter.querySelector('#counter_type').getElementsByTagName('option');

        for(let i = 0; i < select.length; i++) {
        if( select[i].text.toLowerCase() === type.toLowerCase()) select[i].selected = true
        }
    })
    };

    const addCounter = document.getElementById('addCounter');
    if(addCounter) {
        addCounter.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const object_name = button.getAttribute('obj-name');
            const id_object = button.getAttribute('id-object');

            const objectName = addCounter.querySelector('#addCounterTitle');
            const idObject = addCounter.querySelector('#id_object');

            objectName.textContent = object_name;
            idObject.value = id_object;
        })
    };

    const addCounterData = document.getElementById('addCounterData');
    if(addCounterData) {
        addCounterData.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const id = button.getAttribute('cnt-id');
            const value = button.getAttribute('cnt-value');
            const month = button.getAttribute('month');
            const table = button.getAttribute('cnt-table');
            const object = button.getAttribute('obj');

            const title = addCounterData.querySelector('#addCounterDataTitle');
            const idCounter = addCounterData.querySelector('#id_counter');
            const idCounterDelete = addCounterData.querySelector('#id_counter_delete');
            const counterValue = addCounterData.querySelector('#value');
            const counterTab = addCounterData.querySelector('#tab');
            const counterTabDelete = addCounterData.querySelector('#tab_delete');
            const idObj = addCounterData.querySelector('#id_object');
            const idObjDel = addCounterData.querySelector('#id_object_del');

            let date = new Date();

            title.textContent = `${month} ${date.getFullYear()}`;
            idCounter.value = id;
            idCounterDelete.value = id;
            counterValue.value = value;
            counterTab.value = table;
            counterTabDelete.value = table;
            idObj.value = object;
            idObjDel.value = object;

        })
    }

    const addCounterArenda = document.getElementById('addCounterArenda');
    if(addCounterArenda) {
        addCounterArenda.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const object_name = button.getAttribute('obj-name');
            const id_object = button.getAttribute('id-object');

            const objectName = addCounterArenda.querySelector('#addCounterArendaTitle');
            const idObject = addCounterArenda.querySelector('#id_object_arenda');

            objectName.textContent = object_name;
            idObject.value = id_object;
        })
    };

    const addCounterArendaData = document.getElementById('addCounterArendaData');
    if(addCounterArendaData) {
        addCounterArendaData.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const id = button.getAttribute('cnt-id');
            const value = button.getAttribute('cnt-value');
            const month = button.getAttribute('month');
            const table = button.getAttribute('cnt-table');
            const object = button.getAttribute('obj');
            const pay = button.getAttribute('pay');

            const title = addCounterArendaData.querySelector('#addCounterArendaDataTitle');
            const idCounter = addCounterArendaData.querySelector('#id_counterArenda');
            const idCounterDelete = addCounterArendaData.querySelector('#id_counter_deleteArenda');
            const counterValue = addCounterArendaData.querySelector('#valueArenda');
            const counterTab = addCounterArendaData.querySelector('#tabArenda');
            const counterTabDelete = addCounterArendaData.querySelector('#tab_deleteArenda');
            const idObj = addCounterArendaData.querySelector('#id_objectArenda');
            const idObjDel = addCounterArendaData.querySelector('#id_object_delArenda');
            const arendaPay = addCounterArendaData.querySelector('#pay');

            let date = new Date();

            title.textContent = `${month} ${date.getFullYear()}`;
            idCounter.value = id;
            idCounterDelete.value = id;
            counterValue.value = value;
            counterTab.value = table;
            counterTabDelete.value = table;
            idObj.value = object;
            idObjDel.value = object;
            arendaPay.value = pay;

        })
    }

    const filter = document.getElementById('filter');
    if(filter) {
        filter.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id_object = button.getAttribute('id-object');
            const idObject = filter.querySelector('#id_object_filter');
            idObject.value = id_object;
        })
    };
</script>
<!-- Modal данных по емкости-->
<div class="modal fade" id="addPortsInfo" tabindex="-1" aria-labelledby="addPortsInfoTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <p class="modal-title fs-5" id="addPortsInfoTitle"></p>
                <form class="deleteForm" action="./ports/delete" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_object_delete" name="id_object_del" id="id_object_delete">
                    <input type="hidden" class="tab_delete" name="tab_delete" id="tab_delete">
                    <button type="submit" class="btn btn-danger deleteButton">Удалить</button>
                </form>
            </div>
            <form action="./ports/add" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_object" name="id_object" id="id_object">
                    <input type="hidden" class="tab" name="tab" id="tab">

                    <label class="mb-2" for="used">Задействовано</label>
                    <input type="text" class="form-control" id="used" name="used" required>
                    
                    <label class="mb-2" for="mount">Монтировано</label>
                    <input type="text" class="form-control" id="mount" name="mount" required>                    

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
            <form class="mt-4" action="/filter" method="get" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" name="filter_ports" value="1">
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
    const addPortsInfo = document.getElementById('addPortsInfo');
    if(addPortsInfo) {
        addPortsInfo.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const used = button.getAttribute('used');
            const mount = button.getAttribute('mount');
            const month = button.getAttribute('month');
            const table = button.getAttribute('table');
            const object = button.getAttribute('obj');
            

            const title = addPortsInfo.querySelector('#addPortsInfoTitle');
            const objUsed = addPortsInfo.querySelector('#used');
            const objMount = addPortsInfo.querySelector('#mount');
            const objTab = addPortsInfo.querySelector('#tab');
            const objTabDel = addPortsInfo.querySelector('#tab_delete');
            const idObj = addPortsInfo.querySelector('#id_object');
            const idObjDel = addPortsInfo.querySelector('#id_object_delete');


            title.textContent = `Данные за ${month}`;
            objUsed.value = used;
            objMount.value = mount;
            objTab.value = table;
            objTabDel.value = table;
            idObj.value = object;
            idObjDel.value = object;
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
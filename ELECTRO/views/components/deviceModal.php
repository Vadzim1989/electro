<!-- Modal правки счетчика -->
<div class="modal fade" id="updateDevice" tabindex="-1" aria-labelledby="updateDeviceTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="updateDeviceTitle">Информация по оборудованию</h1>
                <form class="deleteForm" action="./device/delete" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_device_delete" name="id_device_delete" id="id_device_delete">
                    <input type="hidden" class="id_object_delete" name="id_object_delete" id="id_object_delete">
                    <button type="submit" class="btn btn-danger deleteButton">Удалить</button>
                </form>
            </div>
            <form class="mt-4" action="./device/update" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_device" name="id_device" id="id_device">
                    <input type="hidden" class="id_object" name="id_object" id="id_object">

                    <div class="mb-3">
                        <label for="name">Оборудование</label>
                        <input type="text" class="form-control" id="name" name="name" require>
                    </div>

                    <div class="mb-3">
                        <label for="mount">Установлено</label>
                        <input type="text" class="form-control" id="mount" name="mount" require>
                    </div>

                    <div class="mb-3">
                        <label for="used">Используется</label>
                        <input type="text" class="form-control" id="used" name="used" require>
                    </div>

                    <div class="mb-3">
                        <label for="power">Потребляемая мощность, Вт</label>
                        <input type="text" class="form-control" id="power" name="power" require>
                    </div>

                    <div class="mb-3">
                        <label for="time">Время работы</label>
                        <input type="text" class="form-control" id="time" name="time" require>
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
<div class="modal fade" id="addDevice" tabindex="-1" aria-labelledby="addDeviceTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDeviceTitle"></h1>
            </div>
            <form class="mt-4" action="./device/add" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_object" name="id_object" id="id_object">
                    <h3>Добавить оборудование:</h3>
                    <div class="mb-3">
                        <label for="name">Наименование</label>
                        <input type="text" class="form-control" id="name" name="name" require>
                    </div>

                    <div class="mb-3">
                        <label for="mount">Установлено</label>
                        <input type="text" class="form-control" id="mount" name="mount" require>
                    </div>

                    <div class="mb-3">
                        <label for="used">Используется</label>
                        <input type="text" class="form-control" id="used" name="used" require>
                    </div>

                    <div class="mb-3">
                        <label for="power">Потребляемая мощность, Вт</label>
                        <input type="text" class="form-control" id="power" name="power" require>
                    </div>

                    <div class="mb-3">
                        <label for="time">Время работы</label>
                        <input type="text" class="form-control" id="time" name="time" require>
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

<!-- JS -->
<script src="/ELECTRO/assets/js/bootstrap.min.js"></script>

<!-- Обработка кнопки вызова модального окна СЧЕТЧИКА -->
<script type="text/javascript">
    const updateDevice = document.getElementById('updateDevice');
    if (updateDevice) {
        updateDevice.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id_device = button.getAttribute('id-dev');
        const id_object = button.getAttribute('id-obj');
        const name = button.getAttribute('dev-nam');
        const mount = button.getAttribute('dev-mnt');
        const used = button.getAttribute('dev-use');
        const power = button.getAttribute('dev-pw');
        const time = button.getAttribute('dev-tm');
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const idDevice = updateDevice.querySelector('#id_device');
        const idDeviceDelete = updateDevice.querySelector('#id_device_delete');
        const idObject = updateDevice.querySelector('#id_object');
        const idObjectDelete = updateDevice.querySelector('#id_object_delete');
        const deviceName = updateDevice.querySelector('#name');
        const deviceMount = updateDevice.querySelector('#mount');
        const deviceUsed = updateDevice.querySelector('#used');
        const devicePower = updateDevice.querySelector('#power');
        const deviceTime = updateDevice.querySelector('#time');


        idDevice.value = id_device;
        idDeviceDelete.value = id_device;
        idObject.value = id_object;
        idObjectDelete.value = id_object;
        deviceName.value = name;
        deviceMount.value = mount;
        deviceUsed.value = used;
        devicePower.value = power;
        deviceTime.value = time;
    })
    };

    const addDevice = document.getElementById('addDevice');
    if(addDevice) {
        addDevice.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const object_name = button.getAttribute('obj-nam');
            const id_object = button.getAttribute('id-obj');

            const objectName = addDevice.querySelector('#addDeviceTitle');
            const idObject = addDevice.querySelector('#id_object');

            objectName.textContent = object_name;
            idObject.value = id_object;
        })
    };
</script>
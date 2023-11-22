  <!-- Modal правки объекта -->
 <div class="modal fade" id="updateObject" tabindex="-1" aria-labelledby="updateObjectTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="updateObjectTitle"></h1>
                <form class="deleteForm" action="/object/delete" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_object" name="id_delete" id="id_delete">
                    <button type="submit" class="btn btn-danger deleteButton">Удалить</button>
                </form>
            </div>
            <form class="mt-4" action="/object/update" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id_object" name="id" id="id">

                    <div class="mb-2">
                        <label for="code_adm" class="form-label">Район</label>
                        <select name="code_adm" id="code_adm" class="form-control">
                            <option value="20">Гомель</option>
                            <option value="30">Ветка</option>
                            <option value="32">Чечерск</option>
                            <option value="33">Добруш</option>
                            <option value="34">Жлобин</option>
                            <option value="36">Буда-Кошелево</option>
                            <option value="37">Корма</option>
                            <option value="39">Рогачев</option>
                            <option value="40">Речица</option>
                            <option value="42">Светлогорск</option>
                            <option value="44">Брагин</option>
                            <option value="45">Калинковичи</option>
                            <option value="46">Хойники</option>
                            <option value="47">Лоев</option>
                            <option value="50">Петриков</option>
                            <option value="51">Мозырь</option>
                            <option value="53">Житковичи</option>
                            <option value="54">Ельск</option>
                            <option value="55">Наровля</option>
                            <option value="56">Лельчицы</option>
                            <option value="57">Октябрьский</option>
                            <option value="79">Гомельский РУЭС</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="object_name">Название объекта</label>
                        <input type="text" class="form-control name_object" name="object_name" id="object_name" required>
                    </div>                    
                    
                    <div class="mb-2">
                        <label for="address">Адрес объекта</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="mb-2">
                        <label for="mount">Монтированая емкость</label>
                        <input type="text" class="form-control" id="mount" name="mount">
                    </div>

                    <div class="mb-2">
                        <label for="used">Задействованая емкость</label>
                        <input type="text" class="form-control" id="used" name="used">
                    </div>

                    <div class="mb-2">
                        <label for="power">Расчетная мощность</label>
                        <input type="text" class="form-control" id="power" name="power">
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

<!-- Modal добавление объекта -->
<div class="modal fade" id="addObject" tabindex="-1" aria-labelledby="addObjectTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="addObjectTitle">Добавить объект</h1>
            </div>
            <form class="mt-4" action="/object/add" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="code_adm" class="form-label">Район</label>
                        <select name="code_adm" id="code_adm2" class="form-control">
                            <option value="20">Гомель</option>
                            <option value="30">Ветка</option>
                            <option value="32">Чечерск</option>
                            <option value="33">Добруш</option>
                            <option value="34">Жлобин</option>
                            <option value="36">Буда-Кошелево</option>
                            <option value="37">Корма</option>
                            <option value="39">Рогачев</option>
                            <option value="40">Речица</option>
                            <option value="42">Светлогорск</option>
                            <option value="44">Брагин</option>
                            <option value="45">Калинковичи</option>
                            <option value="46">Хойники</option>
                            <option value="47">Лоев</option>
                            <option value="50">Петриков</option>
                            <option value="51">Мозырь</option>
                            <option value="53">Житковичи</option>
                            <option value="54">Ельск</option>
                            <option value="55">Наровля</option>
                            <option value="56">Лельчицы</option>
                            <option value="57">Октябрьский</option>
                            <option value="79">Гомельский РУЭС</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="name">Название объекта</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>                    
                    
                    <div class="mb-2">
                        <label for="address">Адрес объекта</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="mb-2">
                        <label for="mount">Монтированая емкость</label>
                        <input type="text" class="form-control" id="mount" name="mount" value="0">
                    </div>

                    <div class="mb-2">
                        <label for="used">Задействованая емкость</label>
                        <input type="text" class="form-control" id="used" name="used" value="0">
                    </div>

                    <div class="mb-2">
                        <label for="power">Расчетная мощность</label>
                        <input type="text" class="form-control" id="power" name="power" value="0">
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

<!-- Modal примечание -->
<div class="modal fade" id="remark" tabindex="-1" aria-labelledby="remarkTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="remarkTitle"></h1>
            </div>
            <form class="mt-4" action="/object/remark" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <div class="mb-2">
                        <h4>Примечание</h4>
                    </div>
                    <input type="hidden" class="id_object_remark" name="id" id="id_remark">
                    <input type="hidden" class="code_adm_remark" name="code_adm" id="code_adm_remark">
                    <div class="mb-3">
                        <textarea class="form-control" name="remark" id="remark" style="resize: none; height: 10rem;"></textarea>
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

<!-- Modal фильтр -->
<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Фильтр по объектам</h1>
            </div>
            <form class="" action="./filter" method="get" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" name="filter_object" value="1">
                    <div class="">
                        <label for="code_adm" class="form-label">Район</label>
                        <select name="code_adm" id="code_adm" class="form-control">
                            <option value="0" selected>Все</option>
                            <option value="20">Гомель</option>
                            <option value="30">Ветка</option>
                            <option value="32">Чечерск</option>
                            <option value="33">Добруш</option>
                            <option value="34">Жлобин</option>
                            <option value="36">Буда-Кошелево</option>
                            <option value="37">Корма</option>
                            <option value="39">Рогачев</option>
                            <option value="40">Речица</option>
                            <option value="42">Светлогорск</option>
                            <option value="44">Брагин</option>
                            <option value="45">Калинковичи</option>
                            <option value="46">Хойники</option>
                            <option value="47">Лоев</option>
                            <option value="50">Петриков</option>
                            <option value="51">Мозырь</option>
                            <option value="53">Житковичи</option>
                            <option value="54">Ельск</option>
                            <option value="55">Наровля</option>
                            <option value="56">Лельчицы</option>
                            <option value="57">Октябрьский</option>
                            <option value="79">Гомельский РУЭС</option>
                        </select>
                    </div>
                    <div class="">
                        <label for="object_name">Название объекта</label>
                        <input class="form-control" type="text" name="object_name" id="object_name">
                    </div> 
                    <div class="">
                        <label for="landlord">Арендодатель</label>
                        <input class="form-control" type="text" name="landlord" id="landlord">
                    </div>                   
                    <div class="">
                        <label for="contract_num">Номер договора</label>
                        <input class="form-control" type="text" name="contract_num" id="contract_num">
                    </div>
                    <div class="">
                        <label for="area">Арендуемая площадь</label>
                        <input class="form-control" type="text" name="area" id="area">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="object_filter" id="dataFilter">
                        <label class="form-check-label" for="dataFilter">
                            Неполные данные по объекту
                        </label>
                    </div>     
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="device_filter" id="deviceFilter">
                        <label class="form-check-label" for="deviceFilter">
                            Нет оборудования на объекте
                        </label>
                    </div>   
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="counter_filter" id="counterFilter">
                        <label class="form-check-label" for="counterFilter">
                            Нет счетчиков
                        </label>
                    </div>                                                                         
                    <div>
                        <label for="sort">Сортировать по...</label>
                        <select name="sort" id="sort"  class="form-control">
                            <option value="object_name">По названию &#8593</option>
                            <option value="object_name desc">По названию &#8595</option>
                            <option value="address">По адресу &#8593</option>
                            <option value="address desc">По адресу &#8595</option>
                            <option value="used">По емкости &#8593</option>
                            <option value="used desc">По емкости &#8595</option>
                            <option value="object_power">По мощности &#8593</option>
                            <option value="object_power desc">По мощности &#8595</option>                            
                            <option value="code_adm">По району &#8593</option>                            
                            <option value="code_adm desc">По району &#8595</option>                            
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success" onclick="load()">Применить</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Обработка кнопки вызова модального окна -->
<script type="text/javascript">
    const updateObject = document.getElementById('updateObject')
    if (updateObject) {
        updateObject.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id');
        const objectName = button.getAttribute('data-bs-name');
        const rues = button.getAttribute('data-bs-rues');
        const address = button.getAttribute('data-bs-address');
        const mount = button.getAttribute('data-bs-mount');
        const used = button.getAttribute('data-bs-used');
        const power = button.getAttribute('data-bs-power');
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const idObject = updateObject.querySelector('#id');
        const idObjectDelete = updateObject.querySelector('#id_delete');
        const title = updateObject.querySelector('.modal-title');
        const objectNameInput = updateObject.querySelector('.name_object');
        const modalBodyInput2 = updateObject.querySelector('.id_object');
        const objectAddress = updateObject.querySelector('#address');
        const objectMount = updateObject.querySelector('#mount');
        const objectUsed = updateObject.querySelector('#used');
        const objectPower = updateObject.querySelector('#power');

        idObject.value = id;
        idObjectDelete.value = id;
        title.textContent = objectName;
        objectNameInput.value = objectName;
        objectAddress.value = address;
        objectMount.value = mount || 0;
        objectUsed.value = used || 0;
        objectPower.value = Number(power).toFixed(3) || 0;

        const select = updateObject.querySelector('#code_adm').getElementsByTagName('option');

        for(let i = 0; i < select.length; i++) {
            if( select[i].text.toLowerCase() === rues.toLowerCase()) select[i].selected = true
        }
        })   
    }
    const addArenda = document.getElementById('addArenda')
    if(addArenda) {
        addArenda.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const id_object = button.getAttribute('id-obj');
            const object_name = button.getAttribute('obj-name');

            const idObject = addArenda.querySelector('#id_object');
            const title = addArenda.querySelector('#addArendaTitle');

            idObject.value = id_object;
            title.textContent = object_name;
        })
    }

    const addObject = document.getElementById('addObject')
    if(addObject) {
        addObject.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const rues = button.getAttribute('code-adm');
            const select = addObject.querySelector('#code_adm2').getElementsByTagName('option');

            for(let i = 0; i < select.length; i++) {
                if( select[i].text.toLowerCase() === rues.toLowerCase()) select[i].selected = true
            }
            
        })
    }
    const remark = document.getElementById('remark')
    if(remark) {
        remark.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const object_name = button.getAttribute('obj-name');
            const id_object = button.getAttribute('id');            
            const remarkObj = button.getAttribute('remark');
            const code_adm = button.getAttribute('code_adm');

            const title = remark.querySelector('#remarkTitle');
            const idObject = remark.querySelector('#id_remark');
            const objRemark = remark.querySelector('#remark');
            const codeObj = remark.querySelector('#code_adm_remark')
            title.textContent = object_name;
            idObject.value = id_object;
            objRemark.value = remarkObj; 
            codeObj.value = code_adm;          
        })
    }
</script>



<!-- Modal фильтр -->
<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Фильтр по договорам</h1>
            </div>
            <form class="mt-4" action="/filter" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" name="filter_arenda" value="1">
                    <div class="mb-2">
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
                    <div class="mb-3">
                        <label for="contract_num">Номер договора</label>
                        <input class="form-control" type="text" name="contract_num" id="contract_num">
                    </div>
                    <div class="mb-3">
                        <label for="equip_address">Местонахождение имущества (адрес, здание, учреждение)</label>
                        <input class="form-control" type="text" name="equip_address" id="equip_address">
                    </div>
                    <div class="mb-3">
                        <label for="landlord_area">Арендуемая площадь, м.кв.</label>
                        <input class="form-control" type="text" name="landlord_area" id="landlord_area">
                    </div>
                    <div class="mb-3">
                        <input class="form-check-input" type="radio" name="data" value="1" id="dataFilter">
                        <label class="form-check-label" for="dataFilter">
                            Нет привязки к объекту
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="sort">Сортировать по...</label>
                        <select name="sort" id="sort"  class="form-control">
                            <option value="contract_num">По номеру договора &#8593</option>
                            <option value="contract_num desc">По номеру договора &#8595</option>
                            <option value="equip_address">По адресу &#8593</option>
                            <option value="equip_address desc">По адресу &#8595</option>
                            <option value="landlord_area">По площади &#8593</option>
                            <option value="landlord_area desc">По площади &#8595</option>
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
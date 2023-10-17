<!-- Modal фильтр -->
<div class="modal fade" id="filterAnaliz" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Удельное потребление эл.энергии</h1>
            </div>
            <form class="mt-4 date" action="./analisData" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="choice" value="1">
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
                        <label for="object_name">Название объекта</label>
                        <input class="form-control" type="text" name="object_name" id="object_name">
                    </div>                    
                    <div class="mb-3">
                        <label for="dateFrom">Дата:</label>
                        <input class="form-control" type="month" id="dateFrom" name="dateFrom" required>
                    </div> 
                    <div class="mb-3">
                        <label for="dateTo">Дата:</label>
                        <input class="form-control" type="month" id="dateTo" name="dateTo" required>
                    </div>                                                                     
                    <div class="mb-3">
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
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success check-date" data-bs-dismiss="modal">Применить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal фильтр -->
<div class="modal fade" id="filterAnalizProc" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Удельное потребление эл.энергии</h1>
            </div>
            <form class="mt-4" action="./analisData" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="choice" value="2">
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
                        <label for="object_name">Название объекта</label>
                        <input class="form-control" type="text" name="object_name" id="object_name">
                    </div>                    
                    <div class="mb-3">
                        <label for="date">Дата:</label>
                        <input class="form-control" type="month" id="date" name="date" required>
                    </div>                                                                       
                    <div class="mb-3">
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
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Применить</button>
                </div>
            </form>
        </div>
    </div>
</div>
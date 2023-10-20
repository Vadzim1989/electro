<!-- Modal фильтр -->
<div class="modal fade" id="filterAnaliz" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Удельное потребление эл.энергии</h1>
            </div>
            <form action="./analisData" method="post" enctype="multipart/form-data">    
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
                        <label for="date">Дата:</label>
                        <input class="form-control" type="month" id="date" name="date" required>
                    </div>   
                    <div>
                        <label for="sort">Сортировать по...</label>
                        <select name="sort" id="sort"  class="form-control">
                            <option value="obj.object_name">По названию &#8593</option>
                            <option value="obj.object_name desc">По названию &#8595</option>                           
                            <option value="obj.code_adm">По району &#8593</option>                            
                            <option value="obj.code_adm desc">По району &#8595</option> 
                            <option value="udel">По уд.потреблению &#8593</option>                             
                            <option value="udel desc">По уд.потреблению &#8595</option>                            
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

<!-- Modal фильтр -->
<div class="modal fade" id="filterAnalizProc" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Расхождение показаний по электроэнергии</h1>
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
                    <div>
                        <label for="sort">Сортировать по...</label>
                        <select name="sort" id="sort"  class="form-control">
                            <option value="obj.object_name">По названию &#8593</option>
                            <option value="obj.object_name desc">По названию &#8595</option>                           
                            <option value="obj.code_adm">По району &#8593</option>                            
                            <option value="obj.code_adm desc">По району &#8595</option>                            
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


<!-- Modal фильтр -->
<div class="modal fade" id="filterAnalizArenda" tabindex="-1" aria-labelledby="filterTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterTitle">Арендуемые объекты</h1>
            </div>
            <form class="mt-4" action="./analisData" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <div>
                        <input type="hidden" name="choice" value="3">
                        <label for="sort">Сортировать по...</label>
                        <select name="sort" id="sort"  class="form-control">
                            <option value="object_name">По названию &#8593</option>
                            <option value="object_name desc">По названию &#8595</option>                           
                            <option value="obcal.name">По району &#8593</option>                            
                            <option value="obcal.name desc">По району &#8595</option> 
                            <option value="landlord_area">По площади &#8593</option>                            
                            <option value="landlord_area desc">По площади &#8595</option> 
                            <option value="byn">По арендной плате &#8593</option>                            
                            <option value="byn desc">По арендной плате &#8595</option>                             
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
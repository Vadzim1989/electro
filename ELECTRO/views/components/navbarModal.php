<!-- Modal загрузки XML -->
<div class="modal fade" id="addXML" tabindex="-1" aria-labelledby="addDeviceTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addXMLTitle"></h1>
            </div>
            <form class="mt-4" action="./xml/load" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="file" name="xml" id="xml">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Новости -->
<div class="modal fade" id="news" tabindex="-1" aria-labelledby="newsTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newsTitle">Справка</h1>
            </div>
            <form class="mt-4" action="./news/load" method="post">    
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                            require('vendor/db.php');
                            $news = mysqli_query($db, "SELECT `news` FROM `news`");
                            $news = mysqli_fetch_assoc($news);
                            if(!isset($news)){
                                $news = '';
                            } else {
                                $news = $news['news'];
                            }

                            if($_SESSION['user']['group'] == 2 || $_SESSION['user']['group'] == 3){
                                echo '<textarea class="form-control" style="resize:none;" name="news" id="news" cols="30" rows="10">'.$news.'</textarea>';
                            } elseif($_SESSION['user']['group'] == 1) {
                                echo '<textarea class="form-control" style="resize:none;" readonly name="news" id="news" cols="30" rows="10">'.$news.'</textarea>';
                            }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <?php 
                    if($_SESSION['user']['group'] == 2 || $_SESSION['user']['group'] == 3) {
                        echo '<button type="submit" class="btn btn-success">Сохранить</button>';
                    }                   
                    ?>
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
                <h1 class="modal-title fs-5" id="filterTitle">Фильтр по договорам</h1>
            </div>
            <form class="mt-4" action="./filter" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" name="filter_arenda" value="1">
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
                        <label for="sort">Сортировать по...</label>
                        <select name="sort" id="sort"  class="form-control">
                            <option value="contract_num">По номеру договора &#8593</option>
                            <option value="contract_num desc">По номеру договора &#8595</option>
                            <option value="equip_address">По адресу &#8593</option>
                            <option value="equip_address">По адресу &#8595</option>
                            <option value="landlord_area">По площади &#8593</option>
                            <option value="landlord_area">По площади &#8595</option>
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
<script src="/ELECTRO/assets/js/bootstrap.min.js"></script>

<!-- Обработка кнопки вызова модального окна СЧЕТЧИКА -->
<script type="text/javascript">
    const addXML = document.getElementById('addXML');
    if(addXML) {
        addXML.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            const objectName = addXML.querySelector('#addXMLTitle');

            objectName.textContent = "Загрузите XML-файл";
        })
    };
</script>
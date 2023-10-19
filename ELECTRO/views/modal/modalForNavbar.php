<!-- Modal Новости -->
<div class="modal fade" id="news" tabindex="-1" aria-labelledby="newsTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newsTitle">Уведомления</h1>
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

                            if($_SESSION['user']['group'] == 2){
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
                    if($_SESSION['user']['group'] == 2) {
                        echo '<button type="submit" class="btn btn-success">Сохранить</button>';
                    }                   
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
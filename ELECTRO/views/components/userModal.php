<!-- Modal правки счетчика -->
<div class="modal fade" id="updateUser" tabindex="-1" aria-labelledby="updateUserTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="updateUserTitle">Информация по пользователю</h1>
            </div>
            <form class="mt-4" action="./auth/userInfo" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id" name="id" id="id">
                    
                    <label for="name" class="form-label">ФИО</label>
                    <input type="text" class="form-control" id="name" name="name">

                    <label for="login" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login">

                    <label for="code_adm" class="form-label">Районы</label>
                    <select class="form-control" name="code_adm" id="code_adm">
                        <option value="all">Все</option>
                        <option value="gomel">Гомель</option>
                        <option value="gomelzues">Гомельский ЗУЭС</option>
                        <option value="jlobin">Жлобинский ЗУЭС</option>
                        <option value="kalin">Калинковичский ЗУЭС</option>
                        <option value="mozir">Мозырский ЗУЭС</option>
                        <option value="rech">Речицкий ЗУЭС</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>                    
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    const updateUser = document.getElementById('updateUser');
    if (updateUser) {
        updateUser.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('id');
        const name = button.getAttribute('name');
        const login = button.getAttribute('login');
        const code_adm = button.getAttribute('zues');
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const userID = updateUser.querySelector('#id');
        const userName = updateUser.querySelector('#name');
        const userLogin = updateUser.querySelector('#login');
        const userCodeAdm = updateUser.querySelector('#code_adm');


        userID.value = id;
        userName.value = name;
        userLogin.value = login;
        userCodeAdm.value = code_adm;

        const select = updateUser.querySelector('#code_adm').getElementsByTagName('option');

        for(let i = 0; i < select.length; i++) {
        if( select[i].text.toLowerCase() === code_adm.toLowerCase()) select[i].selected = true
        }
    })
    };
</script>
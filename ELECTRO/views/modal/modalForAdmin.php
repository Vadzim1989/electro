<!-- Modal правки пользователя -->
<div class="modal fade" id="updateUserInfo" tabindex="-1" aria-labelledby="updateUserInfoTitle" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">            
            <div class="modal-header d-flex flex-row justify-content-between">
                <h1 class="modal-title fs-5" id="updateUserInfoTitle">Редактирование информации по пользователю</h1>
            </div>
            <form class="mt-4" action="./auth/userInfo" method="post" enctype="multipart/form-data">    
                <div class="modal-body">
                    <input type="hidden" class="id" name="id" id="id">
                    
                    <label for="name" class="form-label">ФИО</label>
                    <input type="text" class="form-control" id="name" name="name">

                    <label for="login" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login">
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
    const updateUserInfo = document.getElementById('updateUserInfo');
    if (updateUserInfo) {
        updateUserInfo.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('id');
        const name = button.getAttribute('name');
        const login = button.getAttribute('login');
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const userID = updateUserInfo.querySelector('#id');
        const userName = updateUserInfo.querySelector('#name');
        const userLogin = updateUserInfo.querySelector('#login');


        userID.value = id;
        userName.value = name;
        userLogin.value = login;
    })
    };
</script>
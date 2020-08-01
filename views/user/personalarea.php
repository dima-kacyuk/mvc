<link rel="stylesheet" href="../../web/css/style.css">
<div class="container">
    <div class="personal-area-block">
        <h2>Добро пожаловать, <?=$_SESSION['username'];?>!</h2>
        <form action="?test=user/logout" method="post">
            <input type="submit" value="Выход">
        </form>
        <br>
        <form action="?test=user/parse" method="post">
            <?php
                if(!empty($_SESSION['username']) && $_SESSION['id'] == 1){
                    echo '<input type="submit" value="Обновить новости">';
                }
            ?>
        </form>
    </div>
</div>
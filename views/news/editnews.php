<link rel="stylesheet" href="../../web/css/style.css">
<div class="container">
    <div class="news-editor-box">
        <?php foreach ($data as $id => $post) : ?>
        <form action="?test=news/edit&id=<?=$post['id'];?>" method="post" enctype="multipart/form-data">
                <p>Картинка:</p>
                <img class="img_h" src="../../web/images/<?=$post['image'];?>"><br><br>
                <p>Изменить картинку:
                <input type="file" name="file_upload"></p><br>
                <p>Заголовок:</p>
                <input type="text" name="title" style="height: 30px; width: 800px" value="<?=trim($post['title']);?>"><br><br>
                <p>Описание:</p>
                <textarea name="description" style="height: 570px; width: 800px" cols="30" rows="10"><?=$post['description'];?></textarea>
                <br><br>
                <p>Дата: <?php $date = date_create($post['date']); $view_date = date_format($date, 'd.m.Y H:i'); echo $view_date;?></p>
                <input type="datetime-local" name="date">
            <?php endforeach ?>
            <br><br>
            <input type="submit" value="Сохранить изменения">
            <a href="?test=news/allnews"><input type="button" value="Назад"></a>
        </form>
    </div>
</div>

<link rel="stylesheet" href="../../web/css/style.css">
<div class="container">
    <?php foreach ($data as $id => $post) : ?>
        <div class="single-news-block">
            <img class="img_h" src="../../web/images/<?=$post['image'];?>">
            <h3><?=$post['title'];?></h3>
            <p><?=$post['description'];?></p>
            <p><?php $date = date_create($post['date']); $view_date = date_format($date, 'd.m.Y H:i'); echo $view_date;?></p>
            <br>
            <a href="?test=news/allnews"><input type="button" value="Назад"></a>
        </div>
    <?php endforeach ?>
</div>
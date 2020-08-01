<link rel="stylesheet" href="../../web/css/style.css">
<div class="container">
    <div class="search_news">
        <form action="?test=news/search" method="post">
            <input type="text" name="searchTitle" placeholder="Поиск по заголовку">
            <input type="submit" value="Поиск">
        </form>
    </div>
    <div class="all-news-block">
        <?php foreach ($data['result'] as $id => $post) : ?>
            <div class="news_block">
                <img class="img_h" src="../../web/images/<?=$post['image'];?>">
                <br>
                <a href="?test=news/singlenews&id=<?=$post['id'];?>"><h3><?=$post['title'];?></h3></a>
                <br>
                <p><?=mb_strimwidth($post['description'], 0, 350, "...");?></p>
                <br>
                <p><?php $date = date_create($post['date']); $view_date = date_format($date, 'd.m.Y H:i'); echo $view_date;?></p>
                <br>
                <a href="?test=news/editnews&id=<?=$post['id'];?>"><input type="button" value="Редактировать"></a>
                <a href="?test=news/deletenews&id=<?=$post['id'];?>"><input type="button" value="Удалить"></a>
                <br><br>
                <hr>
            </div>
        <?php endforeach ?>
    </div>
    <p><?=$data['empty']?></p>
    <div class="pagination">
        <?php
        //var_dump($date['pageNumbers']);
        for($page = 1; $page<= $data['pageNumbers']; $page++) {
            echo '<a href = "?test=news/allnews&page=' . $page . '">' . $page . ' </a>';
        }
        ?>
    </div>
</div>

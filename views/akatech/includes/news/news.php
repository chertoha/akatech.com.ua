<?php defined('AKATECH') or die('Access Denied'); ?>


<?php foreach ($arr_news_overview['news'] as $news):?>

<div class="col-md-12" id="main_news">	
    <div class="col-md-4 ">
        <img src="<?=TEMPLATE?>images/news/<?=$news['news_img_url']?>" class="img-responsive" alt="<?=$news['news_title']?>">
    </div>
    <div class="col-md-8 text-left">
        <h3><?=$news['news_title']?></h3>
        <p><?=$news['news_text']?></p>							
    </div>
    <div class="footer_news">
        <div class="news_info">
            <div class="col-md-5 text-left col-xs-7">
                <span style="margin: 0 10px 0 0;"><i class="news_date"></i><?=$news['news_date']?></span>
                <span><i class="news_autor"></i><?=$news['news_author']?></span>
            </div>
            <div class="col-md-7 text-right col-xs-5">
                <a class="btn_more" href="?view=news_details&news_id=<?=$news['news_id']?>" role="button">+ Читать полностью</a>
            </div>
        </div>
    </div>						
</div>

<?php endforeach;?>


<ul class="pagination">
        
    <?php // <<  >>  
    $prev_disabled = '';
    $next_disabled = '';
    $prev_href = '?view=news&page='.($arr_news_overview['current_page'] - 1);
    $next_href = '?view=news&page='.($arr_news_overview['current_page'] + 1);
    if ($arr_news_overview['current_page'] == 1){
        $prev_disabled = 'disabled';
        $prev_href = 'javascript: void(0)';
    }       
    if ($arr_news_overview['current_page'] == $arr_news_overview['count_pages']){
        $next_disabled = 'disabled';
        $next_href = 'javascript: void(0)';
    }
    ?>
    
    <li class="page-item <?=$prev_disabled?>">
        <a class="page-link" href="<?=$prev_href?>" tabindex="-1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    
       
    <?php for ($i = $arr_news_overview['limits']['start']; $i <= $arr_news_overview['limits']['end']; $i++):?>        
        <?php $active_item = ($arr_news_overview['current_page'] == $i) ? 'active' : '' ;?>
        <?php $news_href = ($i == 1) ? "?view=news" : "?view=news&page=$i"; ?>
        <li class="page-item <?=$active_item?>"><a class="page-link" href="<?=$news_href?>"><?=$i?></a></li>
    
    <?php endfor;?>
    
        
    <li class="page-item <?=$next_disabled?>">
        <a class="page-link" href="<?=$next_href?>" aria-label="Next" >
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
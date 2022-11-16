<?php defined('AKATECH') or die('Access Denied'); ?>

<div id="wrapper_2" >
    <!--<h2>Альбомы  АКАТЕХ ГРУП</h2>-->
    <h2>Альбоми  АКАТЕХ ГРУП</h2>

    <div id="main_gallery">
        
        <?php foreach ($gallery_albums as $album_id => $album) :?>
        
            <?php $count_images = 0; ?>
            <div class="col-md-6 ">
                <?php foreach ($album['images'] as $image_id => $image) : ?>    
                    
                    
                    <!-- Chertok Edit, when Rosta asked to remove their product from our website-->
                    <?php if ($album['album_descriptor'] == 'rosta') continue;?>    
                        
                        
                    <?php if ($count_images === 0) : ?>

                        <a title="<?= strip_tags ($album['album_name']) ?>" href="<?= TEMPLATE ?>images/gallery/<?= $album['album_descriptor'] ?>/<?= $image['image_url'] ?>" data-lightbox-gallery="<?= $album['album_descriptor'] ?>" data-lightbox-hidpi="<?= TEMPLATE ?>images/gallery/<?= $album['album_descriptor'] ?>/<?= $image['image_url'] ?>" >
                            <img class="gallery img-responsive" src="<?= TEMPLATE ?>images/gallery/<?= $album['album_image_url'] ?>"  alt="<?= $album['album_name'] ?>">
                            <h3><?= $album['album_name'] ?></h3>
                        </a>

                        <?php $count_images++; ?>
                    <?php else: ?>
                        <?php $image_title = ($image['image_title'] != '') ? $image['image_title']  : $album['album_name'] ;?>
                        <a hidden title="<?= strip_tags($image_title) ?>" href="<?= TEMPLATE ?>images/gallery/<?= $album['album_descriptor'] ?>/<?= $image['image_url'] ?>" data-lightbox-gallery="<?= $album['album_descriptor'] ?>" data-lightbox-hidpi="<?= TEMPLATE ?>images/gallery/<?= $album['album_descriptor'] ?>/<?= $image['image_url'] ?>" >
                        </a>            
                    <?php endif; ?>       
                <?php endforeach; ?>
            </div> 
        <?php endforeach;?>        

    </div>

</div>




















<!--<div id="wrapper_2" >
    <h2>Альбомы  АКАТЕХ ГРУП</h2>
    
<?php foreach ($gallery_albums as $album): ?>
        <div class="col-md-6 ">
            <a href="">
                <img class="gallery" src="<?= TEMPLATE ?>images/gallery/<?= $album['album_image_url'] ?>" class="img-responsive" alt="<?= $album['album_name'] ?>">
                <h3><?= $album['album_name'] ?></h3>
            </a>
        </div>
        
        
        
     
        
<?php endforeach; ?>
   

</div>-->


<script type="text/javascript">
	/*====================================
	Nivo Lightbox 
	======================================*/
	// Agency Portfolio Popup
		$('#main_gallery a').nivoLightbox({
			effect: 'slideDown',  
			keyboardNav: true,
			
		});

		$(document).ready(function() {	 
		  $("#owl-demo").owlCarousel({	 
				navigation : false, // Show next and prev buttons
				slideSpeed : 300,
				paginationSpeed : 400,
				singleItem:true		 
				// "singleItem:true" is a shortcut for:
				// items : 1, 
				// itemsDesktop : false,
				// itemsDesktopSmall : false,
				// itemsTablet: false,
				// itemsMobile : false	 
			});
		});
	</script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');

	if (empty($_GET)) {
		header('Location: ../');
	}

?>

<!doctype html><head>
    <meta charset="UTF-8">
    <title>Новости | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
    
        <section class="content">
            <div class="inner">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
                <!-- Postcart -->
                <section class="postcard-content group">
                    <div class="postcard-corener pc-l-t"></div>
                    <div class="postcard-corener pc-r-t"></div>
                    <div class="postcard-corener pc-l-b"></div>
                    <div class="postcard-corener pc-r-b"></div>
                    <article class="text-content-inner group">
                        <div class="information-part group">
                        <?php
							include($_SERVER['DOCUMENT_ROOT'].'/include/news/'.key($_GET).'.php');
						?>
                        </div>
                    </article>
                </section>

            </div><!-- inner -->
        </section><!-- content -->
        
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
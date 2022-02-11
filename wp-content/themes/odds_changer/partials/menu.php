<?php $home_url = get_home_url() ?>
<div class="top-bar">
    <div class="logo">
        <a href="<?= $home_url ?>">
        <img src="<?= get_template_directory_uri() . '/src/assets/logo.jpg'?>" width="200px" height="80px" alt="logo alt"/>
        </a>
    </div>


    <nav class="navMenu">
        <a href="<?= $home_url ?>">Home</a>
    </nav>
</div>

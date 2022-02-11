<?php get_header();

$post_id = get_the_ID();

$title = get_field('home_team', $post_id) . " VS " . get_field('away_team', $post_id);

?>

<div class="content">
    <h1><?= $title ?></h1>

    <?php
    require_once("template_parts/block-partner_odds_list/block-partner_odds_list.php");
   ?>
</div>
<?php get_footer() ?>

<?php get_header();

$post = get_post();
$content = get_the_content();

$title = get_field('home_team', $post->ID) . " VS " . get_field('away_team', $post->ID);

?>

<div class="content">
    <h1><?= $title ?></h1>

    <?php
    //put up here since this is part of the template
    require_once("template_parts/block-partner_odds_list/block-partner_odds_list.php");

    //rest of content goes below
    if (has_blocks($content)) {
        //getting post content and generating content per block
        $blocks = parse_blocks($post->post_content);
        include(get_template_directory() . "/blocks/block-generator.php");

    } ?>
</div>
<?php get_footer() ?>

<?php get_header();

$post = get_post();
$content = get_the_content();
?>

<div class="content">
    <?php
    if (has_blocks($content)) {
        //getting post content and generating content per block
        $blocks = parse_blocks($post->post_content);
        include(get_template_directory() . "/blocks/block-generator.php");

    }?>
</div>

<?php get_footer() ?>

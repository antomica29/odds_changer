<?php

$post_id = get_the_ID();

$show_all = get_field('show_all');
$choose_matches = get_field('choose_matches');

$posts = array();

if ($show_all) {
    $args = array(
        'post_type' => 'matches',
    );

    $posts = get_posts($args);
} else {
    for ($i = 0; $i < count($choose_matches); $i++) {
        $post = get_post($choose_matches[$i]);
        array_push($posts, $post);
    }
}

for ($i = 0; $i < count($posts); $i++) {

    $title = get_field('home_team', $posts[$i]->ID) . " VS " . get_field('away_team', $posts[$i]->ID);
    $sites = get_field('sites', $posts[$i]->ID);

    $best_home_name = "";
    $best_home = 0;
    $best_draw_name = "";
    $best_draw = 0;
    $best_away_name = "";
    $best_away = 0;

    for ($j = 0; $j < count($sites); $j++) {

        //iterate also odds_type, but gonna hard code it
        if($sites[$j]['odds'][0]['home_odds'] > $best_home){
            $best_home_name = $sites[$j]['site_nice'];
            $best_home = $sites[$j]['odds'][0]['home_odds'];
        }

        if($sites[$j]['odds'][0]['draw_odds'] > $best_draw){
            $best_draw_name = $sites[$j]['site_nice'];
            $best_draw = $sites[$j]['odds'][0]['draw_odds'];
        }

        if($sites[$j]['odds'][0]['away_odds'] > $best_away){
            $best_away_name = $sites[$j]['site_nice'];
            $best_away = $sites[$j]['odds'][0]['away_odds'];
        }
    }

    $home_partner_nice = $best_home_name;
    $draw_partner_nice = $best_draw_name;
    $away_partner_nice = $best_away_name;
    $odds_type = $sites[0]['odds'][0]['odds_type'];
    $odds_home = $best_home;
    $odds_draw = $best_draw;
    $odds_away = $best_away;

    ?>

    <div class="match_row">
        <span class="match_row__odds_type"><?= $odds_type ?></span>
        <a href="<?= get_permalink($posts[$i]->ID) ?>">
            <div class="match_row__title">
                <?= $title ?>
            </div>
        </a>
        <div class="match_row__odds_row">
            <div class="match_row__odds_row_container">
                <div class="match_row__odds_row_partner">
                    <?= $home_partner_nice ?>
                </div>
                <div class="match_row__odds_row_odds odds">
                    <?= $odds_home ?>
                </div>
                <div class="match_row__odds_row_team">
                    home
                </div>
            </div>
            <div class="match_row__odds_row_container">
                <div class="match_row__odds_row_partner">
                    <?= $draw_partner_nice ?>
                </div>
                <div class="match_row__odds_row_odds odds">
                    <?= $odds_draw ?>
                </div>
                <div class="match_row__odds_row_team">
                    draw
                </div>
            </div>
            <div class="match_row__odds_row_container">
                <div class="match_row__odds_row_partner">
                    <?= $away_partner_nice ?>
                </div>
                <div class="match_row__odds_row_odds odds">
                    <?= $odds_away ?>
                </div>
                <div class="match_row__odds_row_team">
                    away
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php
}
?>

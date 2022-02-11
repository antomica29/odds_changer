<?php
//enquing scripts and styles for project
function project_enqueue_script()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/dist/style.css');
    wp_enqueue_script('script', get_template_directory_uri() . '/src/script.js');

    //these should be handled via a webpack isntallation
    wp_enqueue_style('show_matches', get_template_directory_uri() . '/blocks/show_matches/show_matches.css');
    wp_enqueue_style('partner_odds_list_style', get_template_directory_uri() . '/template_parts/block-partner_odds_list/block-partner_odds_list.css');
    wp_enqueue_script('partner_odds_list_script', get_template_directory_uri() . '/template_parts/block-partner_odds_list/block-partner_odds_list.js');
}

add_action('wp_enqueue_scripts', 'project_enqueue_script');

//registering CPTs
function register_custom_post_type()
{
    //registering matches CPT
    register_post_type('matches',
        array(
            'labels' => array(
                'name' => 'Matches',
                'singular_name' => 'Match',
            ),
            'public' => true,
            'has_archive' => false,
        )
    );
}

add_action('init', 'register_custom_post_type');

//adding guttenberg block via ACF
add_action('acf/init', 'my_acf_blocks_init');
function my_acf_blocks_init()
{

    // Check function exists.
    if (function_exists('acf_register_block_type')) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name' => 'show_matches',
            'title' => __('Show Matches'),
            'description' => __('Block to show matches'),
            'render_template' => 'blocks/show_matches/block-show_matches.php',
            'enqueue_assets' => function () {
                wp_enqueue_style('show_matches', get_template_directory_uri() . '/blocks/show_matches/show_matches.css');
            }
        ));
    }
}

//adding a cron time schedule
add_filter('cron_schedules', 'fetch_api_cron');
function fetch_api_cron($schedules)
{
    $schedules['fetch_api_five_mins'] = array(
        'interval' => 60 * 5,
        'display' => 'Every 5 Minutes'
    );
    return $schedules;
}

//if cron is not scheduled, schedule it and give it new time shcedule created
if (!wp_next_scheduled('fetch_api_cron')) {
    wp_schedule_event(time(), 'fetch_api_five_mins', 'fetch_api_cron');
}

// Cron action that will fire every 5 minutes
add_action('fetch_api_cron', 'fetch_api');
function fetch_api()
{
    //fetch data via api and output as array in $response
    $url = 'http://localhost/wp-json/matches_data/v1/get_data/';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response_json = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response_json, true);

    //rendering $response data
    handle_response($response);
}

//registering API URL
add_action('rest_api_init', function () {
    register_rest_route('matches_data/v1', '/get_data/', array(
        'methods' => 'GET',
        'callback' => 'send_matches_data',
    ));
});
//basic return function of data
function send_matches_data()
{

    $JSON = '[
  {
    "game_id": "epl754743922",
    "data": {
      "sport_key": "soccer_epl",
      "sport_nice": "EPL",
      "teams": {
        "Home": "Chelsea",
        "Away": "Brighton"
      },
      "commence_time": 1540035000,
      "home_team": "Chelsea",
      "sites": [
        {
          "site_key": "unibet",
          "site_nice": "Unibet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "1.68",
              "draw": "5.50",
              "away": "4.05"
            }
          }
        },
        {
          "site_key": "williamhill",
          "site_nice": "WilliamHill",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "1.38",
              "draw": "5.00",
              "away": "5.05"
            }
          }
        },
        {
          "site_key": "twentytwobet",
          "site_nice": "22Bet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "1.78",
              "draw": "5.10",
              "away": "3.85"
            }
          }
        },
        {
          "site_key": "powerplaycom",
          "site_nice": "PowerPlay",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "1.75",
              "draw": "5.05",
              "away": "3.90"
            }
          }
        }
      ]
    }
  },
  {
    "game_id": "epl754741552",
    "data": {
      "sport_key": "soccer_epl",
      "sport_nice": "EPL",
      "teams": {
        "Home": "Liverpool",
        "Away": "Arsenal"
      },
      "commence_time": 1540035000,
      "home_team": "Chelsea",
      "sites": [
        {
          "site_key": "unibet",
          "site_nice": "Unibet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.00",
              "draw": "2.10",
              "away": "3.00"
            }
          }
        },
        {
          "site_key": "williamhill",
          "site_nice": "WilliamHill",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.05",
              "draw": "2.10",
              "away": "2.95"
            }
          }
        },
        {
          "site_key": "twentytwobet",
          "site_nice": "22Bet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.06",
              "draw": "2.15",
              "away": "2.90"
            }
          }
        },
        {
          "site_key": "powerplaycom",
          "site_nice": "PowerPlay",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.10",
              "draw": "2.00",
              "away": "2.80"
            }
          }
        }
      ]
    }
  },
  {
    "game_id": "epl754123522",
    "data": {
      "sport_key": "soccer_epl",
      "sport_nice": "EPL",
      "teams": {
        "Home": "Watford",
        "Away": "Tottenham"
      },
      "commence_time": 1540035000,
      "home_team": "Chelsea",
      "sites": [
        {
          "site_key": "unibet",
          "site_nice": "Unibet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "5.00",
              "draw": "3.10",
              "away": "1.30"
            }
          }
        },
        {
          "site_key": "williamhill",
          "site_nice": "WilliamHill",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "4.80",
              "draw": "3.00",
              "away": "1.50"
            }
          }
        },
        {
          "site_key": "twentytwobet",
          "site_nice": "22Bet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "4.98",
              "draw": "3.04",
              "away": "1.34"
            }
          }
        },
        {
          "site_key": "powerplaycom",
          "site_nice": "PowerPlay",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "5.03",
              "draw": "3.06",
              "away": "1.50"
            }
          }
        }
      ]
    }
  },
  {
    "game_id": "epl7582754922",
    "data": {
      "sport_key": "soccer_epl",
      "sport_nice": "EPL",
      "teams": {
        "Home": "Newcastle",
        "Away": "Everton"
      },
      "commence_time": 1540035000,
      "home_team": "Chelsea",
      "sites": [
        {
          "site_key": "unibet",
          "site_nice": "Unibet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.00",
              "draw": "2.55",
              "away": "2.30"
            }
          }
        },
        {
          "site_key": "williamhill",
          "site_nice": "WilliamHill",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.02",
              "draw": "2.58",
              "away": "2.37"
            }
          }
        },
        {
          "site_key": "twentytwobet",
          "site_nice": "22Bet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.10",
              "draw": "2.45",
              "away": "2.20"
            }
          }
        },
        {
          "site_key": "powerplaycom",
          "site_nice": "PowerPlay",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "1.94",
              "draw": "2.55",
              "away": "2.00"
            }
          }
        }
      ]
    }
  },
  {
    "game_id": "epl7548877322",
    "data": {
      "sport_key": "soccer_epl",
      "sport_nice": "EPL",
      "teams": {
        "Home": "Leeds United",
        "Away": "Wolves"
      },
      "commence_time": 1540035000,
      "home_team": "Chelsea",
      "sites": [
        {
          "site_key": "unibet",
          "site_nice": "Unibet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "3.10",
              "draw": "2.20",
              "away": "1.90"
            }
          }
        },
        {
          "site_key": "williamhill",
          "site_nice": "WilliamHill",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "2.95",
              "draw": "2.25",
              "away": "1.80"
            }
          }
        },
        {
          "site_key": "twentytwobet",
          "site_nice": "22Bet",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "3.12",
              "draw": "2.10",
              "away": "1.80"
            }
          }
        },
        {
          "site_key": "powerplaycom",
          "site_nice": "PowerPlay",
          "last_update": 1540020857,
          "odds": {
            "h2h": {
              "home": "3.70",
              "draw": "2.10",
              "away": "1.50"
            }
          }
        }
      ]
    }
  }
]';

    $JSON = json_decode($JSON);

    $response = new WP_REST_Response($JSON);
    $response->set_status(200);

    return $response;
}

//handling api/cron data
function handle_response($response)
{

    //looping response array to get matches and getting post via game_id
    for ($i = 0; $i < count($response); $i++) {
        $args = array(
            'post_type' => 'matches',
            'meta_key' => 'game_id',
            'meta_value' => $response[$i]['game_id']
        );

        $the_query = new WP_Query($args);

        //if match not found
        if ($the_query->have_posts() == 0) {
            //create new match
            $new_post = array(
                'post_title' => $response[$i]['data']['teams']['Home'] . " VS " . $response[$i]['data']['teams']['Away'] . " - " . $response[$i]['game_id'],
                'post_status' => 'publish',
                'post_date' => date('Y-m-d H:i:s'),
                'post_type' => 'matches',
            );
            $post_id = wp_insert_post($new_post);

            //grab newly created post id and update meta fields with data from API
            update_field('game_id', $response[$i]['game_id'], $post_id);
            update_field('sports_key', $response[$i]['data']['sport_key'], $post_id);
            update_field('sport_nice_name', $response[$i]['data']['sport_nice'], $post_id);
            update_field('home_team', $response[$i]['data']['teams']['Home'], $post_id);
            update_field('away_team', $response[$i]['data']['teams']['Away'], $post_id);
            update_field('commence_time', $response[$i]['data']['commence_time'], $post_id);

            //iterating sites array to insert data
            $sites = array();
            for ($j = 0; $j < count($response[$i]['data']['sites']); $j++) {

                //iterating odd type in site section (only h2h here)
                $odds = array();
                for ($k = 0; $k < count($response[$i]['data']['sites'][$j]['odds']); $k++) {

                    //getting key value as data
                    $key = array_keys($response[$i]['data']['sites'][$j]['odds']);

                    //inputting all data on odds in odds array
                    $odd = array(
                        'odds_type' => $key[$k],
                        'home_odds' => $response[$i]['data']['sites'][$j]['odds'][$key[$k]]['home'],
                        'draw_odds' => $response[$i]['data']['sites'][$j]['odds'][$key[$k]]['draw'],
                        'away_odds' => $response[$i]['data']['sites'][$j]['odds'][$key[$k]]['away']
                    );

                    //pushing all odds into odds array (only h2h here, but works)
                    array_push($odds, $odd);
                }

                //entering data for each site, including odds for current site in loop
                $site = array(
                    'site_key' => $response[$i]['data']['sites'][$j]['site_key'],
                    'site_nice' => $response[$i]['data']['sites'][$j]['site_nice'],
                    'last_update' => $response[$i]['data']['sites'][$j]['last_update'],
                    'odds' => $odds

                );

                //pushing all sites into sites array
                array_push($sites, $site);

            }
            //updating sites repeater with sites including odd for each
            update_field('sites', $sites, $post_id);

        } else {
            //if match already found, check and compare last_update. If different update post accordingly
        }
    }
}

//block output shortcode. Done here so if needed can handle things cleaner
function output_content($blockcontent)
{
    echo do_shortcode($blockcontent);
}

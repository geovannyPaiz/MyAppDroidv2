<?php
/**
 * Generate Reports
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

global $wpdb, $wp;
$date_range         = '';
$to_date            = date('Y-m-d 23:59:59');
$from_date          = date('Y-m-d 00:00:00', strtotime('-6 days'));
$chart_bottom_title = "1W";
$query_range        = 'day_wise';

if ( ! empty($_GET['date_range'])){
    $date_range = sanitize_text_field($_GET['date_range']);
    switch ($date_range){
        case 'last_7_days':
            $chart_bottom_title = "1W";
            $query_range        = 'day_wise';
            break;
        case 'last_14_days':
            $to_date            = date('Y-m-d 23:59:59');
            $from_date          = date('Y-m-01 00:00:00');
            $chart_bottom_title = "2W";
            $query_range        = 'day_wise';
            break;

        case 'this_month':
            $to_date            = date('Y-m-d 23:59:59');
            $from_date          = date('Y-m-01 00:00:00');
            $chart_bottom_title = "1M";
            $query_range        = 'day_wise';
            break;

        case 'last_3_months':
            $to_date            = date('Y-m-t 23:59:59', strtotime('-1 month'));
            $from_date          = date('Y-m-01 00:00:00', strtotime('-3 month'));
            $chart_bottom_title = "3M";
            $query_range        = 'month_wise';
            break;

        case 'last_6_months':
            $to_date            = date('Y-m-t 23:59:59', strtotime('-1 month'));
            $from_date          = date('Y-m-01 00:00:00', strtotime('-6 month'));
            $chart_bottom_title = "6M";
            $query_range        = 'month_wise';
            break;

        case 'this_year':
            $to_date            = date('Y-m-d 23:59:59');
            $from_date          = date('Y-01-01 00:00:00');
            $chart_bottom_title = "This Year (".date('Y').")";
            $query_range        = '1Y';
            break;
    }
}

if (! empty($_GET['date_range_from'])){
    $from_date      = sanitize_text_field($_GET['date_range_from']);
}
if (! empty($_GET['date_range_to'])){
    $to_date        = sanitize_text_field($_GET['date_range_to']);
}

$total_backers_amount_ever = array();
$from_time          = strtotime('-1 day', strtotime($from_date));
$to_time            = strtotime('-1 day', strtotime($to_date));
$sales_count_ever   = array();
$csv                = array();
$csv[]              = array("Date", "Pledge Amount ", "Sales");
$format             = array();
$label              = array();

$product_ids = get_products_ids_by_user();
$getting_order_ids_by_products = get_orders_ids_by_product_ids($product_ids);

if ($from_time < $to_time) {
    // $format .= "['Date', 'Pledge Amount (".get_woocommerce_currency().")', 'Sales'],";

    if ($query_range === 'day_wise') {

        while ($from_time < $to_time) {
            $from_time      = strtotime('+1 day', $from_time);
            $printed_date   = date('d M', $from_time);

            $sql = "SELECT ID, DATE_FORMAT(post_date, '%d %b') AS order_time  ,$wpdb->postmeta.*, GROUP_CONCAT(DISTINCT ID SEPARATOR ',') AS order_ids FROM $wpdb->posts 
LEFT JOIN $wpdb->postmeta 
ON $wpdb->posts.ID = $wpdb->postmeta.post_id
WHERE $wpdb->posts.post_type = 'shop_order' AND $wpdb->posts.ID IN ( '" . implode( "','", $getting_order_ids_by_products ) . "' )
AND meta_key = 'is_crowdfunding_order' AND meta_value = '1' AND post_status = 'wc-completed'  AND post_date LIKE 
'".date('Y-m-d%', $from_time)."' group by order_time";

            $sales_count          = 0;
            $results              = $wpdb->get_results($sql);
            $total_backers_amount = array();

            if (  $results) {
                foreach ($results as $result) {
                    $total_backers_amount[] = $wpdb->get_var("(SELECT SUM(meta_value) from $wpdb->postmeta where post_id IN({$result->order_ids}) and meta_key = '_order_total' )");
                    $sales_count            = count(explode(',', $result->order_ids)) ;
                }
            } else{
                $total_backers_amount[]     = 0;
            }

            $csv[]                       = array($printed_date, $total_backers_amount, $sales_count);
            $format[]                   = array_sum($total_backers_amount);
            $label[]                    = "'{$printed_date}'";
            $sales_count_ever[]          = $sales_count; //Get Total backers amount and sales count all time
            $total_backers_amount_ever[] = array_sum($total_backers_amount);
        }
    } else {
        $from_time          = strtotime('-1 month', strtotime($from_date));
        $to_time            = strtotime('-1 month', strtotime($to_date));

        while ($from_time < $to_time) {
            $from_time      = strtotime('+1 month', $from_time);
            $printed_date   = date('F', $from_time);

            $sql = "SELECT 
                        ID, MONTHNAME(post_date) AS order_time  ,$wpdb->postmeta.*, GROUP_CONCAT(DISTINCT ID SEPARATOR ',') AS order_ids 
                    FROM 
                        $wpdb->posts 
                    LEFT JOIN 
                        $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id 
                    WHERE 
                        $wpdb->posts.post_type = 'shop_order'  AND $wpdb->posts.ID IN ( '" . implode( "','", $getting_order_ids_by_products ) . "' ) AND meta_key = 'is_crowdfunding_order' AND meta_value = '1' AND post_status = 'wc-completed' AND post_date 
                    LIKE 
                        '".date('Y-m%', $from_time)."' group by order_time";

            $sales_count            = 0;
            $results                = $wpdb->get_results($sql);
            $total_backers_amount   = array();

            if (  $results ) {
                foreach ($results as $result) {
                    $total_backers_amount[] = $wpdb->get_var("(SELECT SUM(meta_value) from $wpdb->postmeta where post_id IN({$result->order_ids}) and meta_key = '_order_total' )");
                    $sales_count            = count(explode(',', $result->order_ids)) ;
                }
            } else {
                $total_backers_amount[]     = 0;
            }

            $csv[]                          = array($printed_date, $total_backers_amount, $sales_count);
            $format[]                   = array_sum($total_backers_amount);
            $label[]                    = "'{$printed_date}'";

            $sales_count_ever[]             = $sales_count; //Get Total backers amount and sales count all time
            $total_backers_amount_ever[]    = array_sum($total_backers_amount);
        }

    }
}


/**
 * Get Total Campaigns
 */

$query_args = array(
    'post_type' => 'shop_order',
    'post_status' => 'wc-completed',
    'numberposts' => -1,
    'author'      => $user_id,
    // 'meta_key'    => '_customer_user',
    // 'meta_value'  => $user_id,
    'meta_query' => array(
        // 'relation' => 'AND',
        // array(
        //     'meta_key'    => '_customer_user',
        //     'meta_value'  => $user_id,
        //     'compare' => '='
        // ),
        array(
            'meta_key'    => 'is_crowdfunding_order',
            'meta_value'  => 1,
            'compare'     => '=',
        ),
    ),

    'date_query' => array(
        array(
            'after'     => date('F jS, Y', strtotime($from_date)),
            'before'    =>  array(
                'year'  => date('Y', strtotime($to_date)),
                'month' => date('m', strtotime($to_date)),
                'day'   => date('d', strtotime($to_date)),
            ),
            'inclusive' => true,
        ),
    ),
);
$get_crowdfunding_campaigns = new WP_Query($query_args);
//print_r($get_crowdfunding_campaigns);


$pladges_received = get_date_range_pladges_received($from_date, $to_date);

?>

<div class="wpneo-dashboard-chart wpneo-shadow chart-container">

    <div class="wpneo-dashboard-head wpneo-clearfix">
        <div class="wpneo-dashboard-head-left">
            <span><?php _e( "Summary" , "wp-crowdfunding" );?></span>
            <ul>
                <li class="<?php echo ($date_range === 'last_7_days') ? 'active':''; ?>"><a href="<?php echo
                    add_query_arg(array
                    ('date_range' => 'last_7_days'),
                    get_permalink()
                    ); ?>">1W</a></li>
                <li class="<?php echo ($date_range === 'last_14_days') ? 'active':''; ?>"><a href="<?php echo add_query_arg(array('date_range' => 'last_14_days'), get_permalink()); ?>">2W</a></li>
                <li class="<?php echo ($date_range === 'this_month') ? 'active':''; ?>"><a href="<?php echo add_query_arg(array('date_range' => 'this_month'), get_permalink()); ?>">1M</a></li>
                <li class="<?php echo ($date_range === 'last_3_months') ? 'active':''; ?>"><a href="<?php echo add_query_arg(array('date_range' => 'last_3_months'), get_permalink());
                ?>">3M</a></li>
                <li class="<?php echo ($date_range === 'last_6_months') ? 'active':''; ?>"><a href="<?php echo add_query_arg(array('date_range' => 'last_6_months'), get_permalink());
                ?>">6M</a></li>
                <li class="<?php echo ($date_range === 'this_year') ? 'active':''; ?>"><a href="<?php echo add_query_arg(array('date_range' => 'this_year'), get_permalink()); ?>">1Y</a></li>
            </ul>
        </div><!--dashboard-head-left-->
        <div class="dashboard-head-right">
            <form method="get" action="" class="dashboard-head-date">
                <input type="hidden" name="page" value="wpcrowd-crowdfunding-reports" />
                <input type="text" id="datepicker" name="date_range_from" class="datepickers_1" value="<?php echo date('Y-m-d', strtotime($from_date)); ?>" placeholder="From" />
                <span><?php _e( "to" , "wp-crowdfunding" ); ?></span>
                <input type="text" name="date_range_to" class="datepickers_1" value="<?php echo date('Y-m-d', strtotime($to_date)); ?>" placeholder="To" />
                <input type="submit" value="Search" class="button" id="search-submit">
            </form>
        </div><!--dashboard-head-right-->
    </div><!--wpneo-dashboard-head-->

    <div class="wpneo-dashboard-summery wpneo-clearfix">
        <ul>
            <li class="active"><span class="wpneo-value"> <?php echo wc_price(array_sum($total_backers_amount_ever)); ?></span><span class="wpneo-value-info"><?php _e( "Fund Raised" , "wp-crowdfunding" ); ?></span></li>
            <li><span class="wpneo-value"><?php echo array_sum($sales_count_ever); ?></span><span class="wpneo-value-info"><?php _e( "Total Backed" , "wp-crowdfunding" ); ?></span></li>
            <li><span class="wpneo-value"><?php echo count($pladges_received); ?></span><span class="wpneo-value-info"><?php _e( "Plages Received" , "wp-crowdfunding" ); ?></span></li>
        </ul>
    </div><!--wpneo-dashboard-summery-->
    <canvas id="WPcrowdFundChart" width="400" height="60"></canvas>
</div><!--"wpneo-dashboard-chart-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var ctx = $("#WPcrowdFundChart");
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo implode(',', $label) ?>],
                datasets: [{
                    label: "<?php echo date("Y", strtotime($from_date)); ?>",
                    fill: false,
                    data: [<?php echo implode(",", $format) ?>],
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor:'#1adc68',
                    pointHoverBorderColor:'#fff',
                    backgroundColor:'#1adc68',
                    borderColor:'#DCDCE9',
                    borderWidth: 3,
                    pointStyle: 'circle',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        stacked: true
                    }]
                },
                elements: {
                    line: {
                        tension: 0,
                    }
                },
                legend: {
                    display: false,
                }
            }
        })
    });


</script>
<?php
//página que retorna o total arrecadado
?>
<!DOCTYPE html>
<html lang="pt-br">

<style>

</style>
<body style="
    font-family: 'Montserrat';
">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

<header style="
    text-align: center;
">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<div><p style="
    margin-bottom: 5px;
    color: dimgrey;
    font-size: 17px;
    font-weight: 600;
">Arrecadação em tempo real</p></div>
		<div style="
    margin-top: -10px;
    position: relative;
">

       <p style="font-size:50px;font-weight: 900;letter-spacing: 2px; color:#A07F3C">

			<?php
			require ("wp-config.php");
			
			
			global $wpdb;
			
			/*
			$my_query = $wpdb->get_results( "SELECT * FROM tbl_numero_serie where status is null order by numero_serie" );
			
			foreach ( $my_query as $row ) 
			{

				echo $row->numero_serie . "<br>";

			}
			*/
			/*
			SELECT 
			SUM( postmeta.meta_value ) 
			FROM wp4x_posts as posts 
			INNER JOIN wp4x_postmeta AS postmeta ON posts.ID = postmeta.post_id 
			WHERE posts.post_type IN ( 'shop_order','shop_order_refund' ) 
			AND posts.post_status IN ( 'wc-completed','wc-processing','wc-on-hold' ) 
			AND postmeta.meta_key = '_order_total' 
			AND posts.post_date >= '2020-12-01' AND posts.post_date <= '2020-12-07 21:31:17' 			
			*/
			
			$query            = array();
			$query['fields']  = "SELECT SUM( postmeta.meta_value ) FROM {$wpdb->posts} as posts";
			$query['join']    = "INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id ";
			$query['where']   = "WHERE posts.post_type IN ( '" . implode( "','", wc_get_order_types( 'reports' ) ) . "' ) ";
			$query['where']  .= "AND posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "' ) ";
			$query['where']  .= "AND postmeta.meta_key   = '_order_total' ";
			//$query['where']  .= "AND posts.post_date >= '" . date( 'Y-m-01', current_time( 'timestamp' ) ) . "' ";
			//$query['where']  .= "AND posts.post_date <= '" . date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ) . "' ";

			//print_r($query);

			$sales = $wpdb->get_var( implode( ' ', apply_filters( 'woocommerce_dashboard_status_widget_sales_query', $query ) ) );			
			
			echo wc_price( $sales );	//mostra o valor na tela
			//echo $sales;
	
			?>

		</p>
        </div>
  


<div class="row" style="
    position: relative;
    margin-top: -10px;
    color: #63370d;
">
<div class="col-xs-12 col-sm-3" style="
    padding: 5px;
"><b>   <?php 
$a = $sales;
$b = 90;

$resultado = $a / $b;

echo intval($resultado); 

?> </b> cestas básicas</div>
<div class="col-xs-12 col-sm-3" style="
    padding: 5px;
"><b><?php 
$a = $sales;
$b = 50;

$resultado = $a / $b;

echo intval($resultado); 

?></b> brinquedos</div>
<div class="col-xs-12 col-sm-3" style="
    padding: 5px;
"><b><?php 
$a = $sales;
$b = 35;

$resultado = $a / $b;

echo intval($resultado); 

?></b> kit de higiene</div>


<div class="col-xs-12 col-sm-3" style="
    padding: 5px;
"><b><?php 
$a = $sales;
$b = 70;

$resultado = $a / $b;

echo intval($resultado); 

?></b> Materiais escolares</div>
</div>
</header>
	</body>
</html>
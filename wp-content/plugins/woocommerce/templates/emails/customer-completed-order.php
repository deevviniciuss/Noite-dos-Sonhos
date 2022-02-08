<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p style="color: #404040"><?php printf( esc_html__( 'Olá %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
<p style="color: #404040"><?php esc_html_e( 'Concluímos o processamento de seu pedido.', 'woocommerce' ); ?></p>
<p style="color: #404040"><?php esc_html_e( 'Muito obrigado pela sua boa ação.', 'woocommerce' ); ?></p>

<p style="color: #404040">
<?php 

	
	global $wpdb;
	
	$numero_pedido = $order->get_order_number();
	$cpf = str_replace('-','',str_replace('.','',esc_html($order->billing_cpf)));
	
	//$status = $_POST["order_status"];
	//echo $numero_pedido  . "-" . $cpf . "<br>";
	
	//echo $status  . "-" . $cpf . "<br>";
	
	//exit;

	//vincula os sorteios para o cliente após o pagamento
	//retorna o status pago (wc-completed) do pedido

	
	//retorna o status pago (wc-completed) do pedido
	
	$sql_status = $wpdb->get_results( "select * from wp4x_wc_order_stats  where order_id = $numero_pedido and status = 'wc-completed' " );
	$num_rows = count( $sql_status ); //PHP count()
	$cont =  $num_rows;		

	//echo $numero_pedido  . " - " . $cpf . "<br>";
	//verifica se o pagamento foi efetuado (retorna o valor de concluído do pedido)
	//if ($status = "wc-completed")
	if ($cont == 1) //para pagameentos que exige que no admin seja alterado para pagto realizado
	{
	
		try 
		{
	
			$sql_car = "SELECT 
			a.order_item_id,
			a.order_item_name,
			a.order_id,
			b.meta_value as qtde,
			c.meta_value,
			d.ID,
			d.post_content as codigo_produto
			FROM
			wp4x_woocommerce_order_items a,
			wp4x_woocommerce_order_itemmeta b,
			wp4x_woocommerce_order_itemmeta c,
			wp4x_posts d
			WHERE 
			a.order_id = $numero_pedido
			AND a.order_item_id = b.order_item_id
			AND a.order_item_id = c.order_item_id
			AND b.meta_key = '_qty'
			AND c.meta_key = '_product_id'
			AND c.meta_value = d.ID ";
			$results = $wpdb->get_results($sql_car);
			
			foreach ( $results as $rs1 ) 
			{
				$qtde = $rs1->qtde;
				$codigo_produto = $rs1->codigo_produto;
				
				//echo $qtde . "<br>";
				//echo $codigo_produto . "<br>";
				
				$total_ant = $qtde * $codigo_produto;
				$total_atual = $total_atual + $total_ant; 
			}
			
			
			 $quantidade = $total_atual;
			
			$my_query = $wpdb->get_results( "SELECT * FROM tbl_numero_serie where status is null order by numero_serie" );
			
			foreach ( $my_query as $row ) 
			{

				$letra_serie = $row->numero_serie;
				$id_letra = $row->id;
				
				
					
				
					$my_query1 = $wpdb->get_results( "SELECT * FROM tbl_sorteio WHERE NUMERO_SERIE = '$letra_serie' and utilizado is null limit 100" );
					$num_rows = count( $my_query1 ); //PHP count()
					$total1 =  $num_rows;
					
					
					if ($total1 == 0) // não há mais numeros disponiveis para essa serie
					{
							
							$sql_u = $wpdb->prepare(
							"update tbl_numero_serie  set status = 'I' where numero_serie = '$letra_serie' and id = $id_letra");
							$wpdb->query($sql_u);
							
					}
					else
					{
						$sql = "SELECT numero_sorte, numero_serie, utilizado FROM tbl_sorteio WHERE numero_serie = '$letra_serie' AND utilizado IS null LIMIT $quantidade; ";
						$result = $wpdb->get_results($sql) ;

						foreach ( $result as $row ) 
						{
							$numero_sorte = $row->numero_sorte;  
							$numero_serie = $row->numero_serie;  
							
							//echo $numero_sorte . " - "  . $letra_serie . "<br>";
						
							
							$sql_i = $wpdb->prepare(
							"update tbl_sorteio  set utilizado = 'S',  cpf_cliente = '$cpf', order_id = $numero_pedido
							where numero_sorte = '$numero_sorte' and numero_serie = '$numero_serie' ");
							$wpdb->query($sql_i);	
							
														
						}
						
						//sai quando vincular todas as compras aos numeros da sorte
						break;
					}
			}
	
		
		}
		catch (PDOException $e) 
		{
			echo $e->getMessage();
		}		
	}
	else //pagto aprovado na hora
	{
	
		try
		{
	
			$sql_car = "SELECT 
			a.order_item_id,
			a.order_item_name,
			a.order_id,
			b.meta_value as qtde,
			c.meta_value,
			d.ID,
			d.post_content as codigo_produto
			FROM
			wp4x_woocommerce_order_items a,
			wp4x_woocommerce_order_itemmeta b,
			wp4x_woocommerce_order_itemmeta c,
			wp4x_posts d
			WHERE 
			a.order_id = $numero_pedido
			AND a.order_item_id = b.order_item_id
			AND a.order_item_id = c.order_item_id
			AND b.meta_key = '_qty'
			AND c.meta_key = '_product_id'
			AND c.meta_value = d.ID ";
			$results = $wpdb->get_results($sql_car);
			
			foreach ( $results as $rs1 ) 
			{
				$qtde = $rs1->qtde;
				$codigo_produto = $rs1->codigo_produto;
				
				//echo $qtde . "<br>";
				//echo $codigo_produto . "<br>";
				
				$total_ant = $qtde * $codigo_produto;
				$total_atual = $total_atual + $total_ant; 
			}
			
			
			 $quantidade = $total_atual;
			
			$my_query = $wpdb->get_results( "SELECT * FROM tbl_numero_serie where status is null order by numero_serie" );
			
			foreach ( $my_query as $row ) 
			{

				$letra_serie = $row->numero_serie;
				$id_letra = $row->id;
				
				
					
				
					$my_query1 = $wpdb->get_results( "SELECT * FROM tbl_sorteio WHERE NUMERO_SERIE = '$letra_serie' and utilizado is null limit 100" );
					$num_rows = count( $my_query1 ); //PHP count()
					$total1 =  $num_rows;
					
					
					if ($total1 == 0) // não há mais numeros disponiveis para essa serie
					{
							
							$sql_u = $wpdb->prepare(
							"update tbl_numero_serie  set status = 'I' where numero_serie = '$letra_serie' and id = $id_letra");
							$wpdb->query($sql_u);
							
					}
					else
					{
						$sql = "SELECT numero_sorte, numero_serie, utilizado FROM tbl_sorteio WHERE numero_serie = '$letra_serie' AND utilizado IS null LIMIT $quantidade; ";
						$result = $wpdb->get_results($sql) ;

						foreach ( $result as $row ) 
						{
							$numero_sorte = $row->numero_sorte;  
							$numero_serie = $row->numero_serie;  
							
							//echo $numero_sorte . " - "  . $letra_serie . "<br>";
						
							
							$sql_i = $wpdb->prepare(
							"update tbl_sorteio  set utilizado = 'S',  cpf_cliente = '$cpf', order_id = $numero_pedido
							where numero_sorte = '$numero_sorte' and numero_serie = '$numero_serie' ");
							$wpdb->query($sql_i);	
							
														
						}
						
						//sai quando vincular todas as compras aos numeros da sorte
						break;
					}
			}
		}
		catch (PDOException $e) 
		{
			echo $e->getMessage();
		}		
	}


	//lista os sorteios
	//$numero_pedido = $order->get_id();
	esc_html_e( 'Confira seus números da sorte: ', 'woocommerce' ); 

	//global $wpdb;
	$sql = "SELECT * FROM tbl_sorteio WHERE order_id = $numero_pedido ";
	$result = $wpdb->get_results($sql) ;
	
	foreach ( $result as $row) 
	{
		$numero_sorte = $row->numero_sorte;  
		$numero_serie = $row->numero_serie;  
		$teste = $row->key;
		
		echo  "<p style='color: black; font-weight: bold; '>º Ticket: ". $numero_serie."/". $numero_sorte. "</p>" . "<span></span>";
		//str_pad('100' , 4 , '0' , STR_PAD_LEFT);
									
	}	


		
?>
</p>
<p style="color: #404040">
    Seu Ticket é composto pelo número de série (número de dois dígitos que vem antes da barra) e pelo elemento sorteável (número de cinco dígitos que vem depois da barra). O presente sorteio expedirá um total de 2.000.000 (dois milhões) de Tickets, com séries de 00 a 19 e elementos sorteáveis de 00000 a 99999.
     <p style="color: #404040">
        
Caso o número de série encontrado seja superior à maior série da apuração (19), deverá ser subtraída a quantidade de séries do sorteio (20), do número de série encontrado, tantas vezes quantas forem necessárias, até que o número obtido esteja dentro do intervalo de séries do sorteio. <br>
Ganhará a experiência única sorteada, o participante que possuir o Ticket cuja série e elemento sorteável coincidam com resultado da Loteria Federal do dia 06/09/2021, que pode ser consultado pelo site http://loterias.caixa.gov.br/wps/portal/loterias/landing/federal/, aplicando-se a regra abaixo descrita.
 .</p>
         <p style="color: #404040">

            Exemplo: Resultado hipotético da Loteria Federal do dia 19/05/2021
            . Para apuração do Ticket vencedor, o Resultado da Loteria Federal deverá ser lido de cima pra baixo: 
            <br>


            <img alt="Qries" src="http://noitedossonhos.com/email.png"
            width="300" height="100">
            <br>

Será contemplado o portador do Ticket contendo o nº  <b style="color:red;">53.269</b> da série <b style="color:blue;">*08</b>, ou seja, o Ticket<b> 08/53269.</b> <br>

<p>
    * Como o número de série encontrado (88) é superior à maior série da apuração (19), do número de série encontrado foi subtraída a quantidade de séries do sorteio (20), até a obtenção de número que esteja dentro do intervalo de séries do sorteio (no exemplo acima: 88-20=68-20=48-20=28-20=08). 
 

</p>
Se o número contemplado não for distribuído por qualquer motivo, o prêmio caberá ao portador do elemento sorteável imediatamente superior ou, na falta deste, ao portador do elemento sorteável imediatamente inferior.
</p>
<p>
O sorteio será realizado em 06 de setembro de 2021, a partir das 18 horas (horário de Brasília).

     </p>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
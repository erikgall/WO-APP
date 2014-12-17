<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->config->item('meta_title'); ?> || Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <?php 
	
		echo link_tag($css['bootstrap_min']); 
		
		echo link_tag($css['metis_menu']);
		
		//echo link_tag($css['timeline']);
		
		echo link_tag($css['wo_admin']);
		
		echo link_tag($css['morris']);
		
		echo link_tag($css['font_awesome']);
		
		echo link_tag($css['datatables']);
		
		echo link_tag($css['datetimepicker']);
		
		echo link_tag($css['keyframes']);
		
		echo link_tag($css['transition']);

		echo link_tag($css['animate']);

		echo script($js['jquery']);
			
		echo script($js['bootstrap_min']);
		
		echo script($js['metis_menu']);
						
		echo script($js['datatables']);
		
		echo script($js['datatables_bootstrap']);
				
		echo script($js['smoothState']);
		
	?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

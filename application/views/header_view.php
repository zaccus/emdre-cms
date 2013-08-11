<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">

        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript">
            window.emdre_vars = {
                baseUrl: "<?php echo base_url(); ?>",
                type: "<?php echo (isset($js_file) ? $js_file : 'properties'); ?>"
            };
        </script>
<?php if (isset($js_file)) { ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/manage_listings_JS.php"></script>
<?php } ?>
	</head>
	<body>
	
<!-- end of header -->


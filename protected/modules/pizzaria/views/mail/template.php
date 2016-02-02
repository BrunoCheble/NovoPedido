<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
		<table>
			<tr>
				<td style="width: 130px; padding: 20px;"><img src="<?php echo Yii::app()->params['websiteUrl']; ?>/images/logo.jpg" alt="Empresa Logo" /></td>
				<td><p style="font-size: 25px; font-weight: bold; color: #000;"><?php echo $title; ?></p></td>
			</tr>
		</table>
		<?php echo $content; ?>
    </body>
</html>
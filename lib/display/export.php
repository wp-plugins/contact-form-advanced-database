		<?php 
			$colKeys = array();
			$cf7AdbArr = get_post_meta($id,'cf7-adb-data',true);	
			if(!empty($cf7AdbArr)):	
		?>

		<table border=1>
			<thead>
				<?php 
				unset($cf7AdbArr['_wpcf7'],$cf7AdbArr['_wpcf7_version'],$cf7AdbArr['_wpcf7_locale'],$cf7AdbArr['_wpcf7_unit_tag'],$cf7AdbArr['_wpnonce'],$cf7AdbArr['_wpcf7_is_ajax_call']);
					foreach(array_keys($cf7AdbArr) as $cf7AdbData) {
					$colKeys[] = $cf7AdbData;
				?>
					<th class="manage-column column-title sorted">
						<span><?php echo $cf7AdbData; ?></span>				
					</th>
				<?php } ?>
			</thead>

			<tbody>
				<?php 
				foreach(get_post_meta($id,'cf7-adb-data') as $leadData){ 
					$thDiv = rand(1,1000).'_'.time().'_'.rand(1000,5000);
				?>
					<tr>
						<?php foreach($colKeys as $colKeysData){ ?>
							<td><?php echo $leadData[$colKeysData]; ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table> 	
		<?php else: ?>
		No Data Available
		<?php endif; ?>	



<?php add_thickbox(); ?>
<div class="wrap">
	<h2>Contact Form Advanced Database
		<select id="cf7-selector">
			<?php
				$cf7Selector = $_GET['id'];
				$args = array(	'post_type'			=> 'wpcf7_contact_form',
								'posts_per_page'	=> -1,
								'orderby'			=> 'title',
								'order'				=> 'ASC');
				$cf7Query = new WP_Query( $args );
				if ( $cf7Query->have_posts() ) {
					$incSel = 0;
					while ( $cf7Query->have_posts() ) {
						$cf7Query->the_post();
						echo '<option value="'.get_the_ID().'" '.(($cf7Selector==get_the_ID())?'selected':'').'>' . get_the_title() . '</option>';
						if(empty($cf7Selector)){
							if($incSel==0){
								$cf7Selector = get_the_ID();
							}
							$incSel++;
						}
					}
				}
			
				wp_reset_postdata(); 
			?>
		</select>
		
	</h2>
	 <div id="poststuff">
		<?php 
			$colKeys = array();
			$cf7AdbArr = get_post_meta($cf7Selector,'cf7-adb-data',true);
			
			if(!empty($cf7AdbArr)):	
		?>
		<button class="button" id="adb-delete-button">Delete</button>
		<button class="button" id="adb-export">
			<a target="_blank" href="admin.php?page=cf7-adb-export-xls&id=<?php echo $cf7Selector; ?>">Export XLS</a>
		</button>
		<table class="wp-list-table widefat fixed media paginated" id="property-lead-table" data-page-length='10'>
			<thead>
				<th class="manage-column column-cb check-column"></th>
				<?php 
				unset($cf7AdbArr['_wpcf7'],$cf7AdbArr['_wpcf7_version'],$cf7AdbArr['_wpcf7_locale'],$cf7AdbArr['_wpcf7_unit_tag'],$cf7AdbArr['_wpnonce'],$cf7AdbArr['_wpcf7_is_ajax_call']);
					foreach(array_keys($cf7AdbArr) as $cf7AdbData) {
					$colKeys[] = $cf7AdbData;
				?>
					<th class="manage-column column-title sorted">
						<span><?php echo $cf7AdbData; ?></span>				
					</th>
				<?php } ?>
				<th></th>
				<th></th>
			</thead>

			<tfoot>
				<th class="manage-column column-cb check-column"></th>
				<?php foreach(array_keys($cf7AdbArr) as $cf7AdbData) {?>
					<th class="manage-column column-title sorted">
							<span><?php echo $cf7AdbData; ?></span>				
					</th>
				<?php } ?>
				<th></th>
				<th></th>
			</tfoot>
			<tbody>
				<?php 
				foreach(get_post_meta($cf7Selector,'cf7-adb-data') as $leadData){ 
					$thDiv = rand(1,1000).'_'.time().'_'.rand(1000,5000);
					unset($leadData['_wpcf7'],$leadData['_wpcf7_version'],$leadData['_wpcf7_locale'],$leadData['_wpcf7_unit_tag'],$leadData['_wpnonce'],$leadData['_wpcf7_is_ajax_call']);
				?>
					<tr>
						<td><input class="adb-chk" type="checkbox" data-status="0" data-id="<?php echo $cf7Selector; ?>" data-key="cf7-adb-data" value="<?php echo base64_encode(maybe_serialize($leadData)); ?>"></td>
						<?php 
							 if(count($leadData) == count($colKeys)){
							foreach($colKeys as $colKeysData){ ?>
							<td><?php echo (strlen($leadData[$colKeysData]) > 60 )?substr($leadData[$colKeysData],0,60).'...':$leadData[$colKeysData]; ?></td>
						<?php }}else{ 
								foreach(array_keys($leadData) as $leadDatas){ 
								echo '<td><span class="edited-entries">'.$leadDatas.'</span><br />'.((strlen($leadData[$leadDatas]) > 60 )?substr($leadData[$leadDatas],0,60).'...':$leadData[$leadDatas]).'</td>'; 
							}}	

						?>
						
						<td>
						<div id="<?php echo $thDiv; ?>" style="display:none;">
							 <div>
								  <?php 
								  if(count($leadData) == count($colKeys)){
								  foreach($colKeys as $colKeysData){ ?>
									<div class="adb-per-line">
										<div class="field-name"><?php echo strtoupper($colKeysData) ?></div>
										<div class="field-value"><?php echo $leadData[$colKeysData] ?></div>
									</div>
								 <?php }}else{ ?>
								  <?php
									
									foreach(array_keys($leadData) as $leadDatas){ ?>
										<div class="adb-per-line">
											<div class="field-name"><?php echo strtoupper($leadDatas) ?></div>
											<div class="field-value"><?php echo $leadData[$leadDatas] ?></div>
										</div>
								 
								 <?php }}  ?>
							 </div>

						</div>
						<a href="#TB_inline?width=600&height=550&inlineId=<?php echo $thDiv; ?>" title="Contact Form fields and value" class="view-button thickbox">View</a></td>
						<td>
							<span class="del-button" data-id="<?php echo $cf7Selector; ?>" data-key="cf7-adb-data" data-val="<?php echo base64_encode(maybe_serialize($leadData)); ?>">Delete</span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table> 	
		<?php else: ?>
		No Data Available
		<?php endif; ?>	
	</div>
</div>

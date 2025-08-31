<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Packages;
use app\models\MasterG3eContainer;

//Untuk js append cargo
$packages = Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
?>

<div id="cargo-choose-index">
	<h6 class="pl-3 mt-2 mb-2">CHOOSE CONTAINERS</h6>
	<!-- Style 1 -->
	<div class="row mt-4">
		<div class="col-2 text-center align-middle">
			<label class="control-label mt-2 mb-0">CONTAINER</label>
		</div>
		<div class="col-3 pl-0">
			<select class="form-select" style="width:100%" id="container_search">
					<?php
						$container_list = MasterG3eContainer::find()->orderby(['con_code'=>SORT_ASC])->all();
						
						foreach($container_list as $row){
							echo "<option value=".$row['con_id'].">".
								$row['con_code']." ".
								$row['con_text']." ".
								$row['con_name']." ".
							"</option>";
						}
					?>
			</select>
		</div>
		<div class="col-2 pl-0">
			<button type="button" class="btn btn-dark" id="btn-addcon">ADD</button>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-12" id="con_list" style="margin-left:35px">
		</div>
	</div>
	
	<hr><br>
	<!-- Style 2 -->
	<div class="col-md-12 d-flex justify-content-between mb-4">
		<h6 class="mt-2 mb-2">CHOOSE CONTAINERS</h6>
		<div class="col-md-3">
			<div class="input-group">
				<input type="text" class="form-control" id="search-cargo">
				<div class="input-group-append">
					<span class="input-group-text" id="btn_search"><i class="fa fa-search"></i></span>
				</div>
			</div>
		</div>
	</div>
	
	<?php
		$container = MasterG3eContainer::find()->limit(100)->orderby(['con_code'=>SORT_ASC])->all();
	?>
	
	<div class="col-md-12 mb-3">
		<table class="table-borderless w-100" id="table-cargo">
			<?php
				$i=1;
				foreach($container as $row){
					if($i == 1){
						echo '<tr>'.
							'<td width="20%" class="align-top">
								<div class="form-check mb-1">
									<input class="form-check-input" type="checkbox" id="checkbox-'.$i.'" value="'.$row['con_id'].'">'.
									'<label for="checkbox-'.$i.'">'.$row['con_code'].' '.$row['con_text'].' '.$row['con_name'].'</label>'.
								'</div>
							</td>';
					}else{
						if($i % 5 == 0){
							echo '</tr>';
						}else{
							echo '<td width="20%" class="align-top">
									<div class="form-check mb-1">
										<input class="form-check-input" type="checkbox" id="checkbox-'.$i.'" value="'.$row['con_id'].'">'.
										'<label for="checkbox-'.$i.'">'.$row['con_code'].' '.$row['con_text'].' '.$row['con_name'].'</label>'.
									'</div>
								</td>';
						}
					}
					$i++;
				}
			?>
		</table>
	</div>

	<div class="col-md-12"><hr class="mt-4"></div>
	
	<div class="col-md-12">
		<div class="form-group">
			<button type="button" class="btn btn-dark" id="btn_cargo_confirm">Confirm</button>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function(){
		check_complete_cargo();
	});
	
	$('#search-cargo').on('keyup', function(){
		var key = $('#search-cargo').val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-container'?>',
			data: {'key':key},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			$("#table-cargo").html(res.container);
			
		}).fail(function(err){
			
		});
	});
	
	$('.form-check-input').on('click', function() {
		check_complete_cargo();
	});
	
	//check complete
	function check_complete_cargo(){
		if($('#cargo-choose-index input:checkbox:checked').length > 0){
			$('#heading2 h2').removeClass('uncomplete');
			$('#heading2 h2').addClass('complete');
			$('#heading2 .row div').removeClass('uncomplete');
			$('#heading2 .row div').addClass('complete');
		}else{
			$('#heading2 h2').addClass('uncomplete');
			$('#heading2 h2').removeClass('complete');
			$('#heading2 .row div').addClass('uncomplete');
			$('#heading2 .row div').removeClass('complete');
		}
	}
	
	//Button confirm to chargo input detail
	$('#btn_cargo_confirm').on('click', function() {
		$('#table-cargo-input tbody tr:not(.header)').remove();
		chargo_checked1 = $('#table-cargo input:checked');
		chargo_checked2 = $('#con_list input:checked');
		count= 0;
		
		chargo_checked1.each(function(){
			id = $(this).attr('id');
			label = $('#'+id).parent().find('label').html();
			
			item = '<tr>';
				item += '<td><b>'+label+'</b><input type="hidden" class="form-control" value="'+label+'" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_name]" required></td>';
				
				item += '<td>';
					item += '<input type="text" class="form-control" placeholder="Seal Number" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_seal]" required>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-7 pr-1">';
							item += '<input type="text" class="form-control input_package" placeholder="0" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_pack_value]" onkeyup="total_package()" required>';
						item += '</div>';
						item += '<div class="col-md-5 pl-1">';
							item += '<select class="form-select form-select-lg input_type_package" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_pack_type]" onchange="total_package()" required>';
								item +="<?php
									foreach($packages as $row){
										$name = str_replace("'", "&apos;", $row['packages_plural']);
										
										echo "<option value='".$name."'>".
											$row['packages_plural'].
										"</option>";
									}
								?>";
							item += '</select>';
						item += '</div>	';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="text" class="form-control input_gross" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_gross_value1]" onkeyup="total_weight()" required>';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control" style="height:25px" placeholder="00" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_gross_value2]" required>';
						item += '</div>';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="text" class="form-control input_nett" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_nett_value1]" onkeyup="total_weight()" required>';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control" style="height:25px" placeholder="00" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_nett_value2]" required>';
						item += '</div>';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="text" class="form-control input_measurement" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_msr_value1]" onkeyup="total_weight()" required>';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control" style="height:25px" placeholder="00" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_msr_value2]" required>';
						item += '</div>';
					item += '</div>';	
				item += '</td>';
			item += '</tr>';
			
			item += '<tr>';
				item += '<td></td>';
				item += '<td colspan="5">';
					item += '<textarea class="form-control" placeholder="Container Description" rows="5" name="MasterG3eHblCargodetail[detail]['+count+'][hblcrg_description]" required></textarea>';
				item += '</td>';
			item += '</tr>';
			
			$('#table-cargo-input tbody').append(item);
			count++;
			
			total_con = $('#table-cargo-input tbody tr:not(.header)').length / 2;
			
			$('#description-goods').html(total_con+' CONTAINER');
		});
		
		chargo_checked2.each(function(){
			id = $(this).attr('id');
			label = $('#'+id).parent().find('label').html();
			
			item = '<tr>';
				item += '<td><b>'+label+'</b></td>';
				
				item += '<td>';
					item += '<input type="text" class="form-control" placeholder="Seal Number">';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-7 pr-1">';
							item += '<input type="text" class="form-control input_package" placeholder="0" onkeyup="total_package()">';
						item += '</div>';
						item += '<div class="col-md-5 pl-1">';
							item += '<select class="form-select form-select-lg input_type_package" onchange="total_package()">';
								item +="<?php
									foreach($packages as $row){
										$name = str_replace("'", "`", $row['packages_name']);
										
										echo "<option value='".$name."'>".
											$row['packages_name'].
										"</option>";
									}
								?>";
							item += '</select>';
						item += '</div>	';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="text" class="form-control input_gross" value="" onkeyup="total_weight()">';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control" style="height:25px" value="00">';
						item += '</div>';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="text" class="form-control input_nett" value="" onkeyup="total_weight()">';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control" style="height:25px" value="00">';
						item += '</div>';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="text" class="form-control input_measurement" value="" onkeyup="total_weight()">';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control" style="height:25px" value="00">';
						item += '</div>';
					item += '</div>';	
				item += '</td>';
			item += '</tr>';
			
			item += '<tr>';
				item += '<td></td>';
				item += '<td colspan="5">';
					item += '<textarea class="form-control" placeholder="Container Description" rows="5"></textarea>';
				item += '</td>';
			item += '</tr>';
			
			$('#table-cargo-input tbody').append(item);
		});
	});
	
	$('#container_search').select2();
	
	$('#btn-addcon').on('click', function() {
		id = $('#container_search').val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-container2'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			
			// i = $('#con_list input:checkbox').length;
			// item = '<div>';
			// item += '<input class="form-check-input" type="checkbox" id="checkbox1-'+i+'" value="'+res.container['con_id']+'">';
			// item += '<label for="checkbox1-'+i+'">'+res.container['con_code']+'&nbsp;'+res.container['con_text']+'&nbsp;'+res.container['con_name']+'</label>';
			// item += '</div>';
			
			i = $('#con_list label').length;
			
			if(i == 0){
				item = '<label for="checkbox1-'+i+'">'+res.container['con_code']+'&nbsp;'+res.container['con_text']+'&nbsp;'+res.container['con_name']+'</label>';
			}else{
				item = '&nbsp;&nbsp; , &nbsp;&nbsp;';
				item += '<label for="checkbox1-'+i+'">'+res.container['con_code']+'&nbsp;'+res.container['con_text']+'&nbsp;'+res.container['con_name']+'</label>';
			}
			
			
			$('#con_list').append(item);
			
		}).fail(function(err){
			
		});
	});
	
	
	function total_weight(){
		var total_gross = 0;
		var total_nett = 0;
		var total_measurement = 0;
		
		$('.input_gross').each(function(){
			total_gross += Number($(this).val());
		});
		
		$('.input_nett').each(function(){
			total_nett += Number($(this).val());
		});
		
		$('.input_measurement').each(function(){
			total_measurement += Number($(this).val());
		});
		
		if(isNaN(total_gross)){
			total_gross = 0;
		}
		
		if(isNaN(total_nett)){
			total_nett = 0;
		}
		
		if(isNaN(total_measurement)){
			total_measurement = 0;
		}
		
		var satuan_gross = $('#satuan_gross').val();
		var satuan_nett = $('#satuan_nett').val();
		var satuan_measurement = $('#satuan_measurement').val();
		
		
		$('#weight-measurements').html(
			'TOTAL GROSS WEIGHT : '+total_gross+' '+satuan_gross+'&#10;'+
			'TOTAL NETT WEIGHT : '+total_nett+' '+satuan_nett+'&#10;'+
			'TOTAL NETT WEIGHT : '+total_measurement+' '+satuan_measurement
		);
	}
	
	function total_package(){
		var array = [];
		
		$('.input_type_package').each(function(){
			var type = $(this).val();
			
			var value = $(this).closest('.row').find('.input_package').val();
			
			type.replace("'", "\'").replace('"', '\"');
			array.push({type, value});
		});
		
		//Group and sum by type
		var holder = {};

		array.forEach(function(d){
			d.type.replace("'", "\'").replace('"', '\"');
			
			if(holder.hasOwnProperty(d.type)){
				holder[d.type] = holder[d.type] + Number(d.value);
			}else{
				holder[d.type] = Number(d.value);
			}
		});

		var group = [];

		for(var prop in holder){
			group.push({type: prop, value: holder[prop]});
		}
		
		//Change array group to text
		if(group.length == 1){
			item = group[0]['value']+' x '+group[0]['type'];
		}else{
			$.each(group, function(index, value){
				if(index == 0){
					item = group[index]['value']+' x '+group[index]['type']+'&#10;';
				}else{
					item += group[index]['value']+' x '+group[index]['type']+'&#10;';
				}
			});
		}
		
		$('#total-container').html(item);
	}
</script>

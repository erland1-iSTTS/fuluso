<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Packages;
use app\models\MasterG3eContainer;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');

$packages = Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();

if($job->g3_type == 'LCL' || $job->g3_type == '-' || $job->g3_type == ''){
	$lcl_checked = 'checked';
	
	if($job->g3_total){
		$lcl_total = $job->g3_total;
	}else{
		$lcl_total = '';
	}
}else{
	$lcl_checked = '';
	$lcl_total = '';
}

if($job->g3_type == 'FCL'){
	$fcl_checked = 'checked';
	
	if($job->g3_total){
		$fcl_total = $job->g3_total;
	}else{
		$fcl_total = '';
	}
}else{
	$fcl_checked = '';
	$fcl_total = '';
}
?>

<div id="cargo-choose-index">
	<div class="col-12">
		<div class="form-check">
			<input class="form-check-input" type="radio" name="container_type" id="contain_type1" value="LCL" <?= $lcl_checked?> required>
			<label class="fw-normal" for="contain_type1">LCL</label>
		</div>
	</div>
	
	<div class="row" style="margin-left:20px">
		<div class="col-1 pr-0">
			<input type="number" class="form-control" name="pack_lcl_total" id="input-lcl" placeholder="0" value="<?= $lcl_total ?>">
		</div>
		<div class="col-2">
			<select class="form-select form-select-lg" name="pack_lcl_type" id="input-lcl-packages" required>
				<?php
					foreach($packages as $row){
						$name = str_replace("'", "&apos;", $row['packages_plural']);
						
						if($job->g3_type == 'LCL'){
							$pack = explode('#', $job->g3_packages);
							
							if($pack[1] == $row['packages_plural']){
								$selected = 'selected';
							}else{
								$selected = '';
							}
						}else{
							$selected = '';
						}
						
						echo "<option value='".$name."' ".$selected.">".
							$row['packages_plural'].
						"</option>";
					}
				?>
			</select>
		</div>
	</div>
	
	<div class="col-12"><hr class="mt-3"></div>
	
	<div class="col-12">
		<div class="form-check">
			<input class="form-check-input" type="radio" name="container_type" id="contain_type2" <?= $fcl_checked?> value="FCL">
			<label class="fw-normal" for="contain_type2">FCL</label>
		</div>
	</div>
	
	<div class="row" style="margin:0px 0px 10px 20px">
		<div class="col-1 pr-0">
			<input type="number" class="form-control" name="pack_fcl_total" id="input-fcl" placeholder="0" value="<?= $fcl_total ?>">
		</div>
		<div class="col-3 pt-2">
			CONTAINERS
		</div>
	</div>
	
	<div class="row" style="margin-left:20px">
		<div class="col-3 pr-0">
			<!-- Hanya container <= 30 hari lalu -->
			<select class="form-select" style="width:100%" id="container_search">
					<?php
						$now = date('Y-m-d').' 23:59:59';
						$lastday = date('Y-m-d', strtotime('-30 days')).' 00:00:00';
					
						$container_list = MasterG3eContainer::find()
											->where(['between', 'created_at', $lastday, $now])
											->andWhere(['is_active'=>1])
											->orderby(['con_code'=>SORT_ASC])
											->all();
						
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
		<div class="col-2">
			<button type="button" class="btn btn-dark" id="btn-addcon">ADD</button>
		</div>
	</div>
	
	<div class="row" id="div_con_list" style="margin:10px 0px 0px 20px;display:none;">
		<div class="col-12" id="con_list">
			<?php
				if(!empty($cargo)){
					$i = 1;
					foreach($cargo as $row){
			?>
					<div class="mr-4" style="display:inline-block;">
						<span class="con-number"><?= $i ?>.&nbsp;&nbsp;</span>
							<label><?= $row['hblcrg_name'] ?></label>
							<span class="remove-con ml-3 text-danger" onclick="removeContainer($(this))"><i class="fa fa-close"></i></span>
					</div>
				<?php $i++; } ?>
			<?php } ?>
		</div>
	</div>
	
	<div class="col-12" id="div_cargo_confirm" style="margin-left:20px;display:none;">
		<button type="button" class="btn btn-dark" id="btn_cargo_confirm" style="">Confirm</button>
	</div>
</div>

<script>
	$(document).ready(function(){
		check_complete_cargo();
		
		<?php if(!empty($cargo)){ ?>
			$('#div_con_list').show();
			$('#div_cargo_confirm').show();
		<?php } ?>
	});
	
	//check complete
	function check_complete_cargo(){
		if($('#contain_type1').is(':checked') == true){
			lcl = $('#input-lcl').val();
			pack = $('#input-lcl-packages').val(); 
			
			if(lcl !== '' && pack !== ''){
				$('#heading2 h2').removeClass('uncomplete');
				$('#heading2 h2').addClass('complete');
				$('#heading2 .row div').removeClass('uncomplete');
				$('#heading2 .row div').addClass('complete')
			}else{
				$('#heading2 h2').addClass('uncomplete');
				$('#heading2 h2').removeClass('complete');
				$('#heading2 .row div').addClass('uncomplete');
				$('#heading2 .row div').removeClass('complete');
			}
		}else{
			fcl = $('#input-fcl').val();
			con_list = $('#con_list label').length;
			
			if(fcl !== '' && con_list !== 0){
				$('#heading2 h2').removeClass('uncomplete');
				$('#heading2 h2').addClass('complete');
				$('#heading2 .row div').removeClass('uncomplete');
				$('#heading2 .row div').addClass('complete')
			}else{
				$('#heading2 h2').addClass('uncomplete');
				$('#heading2 h2').removeClass('complete');
				$('#heading2 .row div').addClass('uncomplete');
				$('#heading2 .row div').removeClass('complete');
			}
		}
	}
	
	//Button confirm to chargo input detail
	$('#btn_cargo_confirm').on('click', function(){
		$('#table-cargo-input tbody tr:not(.header)').remove();
		chargo_checked1 = $('#table-cargo input:checked');
		cargo_label = $('#con_list label');
		
		cargo_label.each(function(i){
			label = $(this).html();
			
			item = '<tr>';
				item += '<td><b>'+label+'</b><input type="hidden" class="form-control" value="'+label+'" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_name]" required></td>';
				
				item += '<td>';
					item += '<input type="text" class="form-control" placeholder="Seal Number" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_seal]" required>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-7 pr-1">';
							item += '<input type="text" class="form-control input_package" placeholder="0" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_pack_value]" onkeyup="total_package()" required>';
						item += '</div>';
						item += '<div class="col-md-5 pl-1">';
							item += '<select class="form-select form-select-lg input_type_package" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_pack_type]" onchange="total_package()" required>';
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
							item += '<input type="hidden" class="form-control input_gross_value" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_gross_value]">';
							item += '<input type="text" class="form-control input_gross1" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_gross_value1]" onkeyup="total_weight()" required>';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control input_gross2" style="height:25px" placeholder="000" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_gross_value2]" onkeyup="total_weight()" required>';
						item += '</div>';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="hidden" class="form-control input_nett_value" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_nett_value]">';
							item += '<input type="text" class="form-control input_nett1" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_nett_value1]" onkeyup="total_weight()" required>';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control input_nett2" style="height:25px" placeholder="000" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_nett_value2]" onkeyup="total_weight()" required>';
						item += '</div>';
					item += '</div>';
				item += '</td>';
				
				item += '<td>';
					item += '<div class="row">';
						item += '<div class="col-md-8 pr-1">';
							item += '<input type="hidden" class="form-control input_measurement_value" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_msr_value]">';
							item += '<input type="text" class="form-control input_measurement1" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_msr_value1]" onkeyup="total_weight()" required>';
						item += '</div>';
						item += '<div class="col-md-4 pl-1 pt-2">';
							item += '<input type="text" class="form-control input_measurement2" style="height:25px" placeholder="000" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_msr_value2]" onkeyup="total_weight()" required>';
						item += '</div>';
					item += '</div>';	
				item += '</td>';
			item += '</tr>';
			
			item += '<tr>';
				item += '<td></td>';
				item += '<td colspan="5">';
					item += '<textarea class="form-control" placeholder="Container Description" rows="5" name="MasterG3eHblCargodetail[detail]['+i+'][hblcrg_description]" required></textarea>';
				item += '</td>';
			item += '</tr>';
			
			$('#table-cargo-input tbody').append(item);
		});
		
		//Group and sum by type
		var array = [];
		
		cargo_label.each(function(i){
			var label = $(this).html();
			
			var type = label.split(' ')[2];
			var value = 1;
			
			array.push({type, value});
		});
		
		var holder = [];
		
		array.forEach(function(d){
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
			item = group[0]['value']+' X '+group[0]['type'];
		}else{
			$.each(group, function(index, value){
				if(index == 0){
					item = group[index]['value']+' X '+group[index]['type']+'&#10;';
				}else{
					item += group[index]['value']+' X '+group[index]['type']+'&#10;';
				}
			});
		}
		
		$('#total-container').html(item);
		$('#desc-hbldes_desofgood_text').html(item);
		
		$('#satuan_gross').val('KGS').trigger('change');
		$('#satuan_nett').val('KGS').trigger('change');
		$('#satuan_measurement').val('CBM').trigger('change');
	});
	
	$('#container_search').select2();
	
	// Type LCL lgsg save, Type FCL ke detail container
	$('#contain_type1, #contain_type2').on('change', function(){
		check_complete_cargo();
		
		if($('#contain_type1').is(':checked') == true){
			$('#div_con_list').hide();
			$('#div_cargo_confirm').hide();
			$('#con_list').html('');
			$('#input-fcl').val('');
		}else{
			$('#div_con_list').show();
			$('#div_cargo_confirm').show();
			$('#input-lcl').val('');
		}
	});
	
	// Change value di tab Description 
	$('#input-lcl, #input-fcl, #input-lcl-packages').on('change', function(){
		check_complete_cargo();
		
		if($('#contain_type1').is(':checked') == true){
			lcl = $('#input-lcl').val();
			pack = $('#input-lcl-packages').val(); 
			
			if(!lcl){
				lcl = 0
			}
		}else{
			fcl = $('#input-fcl').val();
			
			if(!fcl){
				fcl = 0
			}
		}
	});
	
	$('#btn-addcon').on('click', function(){
		container = $('#container_search option:selected').text();
		max_con = $('#input-fcl').val();
		con_list = $('#con_list label').length;
		con_type = $('#contain_type2').is(':checked');
		
		if(con_list < max_con && max_con != 0 && con_type == true){
			item = '<div class="mr-4" style="display:inline-block;">';
				item += '<span class="con-number">'+(con_list+1)+'.&nbsp;&nbsp;'+'</span>';
				item += '<label>'+container+'</label>';
			
				item += '<span class="remove-con ml-3 text-danger" onclick="removeContainer($(this))"><i class="fa fa-close"></i></span>';
			item += '</div>';
			
			$('#con_list').append(item);
		}
		
		check_complete_cargo();
	});
	
	function removeContainer(el){
		el.parent().remove();
		
		no = $('#con_list .con-number');
		
		//Reset all number
		no.each(function(i){
			$(this).html((i+1)+'.&nbsp;&nbsp;');
		});
		
		check_complete_cargo();
	}
	
	function total_weight(){
		// Untuk Inputan per Row
		var total_gross = 0;
		var total_nett = 0;
		var total_measurement = 0;
		
		// Untuk Description
		var total_gross2 = 0;
		var total_nett2 = 0;
		var total_measurement2 = 0;

		$('.input_gross_value').each(function(i){
			input_gross1 = Number($('.input_gross1').eq(i).val());
			input_gross2 = $('.input_gross2').eq(i).val();
			
			gross = input_gross1+'.'+input_gross2;
			total_gross += parseFloat(gross);
			total_gross2 += parseFloat(gross);
			
			$('.input_gross_value').eq(i).val(total_gross);
			total_gross = 0;
		});
		
		$('.input_nett_value').each(function(i){
			input_nett1 = Number($('.input_nett1').eq(i).val());
			input_nett2 = $('.input_nett2').eq(i).val();
			
			nett = input_nett1+'.'+input_nett2;
			total_nett += parseFloat(nett);
			total_nett2 += parseFloat(nett);
			
			$('.input_nett_value').eq(i).val(total_nett);
			total_nett = 0;
		});
		
		$('.input_measurement_value').each(function(i){
			input_measurement1 = Number($('.input_measurement1').eq(i).val());
			input_measurement2 = $('.input_measurement2').eq(i).val();
			
			measurement = input_measurement1+'.'+input_measurement2;
			total_measurement += parseFloat(measurement);
			total_measurement2 += parseFloat(measurement);
			
			$('.input_measurement_value').eq(i).val(total_measurement);
			
			total_measurement = 0;
		});
		
		if(isNaN(total_gross2)){
			total_gross = 0;
		}
		
		if(isNaN(total_nett2)){
			total_nett = 0;
		}
		
		if(isNaN(total_measurement2)){
			total_measurement = 0;
		}
		
		var satuan_gross = $('#satuan_gross').val();
		var satuan_nett = $('#satuan_nett').val();
		var satuan_measurement = $('#satuan_measurement').val();
		
		
		$('#weight-measurements').html(
			'GW : '+addSeparator(total_gross2.toFixed(3))+' '+satuan_gross+'&#10;'+
			'NW : '+addSeparator(total_nett2.toFixed(3))+' '+satuan_nett+'&#10;'+
			'MEAS : '+addSeparator(total_measurement2.toFixed(4))+' '+satuan_measurement
		);
		
		$('#desc-hbldes_weight').html(
			'GW : '+addSeparator(total_gross2.toFixed(3))+' '+satuan_gross+'&#10;'+
			'NW : '+addSeparator(total_nett2.toFixed(3))+' '+satuan_nett+'&#10;'+
			'MEAS : '+addSeparator(total_measurement2.toFixed(4))+' '+satuan_measurement
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
		console.log(array);
		//Group and sum by type
		var holder = [];

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
			item = group[0]['value']+' X '+group[0]['type'];
		}else{
			$.each(group, function(index, value){
				if(index == 0){
					item = group[index]['value']+' X '+group[index]['type']+'&#10;';
				}else{
					item += group[index]['value']+' X '+group[index]['type']+'&#10;';
				}
			});
		}
		// $('#description-goods').html(item);
	}
	
	//Thousand Separator
	function Separator(id){
		$('#'+id).keyup(function(event){
			if(event.which >= 37 && event.which <= 40) return;
			
			$(this).val(function(index, value){
				return value
					// Keep only digits, decimal points, and dashes at the start of the string:
					.replace(/[^\d.-]|(?!^)-/g, "")
					// Remove duplicated decimal points, if they exist:
					.replace(/^([^.]*\.)(.*$)/, (_, g1, g2) => g1 + g2.replace(/\./g, ''))
					// Keep only two digits past the decimal point:
					.replace(/\.(\d{2})\d+/, '.$1')
					// Add thousands separators:
					.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			});
		});
	}
	
	function clearSeparator(val){
		return val.replace(/[^\d.-]|(?!^)-/g, "");
	}
	
	function addSeparator(nStr){
		nStr += '';
		var x = nStr.split('.');
		var x1 = x[0];
		var x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
</script>

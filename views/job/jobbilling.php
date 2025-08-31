<?php
include 'koneksi.php'; 
?>

<div id="job-billing-index">
	<?php
		$customer = mysqli_query($conn, "SELECT * from customer order by customer_companyname ASC");
        $pos = mysqli_query($conn, "SELECT * from pos_v8");
        $packages = mysqli_query($conn, "SELECT * from packages");
        $currency = mysqli_query($conn, "SELECT * from currency");
		$movement = mysqli_query($conn, "SELECT * from movement");
		$signature = mysqli_query($conn, "SELECT * from signature where is_active=1");
		//place of issue
		$office = mysqli_query($conn, "SELECT * from office");
	?>

    <div id="modal-invoice-title">
        <h5>Create Invoice IDT</h5>
    </div>

    <div id="modal-invoice-body">
        <div class="row">
            <div class="col-md-1">
                <label class="fw-normal">Date</label>
            </div>
            <div class="col-md-2 pe-1">
                <div class="form-group">
                    <select class="form-select form-select-lg">
                        <?php
                            for($i=1; $i<=31; $i++){
                                echo '<option id="tgl'.$i.'" value="'.$i.'">'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 ps-1 pe-1">
                <div class="form-group">
                    <select class="form-select form-select-lg">
                        <option value="1">JAN</option>
                        <option value="2">FEB</option>
                        <option value="3">MAR</option>
                        <option value="4">APR</option>
                        <option selected value="5">MEI</option>
                        <option value="6">JUNI</option>
                        <option value="7">JULI</option>
                        <option value="8">AGS</option>
                        <option value="9">SEPT</option>
                        <option value="10">OKT</option>
                        <option value="11">NOV</option>
                        <option value="12">DES</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 ps-1 pe-1">
                <div class="form-group">
                    <select class="form-select form-select-lg">
                        <option selected value="1">2022</option>
                        <option value="2">2021</option>
                        <option value="3">2020</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Customer</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <textarea class="form-control" id="shipper_keterangan" rows="5">PRIME VALUE GENERAL TRADING LLC&#10;1406, THE BAYSWATER BY OMNIYAT&#10;AL ABRAJ STREET BUSINESS BAY,&#10;P.O.BOX 49712 DUBAI - UAE</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-1">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-1">
                        <label class="fw-normal">To</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <textarea class="form-control" id="shipper_keterangan" rows="5">PRIME VALUE GENERAL TRADING LLC&#10;1406, THE BAYSWATER BY OMNIYAT&#10;AL ABRAJ STREET BUSINESS BAY,&#10;P.O.BOX 49712 DUBAI - UAE</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table table-borderless">
                <tr>
                    <td width="5%"></td>
                    <td width="15%">Desc. of Charges</td>
                    <td width="15%">Detail</td>
                    <td width="16%">Basis</td>
                    <td width="10%">Jumlah</td>
                    <td width="10%">Satuan</td>
                    <td width="15%">Tarif</td>
                    <td width="7%">Amount</td>
                    <td width="7%">Curr</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button class="btn btn-xs btn-success rounded-pill">
                            <span class="fa fa-plus align-middle"></span>
                        </button>
                    </td>
                    <td>
                        <select class="form-select form-select-lg">
                            <?php
                                foreach($pos as $row){
                                    echo "<option value=''>".
                                        $row['pos_name'].
                                    "</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" value="">
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-6 pe-1">
                                <input type="text" class="form-control" value="3">
                            </div>
                            <div class="col-md-6 ps-1">
                                <select class="form-select form-select-lg">
                                    <?php
                                        foreach($packages as $row){
                                            echo "<option value=''>".
                                                $row['packages_name'].
                                            "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control" value="5">
                    </td>
                    <td>
                        <select class="form-select form-select-lg">
                            <?php
                                foreach($packages as $row){
                                    echo "<option value=''>".
                                        $row['packages_name'].
                                    "</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-7 pe-1">
                                <input type="text" class="form-control" value="100">
                            </div>
                            <div class="col-md-5 ps-1 pt-3">
                                <input type="text" class="form-control" style="height:25px" value="00">
                            </div>	
                        </div>
                    </td>
                    <td><p class="float-right">10,000,000.00</p></td>
                    <td>IDR</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>
                        <p>Jumlah</p>
                        <p>PPN</p>
                    </td>
                    <td>
                        <p class="float-right">10,000,000.00</p>
                        <p class="float-right">100,000.00</p>
                    </td>
                    <td>
                        <p>IDR</p>
                        <p>IDR</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>TOTAL</td>
                    <td><p class="float-right">10,100,000.00</p></td>
                    <td>IDR </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="modal-invoicehmc-title">
        <h5>Create Invoice HMC</h5>
    </div>

    <div id="modal-invoicehmc-body">
        <div class="row">
            <div class="col-md-1">
                <label class="fw-normal">Date</label>
            </div>
            <div class="col-md-2 pe-1">
                <div class="form-group">
                    <select class="form-select form-select-lg">
                        <?php
                            for($i=1; $i<=31; $i++){
                                echo '<option id="tgl'.$i.'" value="'.$i.'">'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 ps-1 pe-1">
                <div class="form-group">
                    <select class="form-select form-select-lg">
                        <option value="1">JAN</option>
                        <option value="2">FEB</option>
                        <option value="3">MAR</option>
                        <option value="4">APR</option>
                        <option selected value="5">MEI</option>
                        <option value="6">JUNI</option>
                        <option value="7">JULI</option>
                        <option value="8">AGS</option>
                        <option value="9">SEPT</option>
                        <option value="10">OKT</option>
                        <option value="11">NOV</option>
                        <option value="12">DES</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 ps-1 pe-1">
                <div class="form-group">
                    <select class="form-select form-select-lg">
                        <option selected value="1">2022</option>
                        <option value="2">2021</option>
                        <option value="3">2020</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Customer</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <textarea class="form-control" id="shipper_keterangan" rows="5">PRIME VALUE GENERAL TRADING LLC&#10;1406, THE BAYSWATER BY OMNIYAT&#10;AL ABRAJ STREET BUSINESS BAY,&#10;P.O.BOX 49712 DUBAI - UAE</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-1">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-1">
                        <label class="fw-normal">To</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select class="form-select form-select-lg" id="shipper_nick">
                                <?php
                                    foreach($customer as $row){
                                        echo "<option value='".$row['customer_nickname']."'>".
                                            $row['customer_nickname'].
                                        "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <textarea class="form-control" id="shipper_keterangan" rows="5">PRIME VALUE GENERAL TRADING LLC&#10;1406, THE BAYSWATER BY OMNIYAT&#10;AL ABRAJ STREET BUSINESS BAY,&#10;P.O.BOX 49712 DUBAI - UAE</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table table-borderless">
                <tr>
                    <td width="5%"></td>
                    <td width="15%">Desc. of Charges</td>
                    <td width="15%">Detail</td>
                    <td width="16%">Basis</td>
                    <td width="10%">Jumlah</td>
                    <td width="10%">Satuan</td>
                    <td width="15%">Tarif</td>
                    <td width="7%">Amount</td>
                    <td width="7%">Curr</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button class="btn btn-xs btn-success rounded-pill">
                            <span class="fa fa-plus align-middle"></span>
                        </button>
                    </td>
                    <td>
                        <select class="form-select form-select-lg">
                            <?php
                                foreach($pos as $row){
                                    echo "<option value=''>".
                                        $row['pos_name'].
                                    "</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" value="">
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-6 pe-1">
                                <input type="text" class="form-control" value="3">
                            </div>
                            <div class="col-md-6 ps-1">
                                <select class="form-select form-select-lg">
                                    <?php
                                        foreach($packages as $row){
                                            echo "<option value=''>".
                                                $row['packages_name'].
                                            "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control" value="5">
                    </td>
                    <td>
                        <select class="form-select form-select-lg">
                            <?php
                                foreach($packages as $row){
                                    echo "<option value=''>".
                                        $row['packages_name'].
                                    "</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-7 pe-1">
                                <input type="text" class="form-control" value="100">
                            </div>
                            <div class="col-md-5 ps-1 pt-3">
                                <input type="text" class="form-control" style="height:25px" value="00">
                            </div>	
                        </div>
                    </td>
                    <td><p class="float-right">10,000</p></td>
                    <td>USD</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>
                        <p>Jumlah</p>
                        <p>PPN</p>
                    </td>
                    <td>
                        <p class="float-right">10,000</p>
                        <p class="float-right">100</p>
                    </td>
                    <td>
                        <p>USD</p>
                        <p>USD</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>TOTAL</td>
                    <td><p class="float-right">10,100</p></td>
                    <td>USD </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
	$( document ).ready(function() {
		$('#tgl31').attr('selected','selected');
	});

    $('#cust').change(function(){
        alert("fff");
		var key = $('#shipper').val();
		ajax_address_shipper(key);
		ajax_shipper_alias(key);
		// check_complete_parties();
	});

    // shipper
	function ajax_shipper_alias(key){
		var id = 'shipper_alias';
	
		$.ajax({
			type: "POST",
			url: 'proses.php',
			data: {"key": key, "id": id},
			success: function(result){
				$("#shipper_alias").html(result);
			}
		});
	}
	
	function ajax_address_shipper(key){
		var id = 'shipper_address';
		
		$.ajax({
			type: "POST",
			url: 'proses.php',
			data: {"key": key, "id": id},
			success: function(data){
				var arr = JSON.parse(data);
				$('#shipper_keterangan').val(arr[0]['customer_address']);
			}
		});
	}
	
	$('#sign_name').change(function(){
		ajax_signature();
	});
	
	function ajax_signature(sign){
		var sign = $('#sign_name').val();
		
		$.ajax({
			type: "POST",
			url: 'proses.php',
			data: {"sign": sign},
			success: function(data){
				var arr = JSON.parse(data);
				$('#sign-full').val(arr[0]['signature_name']);
			}
		});
	}
</script>

<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobcost;
use app\models\Currency;
use app\models\Movement;
use app\models\Signature;
use app\models\Office;
?>

<div id="job-arap-index">
	<?php
		$job_invoice = MasterNewJobinvoice::find()->limit(100)->orderby(['inv_id'=>SORT_DESC])->all();
        $job_cost = MasterNewJobcost::find()->limit(100)->orderby(['vch_id'=>SORT_DESC])->all();
        $currency = Currency::find()->all();
		$movement = Movement::find()->all();
		$signature = Signature::find()->where(['is_active'=>1])->all();
		//place of issue
		$office = Office::find()->all();
	?>

    <div id="modal-pay-title">
        <h4>CASH (BKM202204014)</h4>
        <h4>BANK (BKM202204014)</h4>
    </div>

    <div id="modal-pay-body">
        <div class="row">
            <div class="col-md-2">
                <label class="fw-normal">Tanggal</label>
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
            <div class="col-md-3 ps-1">
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
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-select form-select-lg" id="shipper_nick">
                        <?php
                            foreach($job_invoice as $row){
                                echo "<option value='".$row['inv_id']."'>".
                                    "IDT ".str_pad($row['inv_id'],6,"0",STR_PAD_LEFT).
                                "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">DATE</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : 13 April 2022
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">CUSTOMER</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : PT SERBA GURIH INDONESIA
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container2">
                <table class="table" style="vertical-align: center;">
                    <thead class="">
                        <tr>
                            <th width="40%">DESCRIPTION OF CHARGES</th>
                            <th width="10%">BASIC</th>
                            <th width="10%">QUANTITY</th>
                            <th width="15%" class="float-right">AMOUNT</th>
                            <th width="20%" class="float-right">TOTAL</th>
                            <th width="5%">CURR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">EXP EXPRESS</td>
                            <td>1 SHPT</td>
                            <td>1 LCL</td>
                            <td><p class="float-right">500,000.00</p></td>
                            <td><p class="float-right">500,000.00</p></td>
                            <td>IDR</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><p class="float-right">TOTAL</p> <p class="float-right">PPN/VAT</p></td>
                            <td>
                                <p class="float-right">500,000.00</p>
                                <p class="float-right">5,500.00</p>
                            </td>
                            <td><p>IDR</p> <p>IDR</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><p class="float-right">TOTAL</p></td>
                            <td><p class="float-right">505,500.00</p></td>
                            <td>IDR</td>
                        </tr>
                        <tr>
                            <td colspan="3">LIMA RATUS LIMA RIBU LIMA RATUS RUPIAH. ---</td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Type</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms" checked>
                                <label class="fw-normal" for="radio2">ARC/BKM</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms">
                                <label class="fw-normal" for="radio2">ARB/BBM</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" placeholder="INFORMASI">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" placeholder="RATEKURS">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Amount</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-4 pe-2">
                                <div class="form-group">
                                    <select class="form-select form-select-lg">
                                        <?php
                                            foreach($currency as $row){
                                                echo "<option value=''>".
                                                    $row['currency_id'].
                                                "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 ps-3 pe-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">No Faktur</label>
                    </div>
                    <div class="col-md-2 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="040">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-2 pe-2">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox">
                        <label class="fw-normal">With PPH</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-payhmc-body">
        <div class="row">
            <div class="col-md-2">
                <label class="fw-normal">Tanggal</label>
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
            <div class="col-md-3 ps-1">
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
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-select form-select-lg" id="shipper_nick">
                        <?php
                            foreach($job_invoice as $row){
                                echo "<option value='".$row['inv_id']."'>".
                                    "HMC ".str_pad($row['inv_id'],6,"0",STR_PAD_LEFT).
                                "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">DATE</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : 13 April 2022
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">CUSTOMER</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : PT SERBA GURIH INDONESIA
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container2">
                <table class="table" style="vertical-align: center;">
                    <thead class="">
                        <tr>
                            <th width="40%">DESCRIPTION OF CHARGES</th>
                            <th width="10%">BASIC</th>
                            <th width="10%">QUANTITY</th>
                            <th width="15%" class="float-right">AMOUNT</th>
                            <th width="20%" class="float-right">TOTAL</th>
                            <th width="5%">CURR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">EXP EXPRESS</td>
                            <td>1 SHPT</td>
                            <td>1 LCL</td>
                            <td><p class="float-right">500</p></td>
                            <td><p class="float-right">500</p></td>
                            <td>USD</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><p class="float-right">TOTAL</p> <p class="float-right">PPN/VAT</p></td>
                            <td>
                                <p class="float-right">500</p>
                                <p class="float-right">55</p>
                            </td>
                            <td><p>USD</p> <p>USD</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><p class="float-right">TOTAL</p></td>
                            <td><p class="float-right">555</p></td>
                            <td>USD</td>
                        </tr>
                        <tr>
                            <td colspan="3">FIVE HUNDRED FIFTY FIVE DOLLAR. ---</td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Type</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms" checked>
                                <label class="fw-normal" for="radio2">ARC/BKM</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms">
                                <label class="fw-normal" for="radio2">ARB/BBM</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" placeholder="INFORMASI">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" placeholder="RATEKURS">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Amount</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-4 pe-2">
                                <div class="form-group">
                                    <select class="form-select form-select-lg">
                                        <?php
                                            echo "<option value=''>USD</option>";
                                            foreach($currency as $row){
                                                echo "<option value=''>".
                                                    $row['currency_id'].
                                                "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 ps-3 pe-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">No Faktur</label>
                    </div>
                    <div class="col-md-2 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="040">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-2 pe-2">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <input class="form-check-input" type="checkbox">
                        <label class="fw-normal">With PPH</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="modal-cost-title">
        <h4><b>CASH (BKM202204014)</b></h4>
        <h4><b>BANK (BKM202204014)</b></h4>
    </div>

    <div id="modal-cost-body">
        <div class="row">
            <div class="col-md-2">
                <label class="fw-normal">Tanggal</label>
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
            <div class="col-md-3 ps-1">
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
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-select form-select-lg" id="shipper_nick">
                        <?php
                            foreach($job_cost as $row){
                                echo "<option value='".$row['vch_id']."'>".
                                    "VPI ".str_pad($row['vch_id'],6,"0",STR_PAD_LEFT).
                                "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h5><b>BIAYA JOB</b></h5>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">DATE</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : 13 April 2022
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">PAY FOR</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : PT SERBA GURIH INDONESIA
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">PAY TO</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : OP
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container2">
            <table class="table" style="vertical-align: center;">
                <thead class="">
                    <tr>
                        <th width="40%">DESCRIPTION OF CHARGES</th>
                        <th width="10%">BASIC</th>
                        <th width="10%">QUANTITY</th>
                        <th width="15%" class="float-right">AMOUNT</th>
                        <th width="20%" class="float-right">TOTAL</th>
                        <th width="5%">CURR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">BIA JOB OPR 0321515</td>
                        <td>1 DOC</td>
                        <td>1 DOC</td>
                        <td><p class="float-right">35,000.00</p></td>
                        <td><p class="float-right">35,000.00</p></td>
                        <td>IDR</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><p class="float-right">TOTAL</p></td>
                        <td><p class="float-right">35,000.00</p></td>
                        <td>IDR</td>
                    </tr>
                    <tr>
                        <td colspan="3">TIGA PULUH LIMA RIBU RUPIAH. ---</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Type</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms" id="radio1" checked>
                                <label class="fw-normal" for="radio1">ARC/BKM</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms" id="radio2">
                                <label class="fw-normal" for="radio2">ARB/BBM</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" placeholder="INFORMASI">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            BKK Number : BKK2204254
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            BKK Type :
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bkk_type" id="radio2" checked>
                                <label class="fw-normal" for="radio2">OPR - JOB</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bkk_type" id="radio2">
                                <label class="fw-normal" for="radio2">Umum</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bkk_type" id="radio2">
                                <label class="fw-normal" for="radio2">Lainnya</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Amount</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-4 pe-2">
                                <div class="form-group">
                                    <select class="form-select form-select-lg">
                                        <?php
                                            foreach($currency as $row){
                                                echo "<option value=''>".
                                                    $row['currency_id'].
                                                "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 ps-3 pe-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">No Faktur</label>
                    </div>
                    <div class="col-md-2 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-2 pe-2">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-costhmc-body">
        <div class="row">
            <div class="col-md-2">
                <label class="fw-normal">Tanggal</label>
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
            <div class="col-md-3 ps-1">
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
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-select form-select-lg" id="shipper_nick">
                        <?php
                            foreach($job_cost as $row){
                                echo "<option value='".$row['vch_id']."'>".
                                    "VPI ".str_pad($row['vch_id'],6,"0",STR_PAD_LEFT).
                                "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h5><b>BIAYA JOB</b></h5>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">DATE</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : 13 April 2022
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">PAY FOR</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : PT SERBA GURIH INDONESIA
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">PAY TO</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            : OP
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container2">
            <table class="table" style="vertical-align: center;">
                <thead class="">
                    <tr>
                        <th width="40%">DESCRIPTION OF CHARGES</th>
                        <th width="10%">BASIC</th>
                        <th width="10%">QUANTITY</th>
                        <th width="15%" class="float-right">AMOUNT</th>
                        <th width="20%" class="float-right">TOTAL</th>
                        <th width="5%">CURR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">BIA JOB OPR 0321515</td>
                        <td>1 DOC</td>
                        <td>1 DOC</td>
                        <td><p class="float-right">35</p></td>
                        <td><p class="float-right">35</p></td>
                        <td>USD</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><p class="float-right">TOTAL</p></td>
                        <td><p class="float-right">35</p></td>
                        <td>USD</td>
                    </tr>
                    <tr>
                        <td colspan="3">THIRTY FIVE DOLLAR ---</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Type</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms" id="radio1" checked>
                                <label class="fw-normal" for="radio1">ARC/BKM</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freightterms" id="radio2">
                                <label class="fw-normal" for="radio2">ARB/BBM</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" placeholder="INFORMASI">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            BKK Number : BKK2204254
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            BKK Type :
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bkk_type" id="radio2" checked>
                                <label class="fw-normal" for="radio2">OPR - JOB</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bkk_type" id="radio2">
                                <label class="fw-normal" for="radio2">Umum</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal"></label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bkk_type" id="radio2">
                                <label class="fw-normal" for="radio2">Lainnya</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">Amount</label>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-4 pe-2">
                                <div class="form-group">
                                    <select class="form-select form-select-lg">
                                        <?php
                                            echo "<option value=''>USD</option>";
                                            foreach($currency as $row){
                                                echo "<option value=''>".
                                                    $row['currency_id'].
                                                "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 ps-3 pe-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="fw-normal">No Faktur</label>
                    </div>
                    <div class="col-md-2 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-2 pe-2">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    -
                    <div class="col-md-2 ps-1 pe-1">
                        <div class="form-group">
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
	/*$( document ).ready(function() {
		$('#tgl31').attr('selected','selected');
		
		ajax_signature();
	});
	
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
	}*/
</script>

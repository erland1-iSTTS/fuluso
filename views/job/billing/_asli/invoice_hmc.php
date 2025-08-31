<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>


<hr>
				<div class="container2">
				  <table class="table" style="vertical-align: center;">
					<thead class="bg-secondary2">
					  <tr>
						<th width="13%">Invoice No</th>
						<th width="10%">Date</th>
						<th width="28%">To</th>
						<th width="15%" class="float-middle">Amount</th>
						<th width="12%"></th>
						<th width="10%"></th>
						<th width="12%"></th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td scope="row">HMC004698</td>
						<td>5 Mar 2022</td>
						<td>PT THE MASTER STEEL MANUFACTORY</td>
						<td><p class="text-right">1,500 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">HMC004699</td>
						<td>4 Mar 2022</td>
						<td>AHASEES GENERAL TRADING LLC</td>
						<td><p class="text-right">800 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">HMC004688</td>
						<td>3 Mar 2022</td>
						<td>LAMBERTI BROS (WHOLESALE) PTY LTD.</td>
						<td><p class="text-right">2,770 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs" onclick="hidetableHMC();">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>

					  <tr style="display:none" class="bg-gray" id="hmc_table">
						<td colspan="2"></td>
						<td colspan="5">
						<div style="border: 1px solid black;">
						  <table class="table" style="vertical-align: center;">
							<thead class="bg-secondary2">
							  <tr>
								<th width="15%">Voucher No</th>
								<th width="15%">Date</th>
								<th width="25%">Pay For</th>
								<th width="10%">Pay To</th>
								<th width="20%" class="float-middle">Amount</th>
								<th width="15%"></th>
							  </tr>
							</thead>
							<tbody>
							  <tr class="bg-white">
								<td scope="row">VPI220585</td>
								<td>5 Mar 2022</td>
								<td>PT MITRA PRODIN</td>
								<td>MSC</td>
								<td><p class="text-right">1,500 USD</p></td>
								<td>
								   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
								   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
								</td>
							  </tr>
							  <tr class="bg-white">
								<td scope="row">VPI220489</td>
								<td>4 Mar 2022</td>
								<td>PT. GLOBAL ABADI JAYA</td>
								<td>MSC</td>
								<td><p class="text-right">2,770 USD</p></td>
								<td>
								   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
								   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
								</td>
							  </tr>
							  <tr class="bg-white">
								<td scope="row">VPI220789</td>
								<td>3 Mar 2022</td>
								<td>PT. CAHAYA TERANG</td>
								<td>ACH</td>
								<td><p class="text-right">800 USD</p></td>
								<td>
								   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
								   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
								</td>
							  </tr>
							</tbody>
						  </table>
						</div><br>
						<div class="text-right"><a class="btn btn-dark" onclick="showModalInvHMC()" data-toggle="modal" data-target="#createinvidtmodal">Create Cost Voucher</a></div>
						</td>
					  </tr>

					  <tr class="bg-light-red">
						<td scope="row">HMC004682</td>
						<td>2 Mar 2022</td>
						<td>SL FRAZER ENTERPRISES PTY LTD.</td>
						<td><p class="text-right">720 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr class="bg-light-red">
						<td scope="row">HMC004687</td>
						<td>1 Mar 2022</td>
						<td>PLATINUM RP PTY LTD.</td>
						<td><p class="text-right">16,800 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					</tbody>
				  </table>
				</div>
				<hr>
				<div class="container"><a class="btn btn-dark">Create Invoice</a></div><br>
				
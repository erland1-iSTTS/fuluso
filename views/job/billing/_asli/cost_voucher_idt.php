<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<hr>
				<div class="container2">
				  <table class="table">
					<thead class="bg-secondary2">
					  <tr>
						<th>Voucher No</th>
						<th>Created Date</th>
						<th>Transaction Date</th>
						<th>Source</th>
						<th>Tipe</th>
						<th>Method</th>
						<th class="float-middle">Amount</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td scope="row">VOR 09705</td>
						<td>5 Mar 2022</td>
						<td>5 Mar 2022</td>
						<td>Kas</td>
						<td>Pokok</td>
						<td>Kas</td>
						<td><p class="text-right">500,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">VOR 09704</td>
						<td>4 Mar 2022</td>
						<td>4 Mar 2022</td>
						<td>Kas</td>
						<td>Pokok</td>
						<td>Kas</td>
						<td><p class="text-right">800,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr onclick="hidetable2();">
						<td scope="row">VOR 09703</td>
						<td>3 Mar 2022</td>
						<td>3 Mar 2022</td>
						<td>B1838R</td>
						<td>Variable</td>
						<td>Transfer</td>
						<td><p class="text-right">770,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>

					  <tr style="display:none" class="bg-gray" id="cost_table2">
						<td colspan="2"></td>
						<td colspan="6">
						<div style="border: 1px solid black;">
						  <table class="table" style="vertical-align: center;">
							<thead  class="bg-secondary2">
							  <tr>
								<th width="">POS</th>
								<th width="">DETAIL</th>
								<th width="">QTY</th>
								<th width="">UNIT</th>
								<th width="" class="float-middle">AMOUNT</th>
								<th width="" class="float-middle">TOTAL</th>
							  </tr>
							</thead>
							<tbody>
							  <tr class="bg-white">
								<td scope="row">BIA TELKOM</td>
								<td>SPEEDY JK 22-04</td>
								<td>1</td>
								<td>UNIT</td>
								<td><p class="text-right">373.450,00</p></td>
								<td><p class="text-right">373.450,00</p></td>
							  </tr>
							</tbody>
						  </table>
						</div>
						</td>
					  </tr>

					  <tr>
						<td scope="row">VOR 09702</td>
						<td>2 Mar 2022</td>
						<td>2 Mar 2022</td>
						<td>Kas</td>
						<td>Variable</td>
						<td>Cash</td>
						<td><p class="text-right">320,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">VOR 09701</td>
						<td>1 Mar 2022</td>
						<td>1 Mar 2022</td>
						<td>Kas</td>
						<td>Variable</td>
						<td>Transfer</td>
						<td><p class="text-right">800,000 IDR</p></td>
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
				<div class="container"><a class="btn btn-dark">Create Cost Voucher</a></div><br>
				
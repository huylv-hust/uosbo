<div class="container">
	<h3>
		コンシェルジュ詳細
	</h3>

	<form class="form-inline">

		<table class="table table-striped">
			<tbody><tr>
					<th class="text-right">登録時刻</th>
					<td><?php echo $model->created_at; ?></td>
				</tr>
				<tr>
					<th class="text-right">氏名(全角)</th>
					<td><?php echo $model->name; ?></td>
				</tr>
				<tr>
					<th class="text-right">氏名(ふりがな)</th>
					<td><?php echo $model->name_kana; ?></td>
				</tr>

				<tr>
					<th class="text-right">生年月日</th>
					<td>
                        <?php echo $model->birthday; ?>
                        <span class="text-success">（現在年齢：<?php echo Utility::calcAge($model->birthday) ?>歳）</span>
                    </td>
				</tr>

				<tr>
					<th class="text-right">性別</th>
					<td><?php echo $model->gender == 1 ? '男性' : '女性'; ?></td>
				</tr>
				<tr>
					<?php $addr1 = $model->addr1; ?>
					<th class="text-right">住所</th>
					<td>
						〒<?php echo substr($model->zipcode, 0, 3).'-'.substr($model->zipcode, 3, 7); ?>
						<?php echo isset(\Constants::$address_1[$addr1]) ? \Constants::$address_1[$addr1].' ' : ''; ?>
						<?php echo $model->addr2.' '.$model->addr3; ?>
					</td>
				</tr>
				<tr>
					<th class="text-right">固定電話番号</th>
					<td><?php echo $model->mobile_home; ?></td>
				</tr>
				<tr>
					<th class="text-right">携帯電話番号</th>
					<td><?php echo $model->mobile; ?></td>
				</tr>
				<tr>
					<th class="text-right">メールアドレス1</th>
					<td><?php echo $model->mail; ?></td>
				</tr>
				<tr>
					<th class="text-right">メールアドレス2</th>
					<td><?php echo $model->mail2; ?></td>
				</tr>
				<tr>
					<th class="text-right">現在職業</th>
					<td>
						<?php $occupation_now = $model->occupation_now;?>
						<?php echo isset(\Constants::$occupation_now[$occupation_now]) ? \Constants::$occupation_now[$occupation_now] : ''; ?>
					</td>
				</tr>
				<tr>
					<th class="text-right">その他備考</th>
					<td>
						<?php echo nl2br($model->notes); ?>
					</td>
				</tr>
			</tbody></table>
		<?php
		$return_url = \Uri::base().'support/concierges';
		if(\Cookie::get('register_url_search')){
			$return_url = \Cookie::get('register_url_search');
		}
		?>
		<div class="text-center">
			<button type="button" onclick="window.location='<?php echo $return_url; ?>'" class="btn btn-warning btn-sm" name="back-btn">
				<i class="glyphicon glyphicon-step-backward icon-white"></i>
				戻る
			</button>
		</div>

	</form>

</div>

<div class="container">
			<h3>
				採用者
				<div class="text-right">
					<?php $filter = \Fuel\Core\Session::get('url_filter_persons') ? str_replace('export','',\Fuel\Core\Session::get('url_filter_persons')) : '';?>
					<a href="<?php echo Uri::base(true).'obic7/persons?'.$filter?>" class="btn btn-warning btn-sm">
						<i class="glyphicon glyphicon-step-backward icon-white"></i>戻る
					</a>

				</div>
			</h3>

			<form class="form-inline">

				<table class="table table-striped">
					<tbody><tr>
						<th class="text-right">インポート設定日</th>
						<td><?php echo $info['obic7_date'] ? $info['obic7_date'] : '' ?></td>
					</tr>
					<tr>
						<th class="text-right">応募日時</th>
						<td><?php echo $info['application_date'] ? $info['application_date'] : '' ?></td>
					</tr>
					<tr>
						<th class="text-right">対象SS</th>
                        <td><?php echo $info['group_name'] .'&#12288;'. $info['branch_name'] .'&#12288;'. $info['ss_name']?></td>
					</tr>
					<tr>
						<th class="text-right">氏名</th>
						<td><?php echo $info['name'] ? $info['name'] : '' ?></td>
					</tr>

					<tr>
						<th class="text-right">氏名かな</th>
                        <td><?php echo $info['name_kana'] ? $info['name_kana'] : '' ?></td>
					</tr>

                    <?php if($info['birthday']){?>
					<tr>
						<th class="text-right">生年月日</th>
                        <td><?php echo $info['birthday']?></td>
					</tr>
                    <?php }
                    if ($info['age']) {?>
					<tr>
						<th class="text-right">年齢</th>
                        <td><?php echo $info['age'].'歳'?></td>
					</tr>
                    <?php }?>
					<tr>
						<th class="text-right">性別</th>
                        <td><?php echo $info['gender'] == 0 ? '男 ' : '女' ?></td>
					</tr>
					<tr>
                        <?php $zipcode = $info['zipcode'] ? '〒 '.substr($info['zipcode'], 0, 3).'-'.substr($info['zipcode'], 3, 6) : ''?>
						<th class="text-right">住所</th>
						<td><?php echo $zipcode.'&#12288;'.Constants::$address_1[$info['addr1']].'&#12288;'.$info['addr2'].'&#12288;'.$info['addr3']?></td>
                    </tr>
					<tr>
						<th class="text-right">電話番号</th>
						<td>
							<div><?php echo $info['mobile'] ? '(携帯)'.$info['mobile'] : ''?></div>
							<div><?php echo $info['tel'] ? '(固定)'.$info['tel'] : ''?></div>
						</td>
					</tr>
                    <tr>
						<th class="text-right">メールアドレス1</th>
						<td><?php echo $info['mail_addr1'] ? $info['mail_addr1'] : ''?></td>
					</tr>
                    <tr>
						<th class="text-right">メールアドレス2</th>
                        <td><?php echo $info['mail_addr2'] ? $info['mail_addr2'] : ''?></td>
					</tr>
                    <tr>
						<th class="text-right">現在職業</th>
						<td><?php echo $info['occupation_now'] ? Constants::$occupation_now[$info['occupation_now']] : ''?></td>
					</tr>
					<tr>
						<th class="text-right">現在職業補足</th>
                        <td><?php echo $info['repletion'] ? $info['repletion'] : ''?></td>
					</tr>
					<tr>
						<th class="text-right">メモ１</th>
                        <td><?php echo $info['memo_1'] ? nl2br($info['memo_1']) : ''?></td>
					</tr>
					<tr>
						<th class="text-right">メモ２</th>
                        <td><?php echo $info['memo_2'] ? nl2br($info['memo_2']) : ''?></td>
					</tr>
					<tr>
						<th class="text-right">希望・備考など</th>
                        <td><?php echo $info['notes'] ? nl2br($info['notes']) : ''?></td>
					</tr>

					<tr>
						<th class="text-right">営業担当</th>
						<td><?php echo $info['business_user'] && $info['business_department']  ?  Constants::$department[$info['business_department']].'&#12288;'.$info['business_user'] : ''?></td>
					</tr>
					<tr>
						<th class="text-right">面接担当</th>
						<td><?php echo $info['interview_user'] && $info['interview_department']  ?  Constants::$department[$info['interview_department']].'&#12288;'.$info['interview_user'] : ''?></td>
					</tr>
					<tr>
						<th class="text-right">契約担当</th>
						<td><?php echo $info['agreement_user'] && $info['agreement_department']  ?  Constants::$department[$info['agreement_department']].'&#12288;'.$info['agreement_user'] : ''?></td>
					</tr>
					<tr>
						<th class="text-right">研修担当</th>
						<td><?php echo $info['training_user'] && $info['training_department']  ?  Constants::$department[$info['training_department']].'&#12288;'.$info['training_user'] : ''?></td>
					</tr>
				</tbody></table>

			</form>

		</div>

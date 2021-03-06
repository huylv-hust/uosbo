<?php echo \Fuel\Core\Asset::js('validate/person.js')?>
		<div class="container">
			<h3>
				応募者
			</h3>
			<?php
				if( isset($is_view))
				{
					foreach(Model_Person::$_my_properties as $k => $v)
					{
						if(array_key_exists($v, $is_view)){
							?>
							<div class="edit-before edit-display-show bottom-space edit-display-none">
								※この枠内は変更前の内容を記載しています
							</div>
							<?php
							break;
						}
					}
				}
			?>
			<p class="text-center <?php if( ! $person_info) echo 'hide'?>">
				<a href="<?php echo \Fuel\Core\Uri::base()?>job/person?person_id=<?php echo $person_id; ?>">応募者</a>
				|
				<a href="<?php echo \Fuel\Core\Uri::base()?>job/employment?person_id=<?php echo $person_id; ?>">採用管理</a>
				|
				<a href="<?php echo \Fuel\Core\Uri::base()?>job/personfile?person_id=<?php echo $person_id; ?>">本人確認書類</a>
				|
				<a href="<?php echo \Fuel\Core\Uri::base()?>job/interviewusami?person_id=<?php echo $person_id; ?>">面接票</a>
				|
				<a href="<?php echo \Fuel\Core\Uri::base()?>job/emcall?person_id=<?php echo $person_id; ?>">緊急連絡先</a>
			</p>

			<form class="form-inline" method="POST" action="" id="person">
				<p class="text-right">
					<a class="btn btn-warning btn-sm" href="<?php if(\Fuel\Core\Cookie::get('person_url')) echo \Fuel\Core\Cookie::get('person_url'); else echo Uri::base(true).'job/persons'?>">
							<i class="glyphicon glyphicon-arrow-left icon-white"></i>
							戻る
					</a>
				</p>
				<table class="table table-striped">
					<?php

						$application_date =  '';
						$time='';
						for($i=0;$i<=23;++$i){
							if($i < 10){ $i = '0'.$i; }
							$listHours[$i] = $i;
						}
						for($i=0;$i<=59;++$i){
							if($i < 10){ $i = '0'.$i; }
							$listMinute[$i] = $i;
						}

						if($person_info['application_date'])
						{
							$application_date = explode(' ', $person_info['application_date']);
							$time = explode(':',$application_date[1]);
						}
						if(isset($edit_person['application_date']))
						{
							$edit_application_date = explode(' ', $edit_person['application_date']);
							$edit_time = explode(':',$edit_application_date[1]);
						}

					?>
					<tr>
						<th class="text-right">オーダーID</th>
						<td>
							<?php echo Form::input('order_id', Input::post('order_id', isset($edit_person['order_id']) ? $edit_person['order_id'] : \Fuel\Core\Input::get('order_id')), array('class' => 'form-control', 'size' => 10)); ?>
							<span class="text-info">※任意</span>
							<label class="checkbox-inline">
								<input type="checkbox" name="reprinted_via" value="1" <?php if($edit_person['reprinted_via'] ==1) echo "checked"?>>WEB転載経由</label>
							<div class="edit-before <?php echo isset($is_view['order_id']) ? $is_view['order_id'] : '' ?>">
								<?php
								//Get array address
								echo Form::input('order_id', Input::post('order_id', isset($person_info['order_id']) ? $person_info['order_id'] : \Fuel\Core\Input::get('order_id')), array('class' => 'form-control', 'size' => 10, 'disabled' =>'true'));
								?>
								<span class="text-info">※任意</span>
								<label class="checkbox-inline"><input type="checkbox" name="reprinted_via" value="1" <?php if($person_info['reprinted_via'] ==1) echo "checked"?> disabled="disabled">WEB転載経由</label>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">応募日時</th>
						<td>
							<?php echo Form::input('application_date_d', Input::post('application_date_d', isset($post) ? $post->application_date_d : $edit_person['application_date'] != 0 ? $edit_application_date[0] : ''), array('class' => 'form-control dateform', 'size' => 25)); ?>

							<?php echo Form::select('application_date_h', Input::post('application_date_h',isset($post) ? $post->application_date_h : $edit_person['application_date']? $edit_time[0]:''),$listHours, array('class'=>'form-control')); ?>
							:
							<?php echo Form::select('application_date_m', Input::post('application_date_m',isset($post) ? $post->application_date_m :$edit_person['application_date']? $edit_time[1]:''),$listMinute , array('class'=>'form-control')); ?>

							<div class="edit-before <?php echo isset($is_view['application_date']) ? $is_view['application_date'] : '' ?>">

									<?php echo Form::input('application_date_d', Input::post('application_date_d', isset($post) ? $post->application_date_d :$person_info['application_date'] != 0 ? $application_date[0] : ''), array('class' => 'form-control dateform', 'size' => 25, "disabled")); ?>

									<?php echo Form::select('application_date_h', Input::post('application_date_h',isset($post) ? $post->application_date_h :$person_info['application_date']? $time[0]:''),$listHours, array('class'=>'form-control', 'disabled')); ?>
									:
									<?php echo Form::select('application_date_m', Input::post('application_date_m',isset($post) ? $post->application_date_m :$person_info['application_date']? $time[1]:''),$listMinute , array('class'=>'form-control', 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr class="presenter">
						<th class="text-right">対象SS</th>
						<td>
							<?php echo $filtergroup?>
						</td>
					</tr>
					<tr>
					<th class="text-right">
							掲載媒体
							<!--button type="button" class="btn btn-success btn-sm" name="add-media-btn">
								<i class="glyphicon glyphicon-plus icon-white"></i>
							</button-->
						</th>
						<td id="medias">
							<div class="media-append">
							<?php
								if($post_id){
									echo \Presenter::forge('group/mediaorder')->set(array('post_id' => $post_id));
								}else{
									echo \Presenter::forge('group/mediaorder')->set(array('post_id' => $edit_person['post_id']));
							?>
									<div class="presenter-edit edit-before <?php echo isset($is_view['post_id']) ? $is_view['post_id'] : '' ?>">
										<?php
										echo \Presenter::forge('group/mediaorder')->set(array('post_id' => $person_info['post_id']));
										?>
									</div>

							<?php
								}
								?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">応募対象求人</th>
						<td>
							<?php
								$person_info_id = $person_info['job_id'] ? $person_info['job_id'] : 0;
								$edit_job_id = $edit_person['job_id'] ? $edit_person['job_id'] : 0;
							?>
							<?php echo Form::select('job_id', Input::post('job_id', isset($post) ? $post->job_id : $edit_job_id), $job_id, array('class'=>'form-control')); ?>
							<div class="text-info">※おしごとnavi経由の場合</div>
							<div class="edit-before <?php echo isset($is_view['job_id']) ? $is_view['job_id'] : '' ?>">
								<?php echo Form::select('job_id', Input::post('job_id', isset($post) ? $post->job_id : $person_info_id), $job_id, array('class'=>'form-control', 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">氏名</th>
						<td>
							<div class="input-group">
								<div class="input-group-addon">漢字</div>
								<?php echo Form::input('name', Input::post('name', isset($post) ? $post->name :$edit_person['name']), array('class' => 'form-control', 'size' => 25)); ?>
							</div>
							<div class="input-group">
								<div class="input-group-addon">かな</div>
								<?php echo Form::input('name_kana', Input::post('name_kana', isset($post) ? $post->name_kana :$edit_person['name_kana']), array('class' => 'form-control', 'size' => 25)); ?>
							</div>
							<div class="edit-before <?php echo isset($is_view['name']) ? $is_view['name'] : '' ?> <?php echo isset($is_view['name_kana']) ? $is_view['name_kana'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">漢字</div>
									<?php echo Form::input('name', Input::post('name', isset($post) ? $post->name :$person_info['name']), array('class' => 'form-control', 'size' => 25, 'disabled')); ?>
								</div>
								<div class="input-group">
									<div class="input-group-addon">かな</div>
									<?php echo Form::input('name_kana', Input::post('name_kana', isset($post) ? $post->name_kana :$person_info['name_kana']), array('class' => 'form-control', 'size' => 25, 'disabled')); ?>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<th class="text-right">生年月日</th>
						<td>
							<?php
								echo \Fuel\Core\Form::select('year',\Fuel\Core\Input::post('year',isset($edit_person) ? substr($edit_person['birthday'],0,4) : ''),Constants::list_year_jp(),array('class' => 'form-control'));
							?>
							<span class="text-info">年</span>
							<?php
							echo \Fuel\Core\Form::select('month',\Fuel\Core\Input::post('month',isset($edit_person) ? substr($edit_person['birthday'],5,2) : ''),Constants::list_month(),array('class' => 'form-control'));
							?>
							<span class="text-info">月</span>
							<?php
							echo \Fuel\Core\Form::select('day',\Fuel\Core\Input::post('day',isset($edit_person) ? substr($edit_person['birthday'],8,2) : ''),Constants::list_day(),array('class' => 'form-control'));
							?>
							<span class="text-info">日</span>

							<?php echo Form::input('birthday', Input::post('birthday', isset($post) ? $post->birthday :$edit_person['birthday']), array('class' => 'form-control dateform', 'size' => 25, 'type' => 'hidden')); ?>
							<span class="text-success">
								(
									現在年齢：<span id="age_1">0</span>才
									応募時年齢：<span id="age_2">0</span>才
								)
								</span>

							<div class="edit-before <?php echo isset($is_view['birthday']) ? $is_view['birthday'] : '' ?>">
								<?php
									echo \Fuel\Core\Form::select('year',\Fuel\Core\Input::post('year',isset($person_info) ? substr($person_info['birthday'],0,4) : ''),Constants::list_year_jp(),array('class' => 'form-control', 'disabled'));
								?>
								<span class="text-info">年</span>
								<?php
									echo \Fuel\Core\Form::select('month',\Fuel\Core\Input::post('month',isset($person_info) ? substr($person_info['birthday'],5,2) : ''),Constants::list_month(),array('class' => 'form-control', 'disabled'));
								?>
								<span class="text-info">月</span>
								<?php
									echo \Fuel\Core\Form::select('day',\Fuel\Core\Input::post('day',isset($person_info) ? substr($person_info['birthday'],8,2) : ''),Constants::list_day(),array('class' => 'form-control', 'disabled'));
								?>
								<span class="text-info">日</span>
							</div>
						</td>
					</tr>

					<tr>
						<th class="text-right">年齢</th>
						<td>
							<div class="input-group">
								<?php echo Form::input('age', Input::post('age', isset($post) ? $post->age :$edit_person['age']), array('class' => 'form-control', 'size' => 4)); ?>
								<div class="input-group-addon">歳</div>
							</div>
							<span class="text-info">※生年月日が指定されている場合は無効</span>
							<div class="edit-before <?php echo isset($is_view['age']) ? $is_view['age'] : '' ?>">
								<div class="input-group">
									<?php echo Form::input('age', Input::post('age', isset($post) ? $post->age :$person_info['age']), array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
									<div class="input-group-addon">歳</div>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<th class="text-right">性別</th>
						<td>
							<label class="radio-inline"><?php echo Form::radio('gender', '0',Input::post('gender', isset($post) ? $post->gender : isset($edit_person['gender']) ? $edit_person['gender'] : '')); ?>男</label>
							<label class="radio-inline"><?php echo Form::radio('gender', '1',Input::post('gender', isset($post) ? $post->gender : isset($edit_person['gender']) ? $edit_person['gender'] : '' )); ?>女</label>
							<div class="edit-before <?php echo isset($is_view['gender']) ? $is_view['gender'] : '' ?>">
								<label class="radio-inline"><?php echo Form::radio('gender_view', '0', isset($person_info['gender']) ? $person_info['gender'] : '', array('disabled')); ?>男</label>
								<label class="radio-inline"><?php echo Form::radio('gender_view', '1', isset($person_info['gender']) ? $person_info['gender'] : '', array('disabled')); ?>女</label>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">郵便番号</th>
						<td>
							<?php
//								$zipcode = null ;
//								if($person_info['zipcode'])
//								$zipcode = $person_info['zipcode'];
							?>
							<?php echo Form::input('zipcode1', Input::post('zipcode1', isset($post) ? $post->zipcode1 :substr($edit_person['zipcode'], 0, 3)), array('class' => 'form-control', 'size' => 4 ,'maxlength' => 3)); ?>
							-
							<?php echo Form::input('zipcode2', Input::post('zipcode2', isset($post) ? $post->zipcode2 :substr($edit_person['zipcode'], 3, 6)), array('class' => 'form-control', 'size' => 2 ,'maxlength' => 4)); ?>
							<div class="edit-before <?php echo isset($is_view['zipcode']) ? $is_view['zipcode'] : '' ?>">
								<?php echo Form::input('zipcode1', isset($person_info['zipcode']) ? substr($person_info['zipcode'], 0, 3) : '', array('class' => 'form-control', 'size' => 4 ,'maxlength' => 3, 'disabled')); ?>
								-
								<?php echo Form::input('zipcode2', isset($person_info['zipcode']) ? substr($person_info['zipcode'], 3, 6) : '', array('class' => 'form-control', 'size' => 2 ,'maxlength' => 4, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">都道府県</th>
						<td>
							<?php echo Form::select('addr1', Input::post('addr1', isset($post) ? $post->addr1 : $edit_person['addr1']), \Constants::get_create_address(), array('class'=>'form-control')); ?>

							<div class="input-group">
								<div class="input-group-addon">市区町村</div>
								<?php echo Form::input('addr2', Input::post('addr2', isset($post) ? $post->addr2 :$edit_person['addr2']), array('class' => 'form-control', 'size' => 20)); ?>
							</div>

							<div class="edit-before <?php echo isset($is_view['addr1']) ? $is_view['addr1'] : '' ?> <?php echo isset($is_view['addr2']) ? $is_view['addr2'] : '' ?>">
								<?php echo Form::select('addr1', Input::post('addr1', isset($post) ? $post->addr1 : $person_info['addr1']), \Constants::get_create_address(), array('class'=>'form-control', 'disabled')); ?>

								<div class="input-group">
									<div class="input-group-addon">市区町村</div>
									<?php echo Form::input('addr2', Input::post('addr2', isset($post) ? $post->addr2 :$person_info['addr2']), array('class' => 'form-control', 'size' => 20, 'disabled')); ?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">以降の住所</th>
						<td>
							<?php echo Form::input('addr3', Input::post('addr3', isset($post) ? $post->addr3 :$edit_person['addr3']), array('class' => 'form-control', 'size' => 80)); ?>
							<div class="edit-before <?php echo isset($is_view['addr3']) ? $is_view['addr3'] : '' ?>">
								<?php echo Form::input('addr3', isset($person_info['addr3']) ? $person_info['addr3'] : '', array('class' => 'form-control', 'size' => 80, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">電話番号</th>
						<td>
							<div class="input-group">
								<div class="input-group-addon">携帯</div>
								<?php echo Form::input('mobile_1', Input::post('mobile_1', isset($post) ? $post->mobile_1 : ($edit_person['mobile'] != '' ? explode('-', $edit_person['mobile'])[0] : '')), array('class' => 'form-control', 'size' => 4 , 'maxlength' => 4)); ?>
							</div>
							-
							<?php echo Form::input('mobile_2', Input::post('mobile_2', isset($post) ? $post->mobile_2 :($edit_person['mobile'] != '' ? explode('-', $edit_person['mobile'])[1] : '')), array('class' => 'form-control', 'size' => 4 ,'maxlength' => 4)); ?>
							-
							<?php echo Form::input('mobile_3', Input::post('mobile_3', isset($post) ? $post->mobile_3 :($edit_person['mobile'] != '' ? explode('-', $edit_person['mobile'])[2] : '')), array('class' => 'form-control', 'size' => 4 ,'maxlength' => 4)); ?>
							<div class="input-group">
								<div class="input-group-addon">固定</div>
								<?php echo Form::input('tel_1', Input::post('tel_1', isset($post) ? $post->tel_1 : ($edit_person['tel'] != '' ? explode('-', $edit_person['tel'])[0] : '')), array('class' => 'form-control', 'size' => 4 ,'maxlength' => 4)); ?>
							</div>
							-
							<?php echo Form::input('tel_2', Input::post('tel_2', isset($post) ? $post->tel_2 : ($edit_person['tel'] != '' ? explode('-', $edit_person['tel'])[1] : '')), array('class' => 'form-control', 'size' => 4 ,'maxlength' => 4)); ?>
							-
							<?php echo Form::input('tel_3', Input::post('tel_3', isset($post) ? $post->tel_3 : ($edit_person['tel'] != '' ? explode('-', $edit_person['tel'])[2] : '')), array('class' => 'form-control', 'size' => 4 ,'maxlength' => 4)); ?>

							<span class="text-info">※いずれか必須</span>

							<div class="edit-before <?php echo isset($is_view['tel']) ? $is_view['tel'] : '' ?> <?php echo isset($is_view['mobile']) ? $is_view['mobile'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">携帯</div>
									<?php echo Form::input('mobile_1', $person_info['mobile'] != '' ? explode('-', $person_info['mobile'])[0] : '', array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
								</div>
								-
								<?php echo Form::input('mobile_2', $person_info['mobile'] != '' ? explode('-', $person_info['mobile'])[1] : '', array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
								-
								<?php echo Form::input('mobile_3', $person_info['mobile'] != '' ? explode('-', $person_info['mobile'])[2] : '', array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
								<div class="input-group">
									<div class="input-group-addon">固定</div>
									<?php echo Form::input('tel_1', $person_info['tel'] != '' ? explode('-', $person_info['tel'])[0] : '', array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
								</div>
								-
								<?php echo Form::input('tel_2', $person_info['tel'] != '' ? explode('-', $person_info['tel'])[1] : '', array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
								-
								<?php echo Form::input('tel_3', $person_info['tel'] != '' ? explode('-', $person_info['tel'])[2] : '', array('class' => 'form-control', 'size' => 4, 'disabled')); ?>
							</div>
						</td>
					</tr>

					<tr>
						<th class="text-right">メールアドレス1</th>
						<td>
							<?php echo Form::input('mail_addr1', Input::post('mail_addr1', isset($post) ? $post->mail_addr1 :$edit_person['mail_addr1']), array('class' => 'form-control', 'size' => 80)); ?>
							<div class="edit-before <?php echo isset($is_view['mail_addr1']) ? $is_view['mail_addr1'] : '' ?>">
								<?php echo Form::input('mail_addr1', isset($person_info['mail_addr1']) ? $person_info['mail_addr1'] : '', array('class' => 'form-control', 'size' => 80, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">メールアドレス2</th>
						<td>
							<?php echo Form::input('mail_addr2', Input::post('mail_addr2', isset($post) ? $post->mail_addr2 : $edit_person['mail_addr2']), array('class' => 'form-control', 'size' => 80)); ?>
							<div class="edit-before <?php echo isset($is_view['mail_addr2']) ? $is_view['mail_addr2'] : '' ?>">
								<?php echo Form::input('mail_addr2', isset($person_info['mail_addr2']) ? $person_info['mail_addr2'] : '', array('class' => 'form-control', 'size' => 80, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">現在職業</th>
						<td>
							<?php echo Form::select('occupation_now', Input::post('occupation_now', isset($post) ? $post->occupation_now : $edit_person['occupation_now']), \Constants::$occupation_now, array('class'=>'form-control')); ?>
							<div class="edit-before <?php echo isset($is_view['occupation_now']) ? $is_view['occupation_now'] : '' ?>">
								<?php echo Form::select('occupation_now', isset($person_info['occupation_now']) ? $person_info['occupation_now'] : '', \Constants::$occupation_now, array('class'=>'form-control', 'disabled')); ?>
							</div>
						</td>
					</tr>

					<tr>
						<th class="text-right">現在職業補足</th>
						<td>
							<?php echo Form::input('repletion', Input::post('repletion', isset($post) ? $post->repletion : $edit_person['repletion']), array('class' => 'form-control', 'size' => 80)); ?>
							<div class="edit-before <?php echo isset($is_view['repletion']) ? $is_view['repletion'] : '' ?>">
								<?php echo Form::input('repletion', isset($person_info['repletion']) ? $person_info['repletion'] : '', array('class'=>'form-control', 'size' => 80, 'disabled')); ?>
							</div>
						</td>
					</tr>

					<tr>
						<th class="text-right">交通手段</th>
						<td>
							<?php
								$transportation = explode(',', $edit_person['transportation']);
								$view_transportation = explode(',', $person_info['transportation']);
							function edit_before_label($i, $edit_person, $person_info)
							{
								$string_edit = $edit_person . $person_info;
								if (substr_count($string_edit, $i) == 1) {
									return 'edit-before-label';
								}
							}

							?>
							<div class="row">
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="transportation[]" value="0" <?php if(isset($_POST['transportation'][0])){echo 'checked';}else{if((array_search('0',$transportation))){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('0', $edit_person['transportation'], $person_info['transportation']); ?>">徒歩</span>
									</label>
								</div>
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="transportation[]" value="1" <?php if(isset($_POST['transportation'][1])){echo 'checked';}else{if((array_search('1',$transportation))){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('1', $edit_person['transportation'], $person_info['transportation']); ?>">自転車</span>
									</label>
								</div>
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="transportation[]" value="2" <?php if(isset($_POST['transportation'][2])){echo 'checked';}else{if((array_search('2',$transportation))){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('2', $edit_person['transportation'], $person_info['transportation']); ?>">バイク</span>
									</label>
								</div>
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="transportation[]" value="3" <?php if(isset($_POST['transportation'][3])){echo 'checked';}else{if((array_search('3',$transportation))){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('3', $edit_person['transportation'], $person_info['transportation']); ?>">車</span>
									</label>
								</div>
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="transportation[]" value="4" <?php if(isset($_POST['transportation'][4])){echo 'checked';}else{if((array_search('4',$transportation))){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('4', $edit_person['transportation'], $person_info['transportation']); ?>">バス</span>
									</label>
								</div>
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="transportation[]" value="5" <?php if(isset($_POST['transportation'][5])){echo 'checked';}else{if((array_search('5',$transportation))){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('5', $edit_person['transportation'], $person_info['transportation']); ?>">電車</span>
									</label>
								</div>
							</div>

							<p></p>
							<div class="input-group">
								<div class="input-group-addon">通勤時間</div>
							    <?php echo Form::input('walk_time', Input::post('walk_time', isset($post) ? $post->walk_time :$edit_person['walk_time']), array('class' => 'form-control', 'size' => 5)); ?>
								<div class="input-group-addon">分</div>
							</div>
							<div class="edit-before <?php echo isset($is_view['walk_time']) ? $is_view['walk_time'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">通勤時間</div>
									<?php echo Form::input('walk_time', Input::post('walk_time', isset($post) ? $post->walk_time :$person_info['walk_time']), array('class' => 'form-control', 'size' => 5 , 'disabled')); ?>
									<div class="input-group-addon">分</div>
								</div>
							</div>
						</td>
					</tr>

					<?php foreach(\Constants::$person_licenses as $key => $value){ ?>
					<?php $license = explode(',', $edit_person['license'.$key]) ;?>
					<?php $license_view = explode(',', $person_info['license'.$key]) ;?>
					<tr>
						<th class="text-right">
							保有資格<?php echo htmlspecialchars($key) ?>
						</th>
						<td>
							<div class="row">
								<?php foreach($value as $key1 => $value1){ ?>
									<div class="col-md-3">
										<label class="checkbox-inline">
											<input type="checkbox" name="license<?php echo $key ;?>[]" value="<?php echo $key1;?>" <?php if(isset($_POST['license'.$key][$key1])){echo 'checked';}else{if(array_search($key1,$license)){echo 'checked';}}?>>
											<span class="<?php echo edit_before_label($key1, $edit_person['license'.$key], $person_info['license'.$key])?>"><?php echo $value1?></span>
										</label>
									</div>
								<?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php $work_type = explode(',', $edit_person['work_type']) ;?>
					<?php $work_type_view = explode(',', $person_info['work_type']) ;?>

					<tr>
						<th class="text-right">勤務加納時間帯</th>
						<td>
							<div class="row">
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="work_type[]" value="0" <?php if(isset($_POST['work_type'][0])){echo 'checked';}else{if(array_search('0',$work_type)){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('0', $edit_person['work_type'], $person_info['work_type'])?>">日中</span>
									</label>
								</div>
								<div class="col-md-3">
									<label class="checkbox-inline">
										<input type="checkbox" name="work_type[]" value="1" <?php if(isset($_POST['work_type'][1])){echo 'checked';}else{if(array_search('1',$work_type)){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('1', $edit_person['work_type'], $person_info['work_type'])?>">夕方</span>
									</label>
								</div>
								<div class="col-md-3"><label class="checkbox-inline">
										<input type="checkbox" name="work_type[]" value="2" <?php if(isset($_POST['work_type'][2])){echo 'checked';}else{if(array_search('2',$work_type)){echo 'checked';}}?>>
										<span class="<?php echo edit_before_label('2', $edit_person['work_type'], $person_info['work_type'])?>">夜間</span>
									</label>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">就業可能時期</th>
						<td>
							<?php echo Form::input('employment_time', Input::post('employment_time', isset($post) ? $post->employment_time :$edit_person['employment_time']), array('class' => 'form-control', 'size' => 80)); ?>
							<div class="edit-before <?php echo isset($is_view['employment_time']) ? $is_view['employment_time'] : '' ?>">
								<?php echo Form::input('employment_time', isset($person_info['employment_time']) ? $person_info['employment_time'] : '', array('class' => 'form-control', 'size' => 80, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">健康状態</th>
						<td>
							<?php echo Form::input('health', Input::post('health', isset($post) ? $post->health : $edit_person['health']), array('class' => 'form-control', 'size' => 80,'maxlength' => 100)); ?>
							<div class="edit-before <?php echo isset($is_view['health']) ? $is_view['health'] : '' ?>">
								<?php echo Form::input('health', Input::post('health', isset($post) ? $post->health : $person_info['health']), array('class' => 'form-control', 'size' => 80,'maxlength' => 100, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">障害有無</th>
						<td>
							<label class="checkbox-inline"><input name='is_failure_existence' type="checkbox" value="1" <?php if($edit_person['is_failure_existence'] == 1) echo "checked"?>>障害あり</label>
							<?php echo Form::input('failure_existence', Input::post('failure_existence', isset($post) ? $post->failure_existence :$edit_person['failure_existence']), array('class' => 'form-control', 'size' => 50,'placeholder' =>'障害がある場合の部位','maxlength' => 50)); ?>
							<div class="edit-before <?php echo isset($is_view['failure_existence']) ? $is_view['failure_existence'] : '' ?> <?php echo isset($is_view['is_failure_existence']) ? $is_view['is_failure_existence'] : '' ?>">
								<label class="checkbox-inline"><input name='is_failure_existence' type="checkbox" value="1" <?php if($person_info['is_failure_existence'] == 1) echo "checked"?> disabled>障害あり</label>
								<?php echo Form::input('failure_existence', isset($person_info['failure_existence']) ? $person_info['failure_existence'] : '', array('class' => 'form-control', 'size' => 80,'maxlength' => 100, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">国籍</th>
						<td>
							<label class="checkbox-inline"><input type="checkbox" name="is_country" value="1" <?php if($edit_person['is_country'] == 1) echo "checked"?>>外国籍</label>
							<?php echo Form::input('country', Input::post('country', isset($post) ? $post->country :$edit_person['country']), array('class' => 'form-control', 'size' => 50,'placeholder' =>'国籍・会話など','maxlength' => 50)); ?>
							<div class="edit-before <?php echo isset($is_view['is_country']) ? $is_view['is_country'] : '' ?> <?php echo isset($is_view['country']) ? $is_view['country'] : '' ?>">
								<label class="checkbox-inline"><input type="checkbox" name="is_country" value="1" <?php if($person_info['is_country'] == 1) echo "checked"?> disabled>外国籍</label>
								<?php echo Form::input('country', isset($person_info['country']) ? $person_info['country'] : '', array('class' => 'form-control', 'size' => 50,'placeholder' =>'国籍・会話など','maxlength' => 50, 'disabled')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">メモ１</th>
						<td>
							<?php echo Form::textarea('memo_1', Input::post('memo_1', isset($post) ? $post->memo_1 :$edit_person['memo_1']), array('rows' => 5, 'cols' => 77,'class' => 'form-control'));?>
							<div class="edit-before <?php echo isset($is_view['memo_1']) ? $is_view['memo_1'] : '' ?>">
								<?php echo Form::textarea('memo_1', isset($person_info['memo_1']) ? $person_info['memo_1'] : '', array('rows' => 5, 'cols' => 77,'class' => 'form-control', 'disabled'));?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">メモ２</th>
						<td>
							<?php echo Form::textarea('memo_2', Input::post('memo_2', isset($post) ? $post->memo_2 :$edit_person['memo_2']), array('rows' => 5, 'cols' => 77,'class' => 'form-control'));?>
							<div class="edit-before <?php echo isset($is_view['memo_2']) ? $is_view['memo_2'] : '' ?>">
								<?php echo Form::textarea('memo_2', isset($person_info['memo_2']) ? $person_info['memo_2'] : '', array('rows' => 5, 'cols' => 77,'class' => 'form-control', 'disabled'));?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">希望・備考など</th>
						<td>
							<?php echo Form::textarea('notes', Input::post('notes', isset($post) ? $post->notes :$edit_person['notes']), array('rows' => 5, 'cols' => 77,'class' => 'form-control'));?>
							<div class="edit-before <?php echo isset($is_view['notes']) ? $is_view['notes'] : '' ?>">
								<?php echo Form::textarea('notes', isset($person_info['notes']) ? $person_info['notes'] : '', array('rows' => 5, 'cols' => 77,'class' => 'form-control', 'disabled'));?>
							</div>
						</td>
					</tr>

					<?php
					if(isset($order)){
						$interview = $order['interview_user_id'];
						$agreement = $order['agreement_user_id'];
						$training = $order['training_user_id'];

						$listusers_interview = $order['listusers_interview'];
						$listusers_agreement = $order['listusers_agreement'];
						$listusers_training = $order['listusers_training'];

						$interview_department_id = $order['interview_department_id'];
						$agreement_department_id = $order['agreement_department_id'];
						$training_department_id = $order['training_department_id'];
					}
					?>

					<tr>
						<th class="text-right">営業</th>
						<td>
							<div class="input-group">
								<div class="input-group-addon">部門</div>
								<?php echo Form::select('select_business_user_id', Input::post('select_business_user_id', isset($post) ? $post->select_business_user_id : $edit_person['business_department_id']), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'business')); ?>
							</div>
							<div class="input-group">
								<div class="input-group-addon">担当者</div>
								<?php echo Form::select('business_user_id', Input::post('business_user_id', isset($post) ? $post->business_user_id : $edit_person['business_user_id']), \Utility::create_array_users($edit_person['listusers_business']), array('class'=>'form-control')); ?>
							</div>
							<p></p>
							<span class="text-info">※指定しない場合は対象SS取引先(支店)の担当営業が自動選択されます</span>

							<div class="edit-before <?php echo isset($is_view['business_user_id']) ? $is_view['business_user_id'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">部門</div>
									<?php echo Form::select('', Input::post('select_business_user_id', isset($post) ? $post->select_business_user_id : $person_info['business_department_id']), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'interview', 'disabled')); ?>
								</div>
								<div class="input-group">
									<div class="input-group-addon">担当者</div>
									<?php echo Form::select('', Input::post('business_user_id', isset($post) ? $post->business_user_id : $person_info['business_user_id']), \Utility::create_array_users($person_info['listusers_business']), array('class'=>'form-control' , 'disabled')); ?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">面接</th>
						<td>
							<div class="input-group">
								<div class="input-group-addon">部門</div>
								<?php echo Form::select('select_interview_user_id', Input::post('select_interview_user_id', isset($post) ? $post->select_interview_user_id : (isset($order) ? $interview_department_id : $edit_person['interview_department_id'])), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'interview')); ?>
							</div>
							<div class="input-group">
								<div class="input-group-addon">担当者</div>
								<?php echo Form::select('interview_user_id', Input::post('interview_user_id', isset($post) ? $post->interview_user_id : (isset($order) ? $interview : $edit_person['interview_user_id'])), \Utility::create_array_users(isset($order) ? $listusers_interview : $edit_person['listusers_interview']), array('class'=>'form-control')); ?>
							</div>
							<p></p>
							<span class="text-info">※指定しない場合は対象SS取引先(支店)の担当営業が自動選択されます</span>
							<div class="edit-before <?php echo isset($is_view['interview_user_id']) ? $is_view['interview_user_id'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">部門</div>
									<?php echo Form::select('', Input::post('select_interview_user_id', isset($post) ? $post->select_interview_user_id : $person_info['interview_department_id']), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'interview', 'disabled')); ?>
								</div>
								<div class="input-group">
									<div class="input-group-addon">担当者</div>
									<?php echo Form::select('', Input::post('interview_user_id', isset($post) ? $post->interview_user_id : $person_info['interview_user_id']), \Utility::create_array_users($person_info['listusers_interview']), array('class'=>'form-control' , 'disabled')); ?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">契約</th>
						<td>
							<div class="input-group">
								<div class="input-group-addon">部門</div>
								<?php echo Form::select('select_agreement_user_id', Input::post('select_agreement_user_id', isset($post) ? $post->select_agreement_user_id : (isset($order) ? $agreement_department_id : $edit_person['agreement_department_id'])), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'agreement')); ?>
							</div>
							<div class="input-group">
								<div class="input-group-addon">担当者</div>
								<?php echo Form::select('agreement_user_id', Input::post('agreement_user_id', isset($post) ? $post->agreement_user_id : (isset($order) ? $agreement : $edit_person['agreement_user_id'])), \Utility::create_array_users(isset($order) ? $listusers_agreement : $edit_person['listusers_agreement']), array('class'=>'form-control')); ?>
							</div>
							<p></p>
							<span class="text-info">※指定しない場合は対象SS取引先(支店)の担当営業が自動選択されます</span>
							<div class="edit-before <?php echo isset($is_view['agreement_user_id']) ? $is_view['agreement_user_id'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">部門</div>
									<?php echo Form::select('', Input::post('select_agreement_user_id', isset($post) ? $post->select_agreement_user_id : $person_info['agreement_department_id']), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'agreement', 'disabled')); ?>
								</div>
								<div class="input-group">
									<div class="input-group-addon">担当者</div>
									<?php echo Form::select('', Input::post('agreement_user_id', isset($post) ? $post->agreement_user_id : $person_info['agreement_user_id']),  \Utility::create_array_users($person_info['listusers_agreement']), array('class'=>'form-control' , 'disabled')); ?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th class="text-right">研修</th>
						<td>
							<div class="input-group">
								<div class="input-group-addon">部門</div>
								<?php echo Form::select('select_training_user_id', Input::post('select_training_user_id', isset($post) ? $post->select_training_user_id : (isset($order) ? $training_department_id : $edit_person['training_department_id'])), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'training')); ?>
							</div>
							<div class="input-group">
								<div class="input-group-addon">担当者</div>
								<?php echo Form::select('training_user_id', Input::post('training_user_id', isset($post) ? $post->training_user_id : (isset($order) ? $training :$edit_person['training_user_id'])), \Utility::create_array_users(isset($order) ? $listusers_training : $edit_person['listusers_training']), array('class'=>'form-control')); ?>
							</div>
							<div class="edit-before <?php echo isset($is_view['training_user_id']) ? $is_view['training_user_id'] : '' ?>">
								<div class="input-group">
									<div class="input-group-addon">部門</div>
									<?php echo Form::select('', Input::post('select_training_user_id', isset($post) ? $post->select_training_user_id : $person_info['training_department_id']), \Constants::get_search_department(' '), array('class'=>'form-control user_id','data-type'=>'training', 'disabled')); ?>
								</div>
								<div class="input-group">
									<div class="input-group-addon">担当者</div>
									<?php echo Form::select('', Input::post('training_user_id', isset($post) ? $post->training_user_id : $person_info['training_user_id']), \Utility::create_array_users($person_info['listusers_training']), array('class'=>'form-control' , 'disabled')); ?>
								</div>
							</div>
						</td>
					</tr>

				</table>

				<div class="text-center">
					<button type="submit" class="btn btn-primary btn-sm">
						<i class="glyphicon glyphicon-pencil icon-white"></i>
						保存
					</button>
				</div>

			</form>

		</div>
		<?php echo Asset::js('validate/order-presenter.js'); ?>

		<script>
			$(function()
			{
				$('.presenter-edit select').attr('disabled','true');
				$('.dateform').datepicker();
				$('#form_mobile').change(function(){
					if($(this).val()!=''){
						$( "#form_tel" ).rules( "remove", "required" );
					}else{
						if($('#form_tel').val()!='')
						{
							$(this).rules( "remove", "required" );
						}else
						{
							$( "#form_tel" ).rules( "add", "required" );
						}
					}
				})
				$('#form_tel').change(function(){
					if($(this).val()!=''){
						$( "#form_mobile" ).rules( "remove", "required" );
					}else{
						if($('#form_mobile').val()!='')
						{
							$(this).rules( "remove", "required" );
						}else
						{
							$( "#form_mobile" ).rules( "add", "required" );
						}
					}
				})
				$( "#form_mobile" ).trigger( "change" );
				$( "#form_tel" ).trigger( "change" );
				$("#form_day,#form_year,#form_month").change(function()
				{
					var year = $("#form_year").val();
					var month = $("#form_month").val();
					var day = $("#form_day").val();
					if(year!='' && month!='' && day!='')
					{
						var date = year+'-'+month+'-'+day;
						$("#age_1").html(getAge(date,''));
						$( "#form_application_date_d" ).trigger( "change" );

					}
				});

				$("#form_application_date_d").change(function()
				{
					var cr = $(this).val();
					var date = $('#form_birthday').val();
					if(date !=''){
						$("#age_2").html(getAge(date,cr));
					}
				});
				$( "#form_day,#form_year,#form_month" ).trigger( "change" );
				$( "#form_application_date_d" ).trigger( "change" );

				$('#form_job_id').combobox();

				$('select.user_id').change(function(){
					var type = $(this).attr('data-type');
					var department_id = $(this).val();
					strString = '<option value=""></option>';
					if(department_id == '' || department_id == 0){
						$('select#form_'+type+'_user_id').html(strString);
						return false;
					}
					$.post(baseUrl+'job/order/get_users', {department_id:department_id}, function(result){
						var data = jQuery.parseJSON(result);
						for (var i = 0; i < data['list_user'].length; i++) {
							strString += '<option value=' + data['list_user'][i].user_id + '>' + data['list_user'][i].name + '</option>';
						}
						$('select#form_'+type+'_user_id').html(strString);
					});
				});
			});

			function getAge(dateString,cr)
			{
				if(cr =='')
				{
					var today = new Date();
				}
				else
				{
					var today = new Date(cr);
				}
				var birthDate = new Date(dateString);
				var age = today.getFullYear() - birthDate.getFullYear();
				var m = today.getMonth() - birthDate.getMonth();
				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
				{
					age--;
				}
				return age;
			}

		</script>
<style>
	.edit-before:not(.edit-before-ss){
		display: none;
	}
	.edit-before-label {
		background-color: #ffcccc;
		border: 1px dashed #ff0000;
		color: #cc0000;
		margin-right: 10px;
		margin-top: 10px;
		padding: 2px;
	}

</style>

<div class="container">
	<h3>
		お問い合わせ詳細
	</h3>

	<form class="form-inline">

		<table class="table table-striped">
			<tr>
				<th class="text-right">登録時刻</th>
				<td>
					<?php
						echo isset($contact) ? $contact->created_at : '';
					?>
				</td>
			</tr>
			<tr>
				<th class="text-right">氏名(全角)</th>
				<td>
					<?php
					echo isset($contact) ? $contact->name : '';
					?>
				</td>
			</tr>
			<tr>
				<th class="text-right">氏名(ふりがな)</th>
				<td>
					<?php
					echo isset($contact) ? $contact->name_kana : '';
					?>
				</td>
			</tr>

			<tr>
				<th class="text-right">電話番号</th>
				<td>
					<?php
					echo isset($contact) ? $contact->mobile : '';
					?>
				</td>
			</tr>
			<tr>
				<th class="text-right">メールアドレス</th>
				<td>
					<?php
					echo isset($contact) ? $contact->mail : '';
					?>
				</td>
			</tr>
			<tr>
				<th class="text-right">その他備考</th>
				<td>
					<?php
					echo \Fuel\Core\Form::textarea('content_detail', isset($contact) ? $contact->content : '', array('class' => 'imp_txt', 'cols' => '100', 'disabled', 'style' => 'border:0;background-color:#fff'));
					?>
				</td>
			</tr>
		</table>

		<div class="text-center">
			<a type="button" href="<?php echo \Fuel\Core\Uri::base(); ?>support/contacts?<?php echo \Fuel\Core\Session::get('url_filter_contacts'); ?>" class="btn btn-warning btn-sm" name="back-btn">
				<i class="glyphicon glyphicon-step-backward icon-white"></i>
				戻る
			</a>
		</div>

	</form>

</div>
<?php
	echo \Fuel\Core\Asset::js('jquery.elastic.source.js');
?>
<script type="text/javascript">
	$('#form_content_detail').elastic();
</script>
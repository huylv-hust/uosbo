<?php if(!isset($order_id)){ $order_id = ''; } ?>
<?php if(!isset($department_name)){ $department_name = ''; } ?>
<?php if(!isset($m_user_name)){ $m_user_name = ''; } ?>
<?php if($status == 99){ ?>
媒体管理システムに掲載オーダーの登録がありました。

オーダーID：<?php echo $order_id; ?>

部門：<?php echo $department_name; ?>   作成者：<?php echo $m_user_name; ?>


管理画面から確認の上、承認作業を行なって下さい。
<?php echo \Uri::base().'job/order?order_id='.$order_id; ?>

※携帯からの閲覧はできません。
<?php } ?>
<?php if(!isset($list_media_name)){ $list_media_name = ''; } ?>
<?php if(!isset($ss_list_name)){ $ss_list_name = ''; } ?>
<?php if(!isset($ss_name)){ $ss_name = ''; } ?>
<?php if(!isset($agreement_type)){ $agreement_type = ''; } ?>
<?php if($status == 1){ ?>
媒体管理システムに掲載オーダーが承認されました。

媒体：<?php echo $list_media_name; ?>

対象SS：<?php echo $ss_name; ?>

売上形態：<?php echo $agreement_type; ?>

同募SS：<?php echo $ss_list_name; ?>


確定内容は管理画面から確認して下さい。
<?php echo \Uri::base().'job/order?order_id='.$order_id; ?>

※携帯からの閲覧はできません。
<?php } ?>
<?php if(!isset($reason)){ $reason = ''; } ?>
<?php if($status == -1){ ?>
媒体管理システムに掲載オーダーが非承認になりました。

媒体：<?php echo $list_media_name; ?>

対象SS：<?php echo $ss_name; ?>

売上形態：<?php echo $agreement_type; ?>

同募SS：<?php echo $ss_list_name; ?>


非承認理由
<?php echo $reason; ?>


再申請を行なう場合は、1週間以内に行って下さい。
<?php echo \Uri::base().'job/order?order_id='.$order_id; ?>

※携帯からの閲覧はできません。
<?php } ?>

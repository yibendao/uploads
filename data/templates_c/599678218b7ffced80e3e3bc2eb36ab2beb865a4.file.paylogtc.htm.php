<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 15:02:06
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\paylogtc.htm" */ ?>
<?php /*%%SmartyHeaderCode:2320159cf416ee000a0-63615221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '599678218b7ffced80e3e3bc2eb36ab2beb865a4' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\paylogtc.htm',
      1 => 1501490220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2320159cf416ee000a0-63615221',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statis' => 0,
    'config' => 0,
    'integral' => 0,
    'rating' => 0,
    'addjobnum' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf416f1d1ad0_79344130',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf416f1d1ad0_79344130')) {function content_59cf416f1d1ad0_79344130($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="w1000">
  <div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class=right_box>
      <div class=admincont_box>
        <div class="com_tit"><span class="com_tit_span">我的会员</span></div>
        <div class="com_body">
          <div class="com_pay_balance">
            <div class="com_pay_balance_left">
              <div class="com_pay_balance_tit">尊敬的企业用户</div>
              <div class=""> 您当前是：<span class="f60">
				<?php if ($_smarty_tpl->tpl_vars['statis']->value['vip_etime']<time()&&$_smarty_tpl->tpl_vars['statis']->value['vip_etime']!=0) {?>
			 		<?php if ($_smarty_tpl->tpl_vars['config']->value['com_vip_done']==0) {?>
			 			非会员
					<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['com_vip_done']==1) {?>
 						<?php echo $_smarty_tpl->tpl_vars['statis']->value['rating_name'];?>

			 		<?php }?>
			 	<?php } else { ?>
					<?php echo $_smarty_tpl->tpl_vars['statis']->value['rating_name'];?>

			 	<?php }?></span></div>
              <div class=""> 服务期限为：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['statis']->value['vip_stime'],'%Y-%m-%d');?>
 - <?php if ($_smarty_tpl->tpl_vars['statis']->value['vip_etime']==0) {?>永久<?php } else {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['statis']->value['vip_etime'],'%Y-%m-%d');
}?></div>
            </div>
            <div class="com_pay_balance_right">
              <div class="com_pay_balance_right_jf"> 可用<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：<span class="f60"><?php echo $_smarty_tpl->tpl_vars['statis']->value['integral'];?>
</span><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</div>
              <div class="">已消费<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：<span class="f60"><?php echo $_smarty_tpl->tpl_vars['integral']->value;?>
</span> <?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
 <a href="index.php?c=paylog&consume=ok" title="明细"  class="com_pay_balance_a">明细</a><a href="index.php?c=pay&type=integral" title="账户充值" class="com_pay_balance_a">充值</a> <a href="index.php?c=right" title="查看特权"  class="com_pay_balance_a">查看特权</a></div>
              <div class=""></div>
            </div>
          </div>
          <div class="com_pay_balance_box">
            <div class="com_pay_balance_data">
              <div class="com_pay_balance_data_q">
                <div class="com_pay_balance_data_n"><?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>不限<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['job_num'];
}?></div>
                <div class="com_pay_balance_data_name">可发布职位</div>
              </div>
              <div class="com_pay_balance_data_p mt10">套餐数：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['rating']->value['job_num'];
}?></div>
              <div class="com_pay_balance_data_p">
              	<?php if ($_smarty_tpl->tpl_vars['rating']->value['job_num']-$_smarty_tpl->tpl_vars['statis']->value['job_num']>=0) {?>
              		已发布：<?php echo $_smarty_tpl->tpl_vars['rating']->value['job_num']-$_smarty_tpl->tpl_vars['statis']->value['job_num'];?>

              	<?php } elseif ($_smarty_tpl->tpl_vars['rating']->value['job_num']-$_smarty_tpl->tpl_vars['statis']->value['job_num']<0) {?>
              		增值服务：<?php echo $_smarty_tpl->tpl_vars['statis']->value['job_num']-$_smarty_tpl->tpl_vars['rating']->value['job_num'];?>

              	<?php }?>
              </div>
              
              <div class="com_pay_balance_data_bth">
              	<a href="javascript:void(0);" onclick="jobadd_url('<?php echo $_smarty_tpl->tpl_vars['addjobnum']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_job'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
');return false;" class="com_pay_balance_data_btha">发布职位</a></div>
            </div>
            <div class="com_pay_balance_box">
              <div class="com_pay_balance_data com_pay_balance_data_xz">
                <div class="com_pay_balance_data_q">
                  <div class="com_pay_balance_data_n"><?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>不限<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['down_resume'];?>
 <?php }?></div>
                  <div class="com_pay_balance_data_name">可下载简历</div>
                </div>
                <div class="com_pay_balance_data_p mt10">套餐数：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['rating']->value['resume'];
}?></div>
                <div class="com_pay_balance_data_p">
                	<?php if ($_smarty_tpl->tpl_vars['rating']->value['resume']-$_smarty_tpl->tpl_vars['statis']->value['down_resume']>=0) {?>
                		已下载：<?php echo $_smarty_tpl->tpl_vars['rating']->value['resume']-$_smarty_tpl->tpl_vars['statis']->value['down_resume'];?>

                	<?php } elseif ($_smarty_tpl->tpl_vars['rating']->value['resume']-$_smarty_tpl->tpl_vars['statis']->value['down_resume']<0) {?>
                		增值服务:<?php echo $_smarty_tpl->tpl_vars['statis']->value['down_resume']-$_smarty_tpl->tpl_vars['rating']->value['resume'];?>

                	<?php }?>
                </div>
                <div class="com_pay_balance_data_bth"><a  href="index.php?c=down" class="com_pay_balance_data_btha">查看</a></div>
              </div>
              <div class="com_pay_balance_box">
                <div class="com_pay_balance_data com_pay_balance_data_yq">
                  <div class="com_pay_balance_data_q">
                    <div class="com_pay_balance_data_n"><?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>不限<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['invite_resume'];?>
 <?php }?></div>
                    <div class="com_pay_balance_data_name">可邀请面试</div>
                  </div>
                  <div class="com_pay_balance_data_p mt10">套餐数：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['rating']->value['interview'];
}?></div>
                  <div class="com_pay_balance_data_p">
                  	<?php if ($_smarty_tpl->tpl_vars['rating']->value['interview']-$_smarty_tpl->tpl_vars['statis']->value['invite_resume']>=0) {?>
                  		已邀请：<?php echo $_smarty_tpl->tpl_vars['rating']->value['interview']-$_smarty_tpl->tpl_vars['statis']->value['invite_resume'];?>

                  	<?php } elseif ($_smarty_tpl->tpl_vars['rating']->value['interview']-$_smarty_tpl->tpl_vars['statis']->value['invite_resume']<0) {?>
                  		增值服务：<?php echo $_smarty_tpl->tpl_vars['statis']->value['invite_resume']-$_smarty_tpl->tpl_vars['rating']->value['interview'];?>

                  	<?php }?>
                  </div>
                  <div class="com_pay_balance_data_bth">
                    <?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1) {?><a href="index.php?c=resume" class="com_pay_balance_data_btha">搜人才</a><?php }?>
                    </div>
                </div>
                <div class="com_pay_balance_list">
                  <div class="com_pay_balance_list_h1">刷新职位</div>
                  <div class="com_pay_balance_list_zs">套餐数：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['rating']->value['breakjob_num'];
}?></div>
                  <div class="com_pay_balance_list_p"><i class="com_body_pay_list_sl_iocn"></i><i class="com_body_pay_list_sl_iocn"></i>
                  <?php if ($_smarty_tpl->tpl_vars['rating']->value['breakjob_num']-$_smarty_tpl->tpl_vars['statis']->value['breakjob_num']>=0) {?>
                  	已使用：<?php echo $_smarty_tpl->tpl_vars['rating']->value['breakjob_num']-$_smarty_tpl->tpl_vars['statis']->value['breakjob_num'];?>

                  <?php } elseif ($_smarty_tpl->tpl_vars['rating']->value['breakjob_num']-$_smarty_tpl->tpl_vars['statis']->value['breakjob_num']<0) {?>
                  	增值服务：<?php echo $_smarty_tpl->tpl_vars['statis']->value['breakjob_num']-$_smarty_tpl->tpl_vars['rating']->value['breakjob_num'];?>

                  <?php }?>
                  </div>
                  <div class="com_pay_balance_list_p"><i class="com_body_pay_list_sl_iocn com_body_pay_list_sl_iocn_sy"></i>剩余：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['breakjob_num'];
}?></div>
                </div>
                <div class="com_pay_balance_list">
                  <div class="com_pay_balance_list_h1">发布兼职职位</div>
                  <div class="com_pay_balance_list_zs">套餐数：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['rating']->value['part_num'];
}?></div>
                  <div class="com_pay_balance_list_p"><i class="com_body_pay_list_sl_iocn"></i>
                  	<?php if ($_smarty_tpl->tpl_vars['rating']->value['part_num']-$_smarty_tpl->tpl_vars['statis']->value['part_num']>=0) {?>
                  		已使用：<?php echo $_smarty_tpl->tpl_vars['rating']->value['part_num']-$_smarty_tpl->tpl_vars['statis']->value['part_num'];?>

                  	<?php } elseif ($_smarty_tpl->tpl_vars['rating']->value['part_num']-$_smarty_tpl->tpl_vars['statis']->value['part_num']<0) {?>
                  		增值服务：<?php echo $_smarty_tpl->tpl_vars['statis']->value['part_num']-$_smarty_tpl->tpl_vars['rating']->value['part_num'];?>

                  	<?php }?>
                  </div>
                  <div class="com_pay_balance_list_p"><i class="com_body_pay_list_sl_iocn com_body_pay_list_sl_iocn_sy"></i>剩余：<?php if ($_smarty_tpl->tpl_vars['statis']->value['rating_type']=='2') {?>会员有效期内不限<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['part_num'];
}?></div>
                </div>
               
               
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>

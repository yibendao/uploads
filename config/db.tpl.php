<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2016 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
$arr_tpl = array ( 
	'emailupjob' => array (
		'name'=>'职位未刷新提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'企业名',    
		'{date}'=>'上次刷新时间',
	    '{day}'=>'未发布天数'
	),
	'emailaddjob' => array (
		'name'=>'企业未发布职位提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'企业名',    
		'{date}'=>'上次发布时间',
	    '{day}'=>'未发布天数'    
	),
	'emailbirthday' => array (
		'name'=>'个人生日提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'真实姓名', 
		'{year}'=>'年龄', 		
		'{date}'=>'出生日期' 
	),
	'emailwebbirthday' => array (
		'name'=>'网站周年提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'真实姓名',    
		'{year}'=>'年数',    
		'{date}'=>'创办日期' 
	),
	'emailuserwdl' => array (
		'name'=>'个人会员未登录提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',  
		'{date}'=>'上次登录时间' 
	), 
	'emailcomwdl' => array (
		'name'=>'企业未登录提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{name}'=>'企业名称',  
		'{date}'=>'上次登录时间' 
	),
    'emailuserup' => array (
        'name'=>'个人会员未更新简历',
        'type'=>'email',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'用户名',
        '{date}'=>'上次更新时间',
        '{day}'=>'未更新天数'
    ),
    'emailuseradd' => array (
        'name'=>'个人会员未发布简历',
        'type'=>'email',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'用户名',
        '{day}'=>'未发布简历天数',
        '{date}'=>'注册时间'
    ),
	'emailviped' => array (
		'name'=>'企业会员过期提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{name}'=>'企业名称', 
		'{retingname}'=>'服务名称', 
		'{date}'=>'过期时间',
	    '{day}'=>'即将过期天数'
	),
	'emailreg' => array (
		'name'=>'邮件注册模板',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{password}'=>'密码',
		'{email}'=>'邮箱'
	),
	'emailyqms' => array (
		'name'=>'邀请面试',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{company}'=>'公司名称',
		'{linkman}'=>'联系人',
		'{comtel}'=>'联系电话',
		'{username}'=>'求职者名称',
		'{jobname}'=>'职位名称',
		'{comemail}'=>'邮箱'
	),
	'emailyqmshf' => array (
		'name'=>'回复邀请面试',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{cusername}'=>'回复人名称',
		'{typemsg}'=>'回复内容：拒绝、同意'
	),
	'emailgetpass' => array (
		'name'=>'找回密码',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{sendcode}'=>'验证码'
	),
	'emailfkcg' => array (
		'name'=>'付款成功',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{order_id}'=>'交易单号',
		'{price}'=>'金额',
		'{date}'=>'时间'
	),
	'emaillock' => array (
		'name'=>'会员锁定',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{lock_info}'=>'锁定原因',
	),
	'emailuserstatus' => array (
		'name'=>'会员审核',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'审核时间',
		'{auto_statis}'=>'审核说明',
		'{status_info}'=>'审核原因',
	),
	'emailzzshtg' => array (
		'name'=>'职位审核成功',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称'
	),
	'emailzzshwtg' => array (
		'name'=>'职位审核未通过',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称',
		'{status_info}'=>'审核原因'
	),
	'emailpartshtg' => array (
		'name'=>'兼职审核成功',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称'
	),
	'emailpartshwtg' => array (
		'name'=>'兼职审核未通过',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称',
		'{status_info}'=>'审核原因'
	),
	'emailsqzw' => array (
		'name'=>'申请职位',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{jobname}'=>'职位名称',
		'{date}'=>'申请时间'
	),
	'emailsqzwhf' => array (
		'name'=>'申请职位回复',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{company}'=>'公司名称',
		'{jobname}'=>'职位名称'
	),
	'emailcert' => array (
		'name'=>'邮箱认证',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{url}'=>'链接地址',
		'{date}'=>'认证时间'
	),
	'emailcomcert' => array (
		'name'=>'企业认证',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{comname}'=>'企业名称',
		'{certinfo}'=>'审核说明'
	),
	'emailusercert' => array (
		'name'=>'个人认证',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{certinfo}'=>'审核说明'
	),
	'emailjobed' => array (
		'name'=>'职位过期提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{com_name}'=>'公司名称',
		'{job_name}'=>'职位名称'
	),
	'emailremind' => array (
		'name'=>'邮件提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
	),
	'emailuserdy' => array (
		'name'=>'邮件订阅',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{jobname}'=>'职位名称',
	),
	'emailcomdy' => array (
		'name'=>'邮件订阅',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{resumename}'=>'简历名称',
	),
	'emailnotice' => array (
		'name'=>'自动发送职位通知',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{jobname}'=>'职位名称',
	),
	'emailclaim' => array (
		'name'=>'认领会员',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{url}'=>'认领地址',
	),
	'emailrecharge' => array (
		'name'=>'充值提醒',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{name}'=>'姓名',
		'{price}'=>'金额',
		'{time}'=>'时间',
	),
	'emailpartapply' => array (
		'name'=>'兼职报名',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{username}'=>'用户名',
		'{jobname}'=>'职位名称',
	),
	'emailsubjectshtg' => array (
		'name'=>'课程审核通过',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{subjectname}'=>'课程名称',
	),
	'emailsubjectshwtg' => array (
		'name'=>'课程审核未通过',
		'type'=>'email',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{subjectname}'=>'课程名称',
		'{status_info}'=>'审核原因'
	),
    'emailzphshtg' => array (
        'name'=>'招聘会审核通过',
        'type'=>'email',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{date}'=>'通过时间',
        '{zphname}'=>'招聘会名称',
    ),
    'emailzphshwtg' => array (
        'name'=>'招聘会审核未通过',
        'type'=>'email',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{zphname}'=>'招聘会名称',
        '{status_info}'=>'审核原因'
    ),
	'msgcert' => array (
		'name'=>'手机认证',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{code}'=>'验证码',
		'{date}'=>'认证时间'
	),
	'msgreg' => array (
		'name'=>'短信注册模板',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{password}'=>'密码',
		'{email}'=>'邮箱'
	),
	'msgyqms' => array (
		'name'=>'短信邀请面试',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{company}'=>'公司名称',
		'{jobname}'=>'邀请职位',
		'{linkman}'=>'联系人',
		'{comtel}'=>'联系电话',
		'{username}'=>'求职者名称',
		'{jobname}'=>'职位名称',
		'{comemail}'=>'邮箱'
	),
	'msgyqmshf' => array (
		'name'=>'短信回复邀请面试',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{cusername}'=>'回复人名称',
		'{typemsg}'=>'回复内容：拒绝、同意'
	),
	'msgfkcg' => array (
		'name'=>'付款成功',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{order_id}'=>'交易单号',
		'{price}'=>'金额',
		'{date}'=>'时间'
	),
	'msgzzshtg' => array (
		'name'=>'职位审核成功',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称'
	),
	'msgzzshwtg' => array (
		'name'=>'职位审核未通过',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称'
	),
	'msgpartshtg' => array (
		'name'=>'兼职审核成功',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称'
	),
	'msgpartshwtg' => array (
		'name'=>'兼职审核未通过',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{jobname}'=>'职位名称'
	),
	'msggetpass' => array (
		'name'=>'找回密码',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{sendcode}'=>'验证码'),
	'msgsqzw' => array (
		'name'=>'申请职位',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{jobname}'=>'职位名称',
		'{date}'=>'申请时间'
	),
	'msgsqzwhf' => array (
		'name'=>'申请职位回复',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{company}'=>'公司名称',
		'{jobname}'=>'职位名称'
		),
	'msgremind' => array (
		'name'=>'短信提醒',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话'
	),
	'msgcomdy' => array (
		'name'=>'企业订阅',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{resumename}'=>'简历名称'
	),
	'msguserdy' => array (
		'name'=>'个人订阅',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{jobname}'=>'职位名称'
	),
	'msgnotice' => array (
		'name'=>'自动发送职位通知',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{jobname}'=>'职位名称',
	),
	'msgregcode' => array (
		'name'=>'注册验证码',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{code}'=>'验证码',
	),
	'msgrecharge' => array (
		'name'=>'充值提醒',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{name}'=>'姓名',
		'{price}'=>'金额',
		'{time}'=>'时间',
	),
	'msgpartapply' => array (
		'name'=>'兼职报名',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{username}'=>'用户名',
		'{jobname}'=>'职位名称',
	),
	'msgsubjectshtg' => array (
		'name'=>'课程审核通过',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{subjectname}'=>'课程名称',
	),
	'msgsubjectshwtg' => array (
		'name'=>'课程审核未通过',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'通过时间',
		'{subjectname}'=>'课程名称',
	),
    'msgbirthday' => array (
        'name'=>'个人生日提醒',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'真实姓名',
        '{year}'=>'年龄',
        '{date}'=>'出生日期'
    ),
    'msgwebbirthday' => array (
        'name'=>'网站周年提醒',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'真实姓名',
        '{year}'=>'年数',
        '{date}'=>'创办日期'
    ),
    'msgviped' => array (
        'name'=>'企业会员过期提醒',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{name}'=>'企业名称',
        '{retingname}'=>'服务名称',
        '{date}'=>'过期时间',
        '{day}'=>'即将过期天数'
    ),
    'msguseradd' => array (
        'name'=>'个人会员未发布简历',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'用户名',
        '{day}'=>'未发布简历天数',
        '{date}'=>'注册时间'
    ),
    'msguserup' => array (
        'name'=>'个人会员未更新简历',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'用户名',
        '{date}'=>'上次更新时间',
        '{day}'=>'未更新天数'
    ),
    'msgaddjob' => array (
        'name'=>'企业未发布职位提醒',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'企业名',
        '{date}'=>'上次发布时间',
        '{day}'=>'未发布天数'
    ),
    'msgupjob' => array (
        'name'=>'企业职位未刷新提醒',
        'type'=>'msg',
        '{webname}'=>'网站名称',
        '{weburl}'=>'网站域名',
        '{webtel}'=>'网站电话',
        '{username}'=>'企业名',
        '{date}'=>'上次刷新时间',
        '{day}'=>'未发布天数'
    ),
	'msguserstatus' => array (
		'name'=>'会员审核',
		'type'=>'msg',
		'{webname}'=>'网站名称',
		'{weburl}'=>'网站域名',
		'{webtel}'=>'网站电话',
		'{date}'=>'审核时间',
		'{auto_statis}'=>'审核说明'
	)
);
?>

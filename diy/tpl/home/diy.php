<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
</head>
<script src='/asset/jq/jquery-1.9.1.min.js'></script>
<style>
	table {
		margin:200px 500px;
	}
	tr{
		text-align:center;
	}
	td{
		width:250px;
	}
	tr .regist-p {
		cursor:pointer;
	}	
	tr .login-p {
		cursor:pointer;
	}
	.tab-p {
		background-color: #eee;
	}
</style>
<body>
	<table style='border:#eee 1px solid;width:500px'>
		<tr>
			<td class='regist-p'>注&nbsp;&nbsp;&nbsp;册</td>
			<td class='login-p tab-p'>登&nbsp;&nbsp;&nbsp;录</td>
		</tr>
		<tr>
			<td>用&nbsp;户&nbsp;名：</td>
			<td><input type="text" id='username'></td>
		</tr>		
		<tr>
			<td>密&nbsp;&nbsp;&nbsp;码：</td>
			<td><input type="password" id='pwd'></td>
		</tr>		
		<tr class='sure-pwd' hidden>
			<td>确&nbsp;认&nbsp;密&nbsp;码：</td>
			<td><input type="password" id='repeat-pwd'></td>
		</tr>		
		<tr>
			<td colspan="2"><br/><button>&nbsp;提&nbsp;&nbsp;&nbsp;交&nbsp;</button></td>
		</tr>
	</table>	

</body>
<script>
$(function () {
	$('.regist-p').click(function () {
		$('.sure-pwd').show();
		$('.login-p').removeClass('tab-p');
		$(this).addClass('tab-p');
		$('#username').val('');
		$('#pwd').val('');
	});

	$('.login-p').click(function () {
		$('.sure-pwd').hide();
		$('.regist-p').removeClass('tab-p');
		$(this).addClass('tab-p');
		$('#username').val('');
		$('#pwd').val('');
		$('#repeat-pwd').val('');
	});

	$('button').click(function () {
		var username = $('#username').val().trim();
		var pwd = $('#pwd').val().trim();
		var repeat = $('#repeat-pwd').val().trim();

		if($('.login-p').attr('class').indexOf('tab-p') != -1){
			if(username == '' || pwd == '') {
				alert('数据不能为空！');
				return false;
			}
			$.post('/api/home/login',{username:username,pwd:pwd},function (data) {
				data = JSON.parse(data);
				if(data.ret == 0) {
					alert('验证成功！');
				}else{
					alert(data.msg);
				}
			});
		}else{
			if(username == '' || pwd == '') {
				alert('数据不能为空！');
				return false;
			}
			if(pwd != repeat){
				alert('两次密码不一致！');
				return false;
			}
			$.post('/api/home/regist',{username:username,pwd:pwd,repeat:repeat},function (data) {
				data = JSON.parse(data);
				if(data.ret == 0) {
					alert('注册成功！');
				}else{
					alert(data.msg);
				}
			});
		}
	});
});

</script>
</html>
<?php
namespace home;
use core\Controller;
use model\user;
class IndexController extends Controller {
	public function index () {
		$demo = 'hello world';
		$plat = loadPlate();

		die($plat->render('/home/home',['demo' => $demo]));
	}

	public function diy () {
		$plat = loadPlate();

		die($plat->render('/home/diy'));
	}

	public function regist () {
		$username = post('username');
		$pwd = post('pwd');
		$repeat = post('repeat');
		if($repeat != $pwd) {
			$res = array('ret' => 1,'msg' => '两次密码不一致！');
			die(json_encode($res));
		}
		$user = new user();
		$is_user = $user->checkUser(array('username' => $username,'pwd' => md5($pwd)));
		if($is_user) {
			$res = array('ret' => 1,'msg' => '已存在的用户');
			die(json_encode($res));
		}

		$result = $user->doInsert(array('username' => $username,'pwd' => md5($pwd)));
		if(!$result) {
			$res = array('ret' => 0,'msg' => '注册失败');
			die(json_encode($res));
		}

		$res = array('ret' => 0,'msg' => '注册成功');
		die(json_encode($res));
	}

	public function login () {
		$username = post('username');
		$pwd = post('pwd');
		$user = new user();
		$is_user = $user->checkUser(array('username' => $username,'pwd' => md5($pwd)));
		if(!$is_user) {
			$res = array('ret' => 1,'msg' => '登录失败');
			die(json_encode($res));
		}

		$res = array('ret' => 0,'msg' => '登录成功');
		die(json_encode($res));
	}
}
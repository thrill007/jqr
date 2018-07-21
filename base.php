<?php
/**
 * 机器人项目base类
 * 2018-3-14 14:17:30
 * loonghere@qq.com
 */
require 'start.php';
class Base
{
	public $db;
	public $ytdb;
	public $fs_sever = '106.14.104.235';
	public $self_sever = '222.186.56.174';
	public $base_sounddir = '/home/robot_sound_zhongcai/';
	public $recordpath = '';
	public $sounddir;
	public $config = [
		'DB_HOST' => '127.0.0.1',
		'DB_USER' => 'root',
		'DB_PASS' => 'yt6533629@100',
	];
	public $inline;
	public $input;

	public $flowdata = '';
	public $mode; // 模式 0 打断 1 不打断

	public $type = [];
	public $process = [];
	public $exten;
	public $robot = 1; // 机器人数量
	public $authtime = 0; // 授权过期时间的时间戳
	public $uniqueid = '';
	public $forcehangup = 300; // 通话时间超过这个时间强制挂机(单位秒)
	public $sms = ['switch' => 0, 'fee' => 0.08];
	public $logData = [];
	public $nextdata = ['lastname' => '', 'name' => '', 'nextname' => 1, 'no_answer_times' => 0, 'empty_times' => 0, 'progress' => '', 'fileplayed' => 0, 'fileplayed_timestamp' => 0, 'gender' => 0];
	public $filter_keywords = ['!', '#', '.null', 'bye', 'wanhui', 'busy', '.wanhui', '.question', 'wanhui1', 'wanhui2', 'wanhui3', 'wanhui4', 'wanhui5', 'wanhui6', 'wanhui7', 'wanhui8', '.wanhui1', '.wanhui2', '.wanhui3', '.wanhui4', '.wanhui5', 'yaoyue', '.yaoyue'];

	public function testBridge()
	{
		if ($this->input['calleeid'] == '7777789') {
			if ($this->input['notify'] == 'enter')
				$this->getdtmf('转人工请按一', 1);
			else
				$this->bridge("sofia/external/8001@106.14.25.61:5099","","","正在转接中，请等待",$this->base_sounddir . "waiting.wav");
		}
	}

	public function getType()
	{
		$sql = "select name,type from cmp_no order by id asc";
		$rows = $this->db->getAll($sql);
		foreach ($rows as $key => $val) {
			$this->type[$val['type']][] = $val['name'];
		}
	}

	public function getProcess()
	{
		$sql = "select id,name,`condition`,answer,nextname,weight,record from req_ans_data order by id asc";
		$this->process = $this->db->getAll($sql);
	}

	public function getRobot()
	{
		$sql = "select ExtenNum,aicount,sms_switch,sms_fee,AuthTime from asrcall_config where asrnumber='" . $this->input['callerid'] . "'";
		$row = $this->ytdb->getRow($sql);
		$this->exten = trim($row['ExtenNum']);
		$this->robot = intval($row['aicount']);
		$this->sms = ['switch' => intval($row['sms_switch']), 'fee' => $row['sms_fee']];
		$this->authtime = strtotime($row['AuthTime']);
	}

	public function setGender($filename)
	{
		$gender = isset($this->nextdata['gender']) ? $this->nextdata['gender'] : 0;
		if (in_array($this->input['gender'], [2, 4])) $this->nextdata['gender'] = 2;
		if (in_array($this->input['gender'], [1, 3]) && $this->nextdata['gender'] != 2) $this->nextdata['gender'] = 1;
		$this->writeFile($filename);
		if ($gender != $this->nextdata['gender']) {
			$sql = "update `asrcall_record_detail` set gender=" . $this->nextdata['gender'] . " where user=1 and uniqueid='" . $this->uniqueid . "'";
			$this->ytdb->query($sql);
		}
	}

	public function saveRecord($calleeid = '', $callerid = '', $callid = '', $msg = '', $processid = 0, $record = '', $index = 0)
	{
		$user = ['智能机器人', '客户'];
		$msg = addslashes($msg);
		$gender = (!isset($this->nextdata['gender']) || !$index) ? 0 : $this->nextdata['gender'];
		$sql = "insert `asrcall_record_detail` (asr_number, caller_num, uniqueid, call_id, user, gender, msg, process_id, record) values ('$callerid', '$calleeid', '" . $this->uniqueid . "', '$callid', $index, $gender, '$msg', $processid, '$record')";
		// Log::write($sql);
		$this->ytdb->query($sql);
	}

	public function saveRecordNoAnswer($calleeid = '', $callerid = '', $callid = '', $msg = '', $record = '')
	{
		$msg = addslashes($msg);
		$sql = "insert `asrcall_record_noanswer` (asr_number, caller_num, call_id, msg, record) values ('$callerid', '$calleeid', '$callid', '$msg', '$record')";
		$this->ytdb->query($sql);
	}

	public function insertQueue($callerid = '', $calleeid = '', $callid = '', $status = 0)
	{
		$sql = "insert ignore into asr_queueinfo (callernumber,asrServer,`status`,uuid) values ('$calleeid','$callerid',$status,'$callid')";
		$this->ytdb->query($sql);
	}

	public function deleteQueue($callerid = '', $calleeid = '', $callid = '')
	{
		// Log::write('deleteQueue');
		$sql = "delete from asr_queueinfo where asrServer='$callerid' and callernumber='$calleeid' and uuid='$callid'";
		$this->ytdb->query($sql);
		// Log::write($sql);
		if ($this->ytdb->affected_rows() > -1) {
			// Log::write($this->ytdb->affected_rows());
			$sql = "update asr_queueinfo set status=1 where asrServer='$callerid' and status=0 order by id asc limit 1";
			$this->ytdb->query($sql);
			// Log::write($sql);
		}
	}

	public function sendSms($callerid = '', $calleeid = '', $callid = '')
	{
		// 如果短信开启则发送
		// Log::write('触发短信发送');
		if ($this->sms['switch']) {
			// 读取该线路下在短信模板
			$sql = "select sms_content_verify from asrcall_sms_setting where asr_number='$callerid' limit 1";
			$content = $this->ytdb->getOne($sql);
			// Log::write($content);
			if (!empty($content)) {
				// Log::write('发送短信给' . $calleeid);
				$tmp = explode(',', $content);
				$param = [
					'mobile' => $calleeid,
					'content' => '你好，我是刚才给你打电话的' . $tmp[0] . '，我们公司的联系电话是' . $tmp[1] . '，欢迎后期来电咨询。【AI智能】',
				];
				$sms = new Sms($this->ytdb, $callerid, $callid, $param);
				$sms->send();
			}
		}
	}

	public function writeFile($filename = '')
	{
		$file = __DIR__ . '/daduan/' . $filename;
		file_put_contents($file, json_encode($this->nextdata));
	}

	public function getInput()
	{
		$input = trim(file_get_contents("php://input"));
		$this->input = json_decode($input, true);
//		if (in_array($this->input['callerid'], ['8200008','8100008','8000008']))
//		    Log::write($input);
		// 如果通话时间超过设置的时间，强制挂断
		if (isset($this->inline[$this->input['callerid']]['forcehangup'])) $this->forcehangup = $this->inline[$this->input['callerid']]['forcehangup'];
		if ($this->input['duration'] >= $this->forcehangup) $this->hangup('bye');
		$this->getRobot();
		// Log::write($this->input['notify']);
        if($this->input['duration']>=40){
            if($this->input['notify']=="stop_asr_result" || $this->input['notify']=='leave'){
                $this->hangup('bye');
            }
            $callee = explode('_', $this->input['calleeid']);
            $calleeid = $callee[0];
            $callid = $this->input['callid'];
            $callerid = $this->input['callerid'];
//            $this->exten="mobile15734013058";
            if (!empty($this->exten)) {

                if(strstr($this->exten,"mobile")!== false){

                    $this->saveRecord($calleeid, $callerid, $callid, '转坐席' . $this->exten);
                    $mobile=substr($this->exten,6);
                    $connect = (empty($val['record']) || !file_exists($this->sounddir . $val['record'] . '.wav')) ? '正在转接中，请等待' : $this->sounddir . $val['record'] . '.wav';

                    $this->bridge("sofia/gateway/mobileout/" . $mobile , $calleeid, "", $connect, $this->base_sounddir . "waiting.wav");

                }else{
                    $this->saveRecord($calleeid, $callerid, $callid, '转坐席' . $this->exten);
                    $connect = (empty($val['record']) || !file_exists($this->sounddir . $val['record'] . '.wav')) ? '正在转接中，请等待' : $this->sounddir . $val['record'] . '.wav';
                    $this->bridge("sofia/external/" . $this->exten . "@" . $this->self_sever . ":5099", $calleeid, "", $connect, $this->base_sounddir . "waiting.wav");
                }
            } else {
                $this->saveRecord($calleeid, $callerid, $callid, '转坐席' . $this->exten . '，坐席不在线，挂机');
                $this->play_after_hangup('坐席不在线');
            }

        }
		if ($this->input['notify'] == 'leave') {
			$callee = explode('_', $this->input['calleeid']);
			// 移除队列
			$this->deleteQueue($this->input['callerid'], $callee[0], $this->input['callid']);
			// 删除计数器日志
			if (file_exists(__DIR__ . '/daduan/' . $this->input['callid'] . '.' . $callee[0]))
				unlink(__DIR__ . '/daduan/' . $this->input['callid'] . '.' . $callee[0]);
			// 挂机短信
			// $this->sendSms($this->input['callerid'], $callee[0], $this->input['callid']);
			exit;
		}
	}

	public function ajaxReturn($data = [])
	{
//		if (in_array($this->input['callerid'],['8200008', '8100008','8000008']))
//		    Log::write($data);
		echo json_encode($data, 256);
		exit;
	}

}

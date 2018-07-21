<?php
/**
 * SmartIVR语音流程(新)
 * 2018-1-31 10:44:34
 * loonghere@qq.com
 */
require 'base.php';
class Index extends Base
{
	public function __construct()
	{
		$config = require 'config/database.php';
		$this->ytdb = new Mysql($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);
		$this->inline = require 'config/inline.php';
		$this->getInput();
		// 如果授权时间已过期，给出提示
		if ($this->authtime < time()) $this->play_after_hangup('授权已过期');
		// $this->testBridge();
		$project = isset($this->inline[$this->input['callerid']]) ? $this->inline[$this->input['callerid']]['database'] : '';
		if (empty($project)) $this->play_after_hangup('项目不存在');
		$this->sounddir = $this->base_sounddir . $project . '/';
		$this->db = new Mysql($this->config['DB_HOST'], $this->config['DB_USER'], $this->config['DB_PASS'], 'ytcc_' . $project . '_db');
		$this->getType();
		$this->getProcess();
	}

	public function detectQueue($callerid = '', $calleeid = '', $callid = '')
	{
		$sql = "select callernumber from asr_queueinfo where asrServer='$callerid' and status=1";
		$rows = $this->ytdb->getAll($sql);
		$chat = [];
		foreach ($rows as $key => $val) {
			$chat[] = $val['callernumber'];
		}
		if (!in_array($calleeid, $chat)) {
			if (count($chat) < $this->robot) {
				$this->insertQueue($callerid, $calleeid, $callid, 1);
			} else {
				$sql = "select id from asr_queueinfo where asrServer='$callerid' and callernumber='$calleeid' and status=0 limit 1";
				$exist = $this->ytdb->getOne($sql);
				if (!$exist) {
					$this->insertQueue($callerid, $calleeid, $callid);
				}
				$this->flowdata = 'enter';
				if (file_exists($this->sounddir . 'busy.wav'))
					$this->playback($this->sounddir . 'busy.wav', 2000);
				else
					$this->playback('用户正忙，请等待', 2000);
			}
		}
	}

	public function hangup($usermsg = '', $cause = 0)
	{
		$result = [
			"action" => "hangup",
			"flowdata" => $this->flowdata,
			"params" => [
				"cause" => $cause,
				"usermsg" => "$usermsg"
			],
		];
		return $this->ajaxReturn($result);
	}

	public function play_after_hangup($prompt, $suspend_asr = true, $usermsg = "", $cause = 0)
	{
		$result = [
			"action" => "playback",
			"suspend_asr" => $suspend_asr,
			"flowdata" => $this->flowdata,
			"params" => ["prompt" => $prompt],
			"after_action" => "hangup",
			"after_params" => [
				"cause" => $cause,
				"usermsg" => "$usermsg"
			],
		];
		return $this->ajaxReturn($result);
	}

	public function noop($usermsg = "")
	{
		$result = [
			"action" => "noop",
			"flowdata" => $this->flowdata,
			"params" => ["usermsg" => "$usermsg"],
		];
		return $this->ajaxReturn($result);
	}

	public function playback($prompt, $wait = 100, $suspend_asr = false, $retry = 0)
	{
		$result = [
			"action" => "playback",
			"suspend_asr" => $suspend_asr,
			"flowdata" => $this->flowdata,
			"params" => [
				"prompt" => $prompt,
				"wait" => $wait,
				"retry" => $retry,
			],
		];
		return $this->ajaxReturn($result);
	}

	public function bridge($number, $callerid = "", $gateway = "", $prompt = "", $background = "")
	{
		$result = [
			'action' => 'stop_asr',
			'flowdata' => $this->flowdata,
			'after_action' => 'bridge',
			'after_ignore_error' => false,
			'after_params' => [
				'number' => "$number",
				'callerid' => "$callerid",
				'gateway' => "$gateway",
				'prompt' => "$prompt",
				'background' => "$background",
			],
		];
		// $result = [
		// 	"action" => "bridge",
		// 	"flowdata" => $this->flowdata,
		// 	"params" => [
		// 		"number" => "$number",
		// 		"callerid" => "$callerid",
		// 		"gateway" => "$gateway",
		// 		"prompt" => "$prompt",
		// 		"background" => "$background",
		// 	],
		// ];
		return $this->ajaxReturn($result);
	}

	public function deflect($number)
	{
		$result = [
			"action" => "deflect",
			"flowdata" => $this->flowdata,
			"params" => ["number" => "$number"],
		];
		return $this->ajaxReturn($result);
	}

	public function getdtmf($prompt, $max = 128)
	{
		$result = [
			"action" => "getdtmf",
			"flowdata" => $this->flowdata,
			"params" => [
				"prompt" => "$prompt",
				"invalid_prompt" => "按键无效",
				"min" => 0,
				"max" => $max,
				"tries" => 1,
				"timeout" => 5000,
				"digit_timeout" => 3000,
				"terminators" => "#",
			],
		];
		return $this->ajaxReturn($result);
	}

	public function play_background_asr($prompt, $wait = 5000, $retry = 0)
	{
		$result = [
			'action' => 'playback',
			'flowdata' => $this->flowdata,
			'params' => [
				'prompt' => $prompt,
				'wait' => $wait,
				'retry' => $retry,
			],
			'after_action' => 'start_asr',
			'after_ignore_error' => false,
			'after_params' => [
				"min_speak_ms" => 100,
				"max_speak_ms" => 10000,
				"min_pause_ms" => 300, // 800
				"max_pause_ms" => 600, // 1000
				"pause_play_ms" => 20000,
				"threshold" => 0,
				"volume" => 50
			],
		];
		//if (file_exists($this->base_sounddir . 'robot_config/' . $this->input['callerid'] . '.json')) {
			$result['after_params']['asr_configure_filename'] = "/home/robot_sound_zhongcai/robot_config/webapi.json";//$this->base_sounddir . 'robot_config/' . $this->input['callerid'] . '.json';
		//}
		if (!empty($this->recordpath)) $result['after_params']['recordpath'] = $this->recordpath;
		return $this->ajaxReturn($result);
	}

	// pause resume stop
	public function console_playback($cmd)
	{
		$result = [
			"action" => "console_playback",
			"flowdata" => $this->flowdata,
			"params" => ["command" => "$cmd"],
		];
		return $this->ajaxReturn($result);
	}

	public function checkType($message = '', $calleeid = '', $callerid = '', $callid = '', $filename, $response = 'answer')
	{
		$type = '';
		// 如果是again再说一遍
		if ($response == 'answer' && isset($this->type['again'])) {
			foreach ($this->type['again'] as $key => $val) {
				// 空格分词，需完全顺序匹配
				$tmp = explode(' ', $val);
				$mark = $position = 0;
				foreach ($tmp as $k => $v) {
					if (!empty($v)) {
						$new_positon = strpos($message, $v);
						if ($new_positon !== false && $new_positon >= $position) {
							$mark++;
							$position = $new_positon;
						}
					}
				}
				if ($mark == count($tmp)) {
					foreach ($this->process as $key => $val) {
						if ($this->nextdata['processid'] == $val['id']) {
							if ($this->flowdata == 'empty') $this->flowdata = '';
							$this->nextdata['no_answer_times'] = 0;
							$this->nextdata['empty_times'] = 0;
							$this->nextdata['fileplayed'] = 0;
							$this->writeFile($filename);
							$wav_array = explode('|', $val['record']);
							$wav_key = array_rand($wav_array);
							$wav = $wav_array[$wav_key];
							$this->saveRecord($calleeid, $callerid, $callid, $val['answer'] . '（成功匹配：重复一遍）', $val['id'], $this->sounddir . $wav . '.wav');
							$this->playback($this->sounddir . $wav . '.wav');
							break;
						}
					}
				}
			}
		}
		unset($this->type['again']);
		// 没有匹配到，再找spec有没有
		$this->checkProcessSpec($message, $calleeid, $callerid, $callid, $filename, $response);
		// 按给定顺序查找
		// 如果是check，只识别question、refuse、negative
		if ($response == 'answer') {
			$default_type = ['question' => [], 'refuse' => [], 'negative' => [], 'neuter' => [], 'sure' => []];
			$this->type = array_merge($default_type, $this->type);
		} elseif ($response == 'check') {
			$type_tmp = $this->type;
			$this->type = [
				'question' => $type_tmp['question'],
				'refuse' => $type_tmp['refuse'],
				'negative' => $type_tmp['negative'],
			];
		}
		foreach ($this->type as $key => $val) {
			foreach ($val as $kk => $vv) {
				// 空格分词，需完全顺序匹配
				$tmp = explode(' ', $vv);
				$mark = $position = 0;
				foreach ($tmp as $k => $v) {
					if (!empty($v)) {
						$new_positon = strpos($message, $v);
						if ($new_positon !== false && $new_positon >= $position) {
							$mark++;
							$position = $new_positon;
						}
					}
				}
				if ($mark == count($tmp)) {
					$type = $key;
					break 2;
				}
			}
		}
		return $type;
	}

	public function checkProcessType($message = '', $type = '', $calleeid = '', $callerid = '', $callid = '', $filename, $response = 'answer')
	{
		// 如果是挽回，收到肯定回复，走回原流程
		$wanhui = 0;
		if (strpos($this->nextdata['nextname'], 'wanhui') !== false && in_array($type, ['sure', 'neuter'])) {
			$wanhui = 1;
		}
		Log::write('应该匹配到' . $this->nextdata['nextname'] . '.' . $type);
		foreach ($this->process as $key => $val) {
			if (($wanhui ? $this->nextdata['lastname'] : $this->nextdata['nextname']) . '.' . $type == trim($val['name'])) {
				Log::write('匹配到' . $this->nextdata['nextname'] . '.' . $type);
				if ($response == 'answer')
					$this->setProcessAnswer($calleeid, $callerid, $callid, $val, $filename);
				else
					$this->console_playback('pause');
			}
		}
	}

	public function checkProcessSpec($message = '', $calleeid = '', $callerid = '', $callid = '', $filename, $response = 'answer')
	{
		foreach ($this->process as $key => $val) {
			if ($this->nextdata['nextname'] . '.spec' == trim($val['name'])) {
				if (strpos($message, $val['condition']) !== false) {
					Log::write('匹配到' . $this->nextdata['nextname'] . '.spec' . ' 关键词：' . $val['condition']);
					if ($response == 'answer')
						$this->setProcessAnswer($calleeid, $callerid, $callid, $val, $filename);
					else
						$this->console_playback('pause');
				}
			}
		}
	}

	public function checkProcessQuestion($message = '', $calleeid = '', $callerid = '', $callid = '', $filename, $response = 'answer')
	{
		// question关键词遍历一遍，按权重weight返回
		$index = $weight = $check = 0;
		foreach ($this->process as $key => $val) {
			if (strpos($val['name'], 'question') !== false) {
				// 空格分词，需完全顺序匹配
				$tmp = explode(' ', $val['condition']);
				$mark = $position = 0;
				foreach ($tmp as $k => $v) {
					if (!empty($v)) {
						$new_positon = strpos($message, $v);
						if ($new_positon !== false && $new_positon >= $position) {
							$mark++;
							$position = $new_positon;
						}
					}
				}
				if ($mark == count($tmp)) {
					Log::write('匹配到' . $this->nextdata['nextname'] . '.question' . ' 关键词：' . $val['condition']);
					$check = 1;
					$index = !$index ? $key : (intval($val['weight']) > $weight ? $key : $index);
					$weight = !$weight ? intval($val['weight']) : (intval($val['weight']) > $weight ? intval($val['weight']) : $weight);
					Log::write('weight:' . $weight . ',index:' . $index);
				}
			}
		}
		if ($check) {
			if ($response == 'answer')
				$this->setProcessAnswer($calleeid, $callerid, $callid, $this->process[$index], $filename);
			else
				$this->console_playback('pause');
		}
	}

	public function checkProcessAny($message = '', $calleeid = '', $callerid = '', $callid = '', $filename)
	{
		foreach ($this->process as $key => $val) {
			if ($this->nextdata['nextname'] . '.any' == trim($val['name'])) {
				Log::write('匹配到' . $this->nextdata['nextname'] . '.any' . ' 关键词：' . $val['condition']);
				$this->setProcessAnswer($calleeid, $callerid, $callid, $val, $filename);
			}
		}
	}

	public function setProcessAnswer($calleeid, $callerid, $callid, $val, $filename)
	{
		if ($this->flowdata == 'empty') $this->flowdata = '';
		$this->nextdata['no_answer_times'] = 0;
		$this->nextdata['empty_times'] = 0;
		if (!in_array($val['nextname'], $this->filter_keywords))  {
			$this->nextdata['lastname'] = $val['nextname'];
		}
		$this->nextdata['name'] = trim($val['name']);
		$this->nextdata['processid'] = $val['id'];
		if (!in_array($val['nextname'], ['!', '.null', '#'])) {
			$this->nextdata['nextname'] = $val['nextname'];
		}
		$this->writeFile($filename);
		// 如果下个节点转人工
		if (in_array($val['nextname'], ['#####'])) {
			if (!empty($this->exten)) {
				if(strstr($this->exten,"mobile")!==false){
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
		// 如果下个节点挂机
		if (in_array($val['nextname'], ['#'])) {
			$this->saveRecord($calleeid, $callerid, $callid, $val['answer'] . '（成功匹配：' . $val['condition'] . '）', $val['id'], $this->sounddir . $val['record'] . '.wav');
			// 如果录音为空或者录音文件不存在，直接挂机
			if (empty($val['record']) || !file_exists($this->sounddir . $val['record'] . '.wav')) {
				$this->hangup('bye');
			}
			$this->play_after_hangup($this->sounddir . $val['record'] . '.wav');
		}
		$this->saveRecord($calleeid, $callerid, $callid, $val['answer'] . '（成功匹配：' . $val['condition'] . '）', $val['id'], $this->sounddir . $val['record'] . '.wav');
		// 判断是否有特殊需求的tts+录音播放
		if (method_exists($this, 'fun' . $callerid)) {
			$fun = 'fun' . $callerid;
			$this->$fun($val['record'], $callerid, $calleeid, $filename);
		}
		// 被打断的回答加前置录音
		if (file_exists($this->sounddir . 'interrupt.php')) {
			$interrupt = require $this->sounddir . 'interrupt.php';
		} else {
			$interrupt = [];
		}
		$wav = $this->nextdata['fileplayed'] ? $this->sounddir . $val['record'] . '.wav' : (!isset($interrupt[0]) ? [$this->base_sounddir . 'empty0.5.wav', $this->sounddir . $val['record'] . '.wav'] : [$this->sounddir . $interrupt[0]['sound'], $this->sounddir . $val['record'] . '.wav']);
		// $wav = ($this->nextdata['fileplayed'] || !isset($interrupt[0])) ? $this->sounddir . $val['record'] . '.wav' : [$this->sounddir . $interrupt[0]['sound'], $this->sounddir . $val['record'] . '.wav'];
		$this->nextdata['fileplayed'] = 0;
		$this->writeFile($filename);
		$this->playback($wav);
	}

	public function playEmptyWav($calleeid, $callerid, $callid, $empty, $index)
	{
		$default = [
			1 => '喂，听得到吗？',
			2 => '喂，在吗？',
			3 => '实在不好意思啊，我这边还是听不到您的声音啊，要么我先挂了好了，下次再跟您联系，祝您生活愉快，再见',
		];
		$word = isset($empty[$index]) ? $empty[$index]['word'] : $default[$index];
		$wavfile = isset($empty[$index]) ? $this->sounddir . $empty[$index]['sound'] : $this->base_sounddir . 'empty' . $index . '.wav';
		$this->saveRecord($calleeid, $callerid, $callid, $word, 0, $wavfile);
		// 空音应答录音前加几秒空白音，否则接话太快，三次应答分别加3、2、2秒前置空音
		if ($index < 2) {
			$wav = [$this->base_sounddir . 'empty.3.wav', $wavfile];
		} else {
			$wav = [$this->base_sounddir . 'empty.2.wav', $wavfile];
		}
		if ($index < 3) {
			if (isset($empty[$index + 1]) || !count($empty)) {
				$this->playback($wav);
			} else {
				$this->play_after_hangup($wav);
			}
		} else {
			$this->play_after_hangup($wav);
		}
	}

	public function playEmpty($calleeid, $callerid, $callid, $filename)
	{
		if ($this->flowdata == 'empty') $this->flowdata = '';
		$this->nextdata['empty_times'] += 1;
		$this->writeFile($filename);
		if (file_exists($this->sounddir . 'empty.php')) {
			$empty = require $this->sounddir . 'empty.php';
		} else {
			$empty = [];
		}
		switch ($this->nextdata['empty_times']) {
			case 1:
				$this->playEmptyWav($calleeid, $callerid, $callid, $empty, 1);
				break;
			case 2:
				$this->playEmptyWav($calleeid, $callerid, $callid, $empty, 2);
				break;
			case 3:
				$this->playEmptyWav($calleeid, $callerid, $callid, $empty, 3);
				break;
			default:
				$this->hangup('bye');
				break;
		}
	}

	public function playNohearWav($calleeid, $callerid, $callid, $nohear, $index)
	{
		$default = [
			1 => '啊，稍等一下，这里信号不是很好，您刚才说什么？',
			2 => '什么？这里信号不是很好，要么稍后我还是让我们的投资顾问再跟您联系一下，您看可以吗？',
			3 => '实在不好意思啊，我这边还是听不到您的声音啊，要么我先挂了好了，回头再跟您联系，祝您生活愉快，再见',
		];
		$word = isset($nohear[$index]) ? $nohear[$index]['word'] : $default[$index];
		$wav = isset($nohear[$index]) ? $this->sounddir . $nohear[$index]['sound'] : $this->base_sounddir . 'nohear' . $index . '.wav';
		$this->saveRecord($calleeid, $callerid, $callid, $word, 0, $wav);
		if ($index < 3) {
			if (isset($nohear[$index + 1]) || !count($nohear)) {
				$this->playback($wav);
			} else {
				$this->play_after_hangup($wav);
			}
		} else {
			$this->play_after_hangup($wav);
		}
	}

	public function playNohear($calleeid, $callerid, $callid, $filename)
	{
		if ($this->flowdata == 'empty') $this->flowdata = '';
		$this->nextdata['no_answer_times'] += 1;
		$this->writeFile($filename);
		if (file_exists($this->sounddir . 'nohear.php')) {
			$nohear = require $this->sounddir . 'nohear.php';
		} else {
			$nohear = [];
		}
		switch ($this->nextdata['no_answer_times']) {
			case 1:
				// 优先播放项目文件夹下的录音，没有则播放通用录音
				$this->playNohearWav($calleeid, $callerid, $callid, $nohear, 1);
				break;
			case 2:
				// 优先播放项目文件夹下的录音，没有则播放通用录音
				$this->playNohearWav($calleeid, $callerid, $callid, $nohear, 2);
				break;
			case 3:
				// 优先播放项目文件夹下的录音，没有则播放通用录音
				$this->playNohearWav($calleeid, $callerid, $callid, $nohear, 3);
				break;
			default:
				$word = '抱歉，我这边没听清楚，您能再说一遍吗？';
				$wav = $this->base_sounddir . 'sorrynohear.wav';
				$this->saveRecord($calleeid, $callerid, $callid, $word, 0, $wav);
				$this->play_after_hangup($wav);
				break;
		}
	}

	/**
	 * 处理多次重复识别结果的应对，比如GOIP挂机假信号的 嘟嘟嘟
	 */
	public function dealMultRepeat($message, $filename, $repeat_times = 3)
	{
		if (!isset($this->nextdata['repeat_message'])) $this->nextdata['repeat_message'] = $message;
		if (!isset($this->nextdata['repeat_times'])) $this->nextdata['repeat_times'] = 0;
		if ($this->nextdata['repeat_message'] == $message) {
			$this->nextdata['repeat_times'] += 1;
		} else {
			$this->nextdata['repeat_message'] = $message;
			$this->nextdata['repeat_times'] = 1;
		}
		$this->writeFile($filename);
		if ($this->nextdata['repeat_times'] >= $repeat_times) {
			$this->flowdata = 'hangup';
			$this->console_playback('pause');
		}
	}

	/**
	 * 开场白
	 */
	public function playStart($calleeid, $callerid, $callid, $filename)
	{
		$this->flowdata = '';
		// 开场白如果下个节点挂机
		if (in_array($this->process[1]['nextname'], ['#'])) {
			$this->saveRecord($calleeid, $callerid, $callid, $this->process[1]['answer'], $this->process[1]['id'], $this->sounddir . $this->process[1]['record'] . '.wav');
			$this->play_after_hangup($this->sounddir . $this->process[1]['record'] . '.wav');
		}
		$this->nextdata['lastname'] = $this->process[1]['nextname'];
		$this->nextdata['name'] = $this->process[1]['name'];
		$this->nextdata['processid'] = $this->process[1]['id'];
		$this->nextdata['nextname'] = $this->process[1]['nextname'];
		$this->nextdata['fileplayed'] = 0;
		$this->writeFile($filename);
		// 判断是否有特殊需求的tts+录音播放
		if (method_exists($this, 'fun' . $callerid)) {
			$this->saveRecord($calleeid, $callerid, $callid, $this->process[1]['answer'], $this->process[1]['id'], $this->sounddir . $this->process[1]['record'] . '.wav');
			$fun = 'fun' . $callerid;
			$this->$fun($this->process[1]['record'], $callerid, $calleeid, $filename);
		}
		// 随机播放开场白，录音格式“1.1|1.2|1.3”
		$wav_array = explode('|', $this->process[1]['record']);
		$wav_key = array_rand($wav_array);
		$wav = $wav_array[$wav_key];
		$this->saveRecord($calleeid, $callerid, $callid, $this->process[1]['answer'], $this->process[1]['id'], $this->sounddir . $wav . '.wav');
		$this->playback($this->sounddir . $wav . '.wav');
	}

	public function run()
	{
		if (isset($this->input['notify']) && isset($this->input['calleeid']) && isset($this->input['callerid']) && isset($this->input['callid'])) {
			$notify = $this->input['notify'];
			$callee = explode('_', $this->input['calleeid']);
			$calleeid = $callee[0];
			$this->uniqueid = isset($callee[1]) ? $callee[1] : '';
			$callerid = $this->input['callerid'];
			$callid = $this->input['callid'];
			$errorcode = isset($this->input['errorcode']) ? $this->input['errorcode'] : 0;
			$message = isset($this->input['message']) ? $this->input['message'] : '';
			$record = isset($this->input['record']) ? $this->input['record'] : '';
			$this->flowdata = isset($this->input['flowdata']) ? $this->input['flowdata'] : '';

			$filename = $callid . '.' . $calleeid;
			if (file_exists(__DIR__ . '/daduan/' . $filename)) {
				$this->nextdata = json_decode(file_get_contents(__DIR__ . '/daduan/' . $filename), true);
			} else {
				$this->writeFile($filename);
			}

			// 检测挂机
			if ($this->flowdata == 'hangup') $this->hangup('bye');

			// 检测队列，同时只允许一通接入机器人
			$this->detectQueue($callerid, $calleeid, $callid);

			if (!in_array($notify, ['asrprogress_notify', 'asrmessage_notify'])) {
				$this->nextdata['progress'] = '';
				$this->writeFile($filename);
			}

			switch ($notify) {
				case 'enter':
					$this->flowdata = '电话接通';
					$this->saveRecord($calleeid, $callerid, $callid, $this->process[0]['answer'], $this->process[0]['id'], $this->sounddir . $this->process[0]['record'] . '.wav');
					$this->play_background_asr($this->sounddir . $this->process[0]['record'] . '.wav', 1000);
					break;
				case 'playback_result':
					if ($this->flowdata == 'enter') {
						$this->flowdata = '电话接通';
						$this->saveRecord($calleeid, $callerid, $callid, $this->process[0]['answer'], $this->process[0]['id'], $this->sounddir . $this->process[0]['record'] . '.wav');
						$this->play_background_asr($this->sounddir . $this->process[0]['record'] . '.wav', 1000);
					}
					if ($this->flowdata == '电话接通') {
						$this->playStart($calleeid, $callerid, $callid, $filename);
					}
					if ($message == 'FILE PLAYED') {
						$this->nextdata['fileplayed'] = 1;
						$this->nextdata['fileplayed_timestamp'] = time();
						$this->writeFile($filename);
					}
					if ($this->flowdata == 'empty') {
						// 如果用户未说话，连续三遍，代表客户手机放一旁不说话，挂断
						$this->playEmpty($calleeid, $callerid, $callid, $filename);
					}
					// 播放个空音，避免播放完成之后一直等待用户说话
					$this->flowdata = 'empty';
					$this->playback($this->base_sounddir . 'empty.5.wav');
					break;
				case 'asrprogress_notify':
					$this->setGender($filename); // 记录识别的男女生
					if (in_array($this->flowdata, ['电话接通'])) $this->console_playback('resume');
					if (empty($message)) $this->console_playback('resume');
					$this->saveRecord($calleeid, $callerid, $callid, $message, 0, $this->input['recordfile'], 1);

					// 处理同一个识别结果达到多次以上的应答：比如GOIP挂机之后的假信号 嘟嘟嘟
					$this->dealMultRepeat($message, $filename);

					// 检查type
					$type = $this->checkType($message, $calleeid, $callerid, $callid, $filename, 'check');
					if (!empty($type)) {
						// 匹配到type，直接根据流程播放下一个语音
						Log::write('匹配到type:' . $type);
						if ($type == 'question') {
							$this->checkProcessQuestion($message, $calleeid, $callerid, $callid, $filename, 'check');
						}
						$this->checkProcessType($message, $type, $calleeid, $callerid, $callid, $filename, 'check');
					} else {
						// 没有type，优先查找question有没有
						$this->checkProcessQuestion($message, $calleeid, $callerid, $callid, $filename, 'check');
					}
					// 没有匹配到，再找spec有没有
					// $this->checkProcessSpec($message, $calleeid, $callerid, $callid, $filename, 'check');
					// 未匹配到任何关键词，录入数据库，供用户参考
					$this->saveRecordNoAnswer($calleeid, $callerid, $callid, $message, $this->input['recordfile']);
					// 什么也未匹配到，继续
					$this->nextdata['progress'] = $this->input['asrtextall'];
					$this->writeFile($filename);
					if ($this->flowdata != 'empty') {
						$this->console_playback('resume');
					} else {
						$this->console_playback('pause');
					}
					break;
				case 'asrmessage_notify':
					// 根据用户语音指令执行流程
					switch ($errorcode) {
						case 0:
							if ($this->flowdata == '电话接通') {
								$this->playStart($calleeid, $callerid, $callid, $filename);
							}
							if (empty($message)) {
								// 如果连续收到fileplayed和空音识别结果，不要走空音流程
								if ($this->nextdata['fileplayed'] && time() - $this->nextdata['fileplayed_timestamp'] > 5) {
									// 如果用户未说话，连续三遍，代表客户手机放一旁不说话，挂断
									$this->playEmpty($calleeid, $callerid, $callid, $filename);
								} else {
									// 识别为空，继续放音
									$this->console_playback('resume');
								}
							}
							if (!$this->nextdata['fileplayed'] && $message == $this->nextdata['progress']) {
								$this->console_playback('resume');
							}
							$this->nextdata['progress'] = '';
							$this->writeFile($filename);

							// 检查type
							$type = $this->checkType($message, $calleeid, $callerid, $callid, $filename);
							if (!empty($type)) {
								// 匹配到type，直接根据流程播放下一个语音
								Log::write('匹配到type:' . $type);
								if ($type == 'question') {
									$this->checkProcessQuestion($message, $calleeid, $callerid, $callid, $filename);
								}
								$this->checkProcessType($message, $type, $calleeid, $callerid, $callid, $filename);
							} else {
								// 没有type，优先查找question有没有
								$this->checkProcessQuestion($message, $calleeid, $callerid, $callid, $filename);
							}
							// 没有匹配到，再找spec有没有
							// $this->checkProcessSpec($message, $calleeid, $callerid, $callid, $filename);
							// 最后没有匹配到，再找any有没有
							$this->checkProcessAny($message, $calleeid, $callerid, $callid, $filename);
							Log::write('未匹配到任何关键词');
							// 未匹配情况下的三轮应答
							// 播放空音时出现的未识别关键词直接走未识别流程
							if ($this->flowdata == 'empty') {
								// $this->console_playback('resume');
								$this->playNohear($calleeid, $callerid, $callid, $filename);
							}
							// 如果连续收到fileplayed和空音识别结果，不要走未识别流程
							if (time() - $this->nextdata['fileplayed_timestamp'] > 5) {
								$this->playNohear($calleeid, $callerid, $callid, $filename);
							} else {
								// 继续放音
								$this->console_playback('resume');
							}
							break;
						default:
							$this->play_after_hangup('未知错误!');
							break;
					}
					break;
				case 'start_asr_result':
					if ($this->flowdata == '电话接通') {
						$this->playStart($calleeid, $callerid, $callid, $filename);
					}
					break;
				case 'asr_result':
					break;
				case 'getdtmf_result':
					break;
				case 'bridge_result':
					$this->hangup('bye');
					break;
				case 'leave':
					// 删除队列
					// $this->deleteQueue($callerid, $calleeid, $callid);
					// $this->noop();
					break;
				default:
					$this->play_after_hangup('未知通知类型');
					break;
			}
		} else {
			$this->play_after_hangup('数据错误');
		}
	}
}

$index = new Index;
$index->run();

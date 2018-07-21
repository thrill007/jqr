<?php
/**
 * 智能机器人号码与项目数据库对应表
 * 2018-1-10 09:30:40
 * loonghere@qq.com
 * v1版本每个机器人是否打断总开关，mode 0 允许打断 1 不打断
 * v2版本包括了智能打断，不需要mode了
 * 最新 7778020
 */

return [
	// 本机测试
	'1002' => ['database' => 'jishicaijing', 'mode' => 1, 'version' => 'v2', 'alias' => '即时财经'],
	'10101010' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'],
	// 我们测试
	'7777778' => ['database' => 'ytfangdichan', 'mode' => 1, 'version' => 'v1', 'alias' => '房地产'], // 房地产
	'7777779' => ['database' => 'ytjinrong', 'mode' => 1, 'version' => 'v2', 'alias' => '金融'], // 金融
	'7777780' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '智能机器人'], // 智能机器人
	'7777781' => ['database' => 'ytjinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777782' => ['database' => 'ytjiaju', 'mode' => 1, 'version' => 'v2', 'alias' => '家具家装'], // 家具家装
	'7777783' => ['database' => 'ytjianzaoshipeixun', 'mode' => 1, 'version' => 'v2', 'alias' => '建造师培训'], // 建造师培训
	'7777784' => ['database' => 'ytgupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资'], // 股票投资
	'7777785' => ['database' => 'ytchaye', 'mode' => 1, 'version' => 'v2', 'alias' => '茶叶'], // 茶叶
	'7777786' => ['database' => 'chuncui', 'mode' => 1, 'version' => 'v2', 'alias' => '纯粹科技'], // 纯粹科技
	'7777787' => ['database' => 'ytzhuangshi', 'mode' => 1, 'version' => 'v2', 'alias' => '装饰'], // 装饰
	'7777788' => ['database' => 'yt58supin', 'mode' => 1, 'version' => 'v2', 'alias' => '58速聘'], // 58速聘
	'7777875' => ['database' => 'ytbaijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	'7777794' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '沈瑞测试'], // 沈瑞测试
	// 开发测试用
	'7777789' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'],
	// 安总客户
	'7777777' => ['database' => 'jiaguojiqiren', 'mode' => 1, 'version' => 'v2', 'alias' => '安总自用机器人'], // 安总自用机器人
	'7777935' => ['database' => 'jiaguojiqirenhuru', 'mode' => 1, 'version' => 'v2', 'alias' => '安总自用机器人-呼入'], // 安总自用机器人-呼入
	'7777946' => ['database' => 'jiaguoxiaochengxu', 'mode' => 1, 'version' => 'v2', 'alias' => '小程序'], // 小程序
	'7777976' => ['database' => 'tengdashengshi', 'mode' => 1, 'version' => 'v2', 'alias' => '支付宝小程序'], // 支付宝小程序
	'7777978' => ['database' => 'taiwanqihuo', 'mode' => 1, 'version' => 'v2', 'alias' => '台湾期货'], // 台湾期货
	'7777834' => ['database' => 'qixingjiancai', 'mode' => 1, 'version' => 'v2', 'alias' => '七星'], // 七星
	'7777982' => ['database' => 'qixingjiancainew', 'mode' => 1, 'version' => 'v2', 'alias' => '七星3.28'], // 七星3.28
	'7777895' => ['database' => 'jiaguozhaoshang', 'mode' => 1, 'version' => 'v2', 'alias' => '佳果招商'], // 佳果招商
	'7777952' => ['database' => 'jiaguowxopen', 'mode' => 1, 'version' => 'v2', 'alias' => '微信小程序'], // 佳果招商微信小程序
	'7777947' => ['database' => 'sanzhitu', 'mode' => 1, 'version' => 'v2', 'alias' => '三只兔'], // 三只兔装饰设计工程有限公司
	// 公司自用
	'7777823' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '上海言通'], // 上海言通
	'7777824' => ['database' => 'hefeiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '合肥言通'], // 合肥言通
	'7777825' => ['database' => 'nanjingyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '南京言通'], // 南京言通
	// 公司客户
	'7777796' => ['database' => 'jinbin', 'mode' => 1, 'version' => 'v2', 'alias' => '靖斌投资'], // 靖斌投资1
	'7777821' => ['database' => 'jinbin', 'mode' => 1, 'version' => 'v2', 'alias' => '靖斌投资'], // 靖斌投资2
	'7777797' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝1
	'7777827' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝2
	'7777859' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝3
	'7777860' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝4
	'7777861' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝5
	'7777862' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝6
	'7777863' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝7
	'7777864' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝8
	'7777865' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝9
	'7777866' => ['database' => 'heqibao', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 合期宝10
	'7777798' => ['database' => 'wanlong', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 万龙1
	'7777828' => ['database' => 'wanlong', 'mode' => 1, 'version' => 'v2', 'alias' => '合期宝'], // 万龙2
	'7777799' => ['database' => 'jiuzhoudaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '九州贷款'], // 九州贷款1
	'7777829' => ['database' => 'jiuzhoudaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '九州贷款'], // 九州贷款2
	// '7777800' => ['database' => 'fanyuanzichan', 'mode' => 1, 'version' => 'v2', 'alias' => '繁元资产'], // 繁元资产1
	// '7777830' => ['database' => 'fanyuanzichan', 'mode' => 1, 'version' => 'v2', 'alias' => '繁元资产'], // 繁元资产2
	'7777801' => ['database' => 'guizhouweixin', 'mode' => 1, 'version' => 'v2', 'alias' => '贵州唯信'], // 贵州唯信
	'7777822' => ['database' => 'wuxikangfeng', 'mode' => 1, 'version' => 'v2', 'alias' => '无锡康丰'], // 无锡康丰1
	'7777832' => ['database' => 'wuxikangfeng', 'mode' => 1, 'version' => 'v2', 'alias' => '无锡康丰'], // 无锡康丰2
	'7777826' => ['database' => 'huaqitouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '华杞投资'], // 华杞投资1
	'7777833' => ['database' => 'huaqitouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '华杞投资'], // 华杞投资2
	'7777838' => ['database' => 'tongbao', 'mode' => 1, 'version' => 'v2', 'alias' => '统宝文化传媒'], // 统宝文化传媒
	'7777857' => ['database' => '91daikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '91贷款网'], // 91贷款网1
	'7777858' => ['database' => '91daikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '91贷款网'], // 91贷款网2
	'7777792' => ['database' => 'taobaojinfu', 'mode' => 1, 'version' => 'v2', 'alias' => '涛宝金服'], // 涛宝金服1
	'7777793' => ['database' => 'taobaojinfu', 'mode' => 1, 'version' => 'v2', 'alias' => '涛宝金服'], // 涛宝金服2
	'7777867' => ['database' => 'matengtouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '马腾投资'], // 马腾投资1
	'7777868' => ['database' => 'matengtouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '马腾投资'], // 马腾投资2
	'7777869' => ['database' => 'matengtouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '马腾投资'], // 马腾投资3
	'7777870' => ['database' => 'matengtouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '马腾投资'], // 马腾投资4
	'7777871' => ['database' => 'matengtouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '马腾投资'], // 马腾投资5
	'7777885' => ['database' => 'jishicaijing', 'mode' => 1, 'version' => 'v2', 'alias' => '及十财经'], // 及十财经1
	'7777886' => ['database' => 'jishicaijing', 'mode' => 1, 'version' => 'v2', 'alias' => '及十财经'], // 及十财经2
	// '7777887' => ['database' => 'chenghaoxingxi', 'mode' => 1, 'version' => 'v2', 'alias' => '澄浩信息'], // 澄浩信息
	'7777835' => ['database' => 'yulanshangwu', 'mode' => 1, 'version' => 'v2', 'alias' => '彧澜商务'], // 彧澜商务
	'7777836' => ['database' => 'gangaozixun', 'mode' => 1, 'version' => 'v1', 'alias' => '港澳资讯'], // 港澳资讯
	'7777837' => ['database' => 'sajitouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '萨基投资'], // 萨基投资
	'7777853' => ['database' => 'yuanchun', 'mode' => 1, 'version' => 'v2', 'alias' => '原醇'], // 原醇
	// '7777880' => ['database' => 'shengshichanglong', 'mode' => 1, 'version' => 'v2', 'alias' => '安徽盛世昌隆'], // 安徽盛世昌隆
	'7777881' => ['database' => 'luyoujiuzhoudaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '女金融贷款'], // 陆游女金融贷款 九州贷款
	'7777890' => ['database' => 'luyougangaozixun', 'mode' => 1, 'version' => 'v1', 'alias' => '男金融贷款'], // 陆游男金融贷款 港澳资讯
	'7777891' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '代理机器人'], // 陆游代理机器人 上海言通
	'7777892' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 陆游房地产
	'7777888' => ['database' => 'vipkid', 'mode' => 1, 'version' => 'v2', 'alias' => 'vipkid'], // vipkid
	'7777889' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '珠江人寿'], // 珠江人寿
	'7777893' => ['database' => 'changchunshebao', 'mode' => 1, 'version' => 'v2', 'alias' => '长春社保'], // 长春社保
	'7777901' => ['database' => 'dongfangchengan', 'mode' => 1, 'version' => 'v2', 'alias' => '东方成安私募基金'], // 东方成安私募基金
	'7777902' => ['database' => 'qindaotouzi', 'mode' => 1, 'version' => 'v1', 'alias' => '钦道投资'], // 钦道投资
	'7777977' => ['database' => 'qindaotouzi', 'mode' => 1, 'version' => 'v1', 'alias' => '钦道投资'], //钦道投资
	'7777906' => ['database' => 'antuana', 'mode' => 1, 'version' => 'v2', 'alias' => '吴荟芳录音'], // 安团1
	'7777948' => ['database' => 'antuanb', 'mode' => 1, 'version' => 'v2', 'alias' => '蒋瑶录音'], // 安团2
	'7777907' => ['database' => 'wuxihengde', 'mode' => 1, 'version' => 'v2', 'alias' => '无锡衡德'], // 无锡衡德
	'7777908' => ['database' => 'jiafengbaoxian', 'mode' => 1, 'version' => 'v2', 'alias' => '迦丰保险'], // 迦丰保险
	'7777909' => ['database' => 'fanpuxin', 'mode' => 1, 'version' => 'v2', 'alias' => '凡普信'], // 凡普信
	'7777910' => ['database' => 'nanjingyinghuang', 'mode' => 1, 'version' => 'v2', 'alias' => '南京英皇装饰'], // 南京英皇装饰
	'7777911' => ['database' => 'yunyin', 'mode' => 1, 'version' => 'v2', 'alias' => '上海韵迎'], // 上海韵迎（合期宝）
	'7777912' => ['database' => 'hengdejiuba', 'mode' => 1, 'version' => 'v2', 'alias' => '衡德酒吧'], // 衡德酒吧
	'7777913' => ['database' => 'hongtaiju', 'mode' => 1, 'version' => 'v2', 'alias' => '宏泰聚'], // 宏泰聚投资顾问有限公司
	'7777914' => ['database' => 'baofuguoji', 'mode' => 1, 'version' => 'v2', 'alias' => '宝富国际'], // 宝富国际
	'7777916' => ['database' => 'fujianguodingxin', 'mode' => 1, 'version' => 'v2', 'alias' => '国鼎鑫'], // 福建国鼎鑫文化传媒
	'7777917' => ['database' => 'wanlihong', 'mode' => 1, 'version' => 'v2', 'alias' => '万里红'], // 万里红
	'7777918' => ['database' => 'dawanwangluo', 'mode' => 1, 'version' => 'v2', 'alias' => '大宛网络'], // 大宛网络科技公司
	'7777919' => ['database' => 'wenzonga', 'mode' => 1, 'version' => 'v2', 'alias' => '文总-男生'], // 文总-男生
	'7777920' => ['database' => 'wenzongb', 'mode' => 1, 'version' => 'v2', 'alias' => '文总-女声'], // 文总-女声
	'7777922' => ['database' => 'zhengquanzhixing', 'mode' => 1, 'version' => 'v2', 'alias' => '证券之星'], // 证券之星
	'7777923' => ['database' => 'ec', 'mode' => 1, 'version' => 'v2', 'alias' => '办易启'], // 照坤科技（办易启）
	'7777936' => ['database' => 'yinhaishiye', 'mode' => 1, 'version' => 'v1', 'alias' => '印海实业'], // 上海印海实业
	'7777937' => ['database' => 'taikangbaoxian', 'mode' => 1, 'version' => 'v2', 'alias' => '泰康保险集团'], // 泰康保险集团
	'7777939' => ['database' => 'xinmengwenhua', 'mode' => 1, 'version' => 'v2', 'alias' => '信盟文化传媒'], // 信盟文化传媒
	'7777940' => ['database' => 'zhongcaicaipiao', 'mode' => 1, 'version' => 'v2', 'alias' => '中彩彩票'], // 中彩彩票
	'7777975' => ['database' => 'zhongcaicaipiaob', 'mode' => 1, 'version' => 'v2', 'alias' => '中彩彩票2'], //中彩彩票2
	'7777983' => ['database' => 'bocai', 'mode' => 1, 'version' => 'v2', 'alias' => '博彩'], //博彩
	'7777986' => ['database' => 'bocai2', 'mode' => 1, 'version' => 'v2', 'alias' => '博彩'], //博彩2
    '7777987' => ['database' => 'bocai3', 'mode' => 1, 'version' => 'v2', 'alias' => '博彩'], //博彩3
	'7777979' => ['database' => 'changhong', 'mode' => 1, 'version' => 'v2', 'alias' => '长虹'], //长虹
	'7777980' => ['database' => 'zongcai', 'mode' => 1, 'version' => 'v2', 'alias' => '总裁'], //总裁
    '7777981' => ['database' => 'dahua', 'mode' => 1, 'version' => 'v2', 'alias' => '大话'], //大话
	'7777949' => ['database' => 'zhongyingjinrongb', 'mode' => 1, 'version' => 'v2', 'alias' => '中英金融'], // 中英金融
	'7777950' => ['database' => 'qianqiutong', 'mode' => 1, 'version' => 'v2', 'alias' => '钱求通'], // 钱求通
	'7777951' => ['database' => 'anyuetengda', 'mode' => 1, 'version' => 'v2', 'alias' => '安跃腾达'], //安跃腾达
	'7777953' => ['database' => 'zhongshengtai', 'mode' => 1, 'version' => 'v2', 'alias' => '中升泰'], // 中升泰
	'7777954' => ['database' => 'jingshijinfu', 'mode' => 1, 'version' => 'v2', 'alias' => '京世金服'], //京世金服
	'7777955' => ['database' => 'desen', 'mode' => 1, 'version' => 'v2', 'alias' => '德森'], //德森
	'7777958' => ['database' => 'quanniuguquan', 'mode' => 1, 'version' => 'v2', 'alias' => '全牛股权'], //全牛股权
	'7777959' => ['database' => 'bohutouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '伯虎投资'], //伯虎投资
	'7777964' => ['database' => 'zhongzicuishou', 'mode' => 1, 'version' => 'v2', 'alias' => '中资催收'], //中资催收
	'7777967' => ['database' => 'hefeimeipinhui', 'mode' => 1, 'version' => 'v2', 'alias' => '合肥美品惠'], //合肥美品惠
	'7777968' => ['database' => 'yijiedai', 'mode' => 1, 'version' => 'v2', 'alias' => '易捷贷'], //易捷贷
	'7777969' => ['database' => 'zhendingshangwu', 'mode' => 1, 'version' => 'v2', 'alias' => '臻顶商务'], // 臻顶商务
	// 东营东瑞代理
	'7777894' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞自用'], // 东营东瑞代理自用
	'7777974' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞自用2'], //东营东瑞代理自用2
	// '7777903' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v2', 'alias' => '东营东瑞'], // 东营东瑞2
	// '7777904' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v2', 'alias' => '东营东瑞'], // 东营东瑞3
	// '7777905' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v2', 'alias' => '东营东瑞'], // 东营东瑞4
	'7777921' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞地产经济'], // 东营东瑞地产经济
	'7777960' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞地产经济'], // 东营东瑞地产经济2
	'7777961' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞地产经济'], // 东营东瑞地产经济3
	'7777962' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞地产经济'], // 东营东瑞地产经济4
	'7777963' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v1', 'alias' => '东营东瑞地产经济'], // 东营东瑞地产经济5
	'7777985' => ['database' => 'dongyingdongrui', 'mode' => 1, 'version' => 'v2', 'alias' => '东营东瑞地产经济'], //东营东瑞地产经济6
	// 安总客户
	'7777802' => ['database' => 'chengyuedailicaiwu', 'mode' => 1, 'version' => 'v2', 'alias' => '宸悦财税'], // 宸悦财税
	'7777803' => ['database' => 'xianyishupinshoucang', 'mode' => 1, 'version' => 'v2', 'alias' => '西安藏友阁'], // 西安藏友阁
	'7777804' => ['database' => 'guodianshoucangpin', 'mode' => 1, 'version' => 'v2', 'alias' => '西安国典艺术品'], // 西安国典艺术品
	'7777805' => ['database' => 'bodingshoucangpin', 'mode' => 1, 'version' => 'v2', 'alias' => '西安博鼎'], // 西安博鼎
	'7777806' => ['database' => 'huanqiujinrong', 'mode' => 1, 'version' => 'v2', 'alias' => '环球金融'], // 环球金融
	'7777807' => ['database' => 'jinketianlaicheng', 'mode' => 1, 'version' => 'v2', 'alias' => '金科天籁城'], // 金科天籁城
	'7777808' => ['database' => 'xunrongjingrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '西安讯融金服'], // 西安讯融金服
	'7777809' => ['database' => 'xigemajinrong', 'mode' => 1, 'version' => 'v2', 'alias' => '西格玛金融'], // 西格玛金融
	'7777810' => ['database' => 'juguangjinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '西安鑫泰金融'], // 西安鑫泰金融
	'7777811' => ['database' => 'hanhongjinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '西安瀚泓盛世'], // 西安瀚泓盛世
	'7777812' => ['database' => 'hanyanembajiaoyu', 'mode' => 1, 'version' => 'v2', 'alias' => '北大后EMBA'], // 北大后EMBA
	'7777813' => ['database' => 'yingtaizhuangshihuodong', 'mode' => 1, 'version' => 'v2', 'alias' => '银泰装饰'], // 银泰装饰
	'7777814' => ['database' => 'manao', 'mode' => 1, 'version' => 'v2', 'alias' => '玛瑙装饰'], // 玛瑙装饰
	'7777815' => ['database' => 'ajia', 'mode' => 1, 'version' => 'v2', 'alias' => 'A家家居'], // A家家居
	'7777816' => ['database' => 'xinpanjilanhujiujun', 'mode' => 1, 'version' => 'v2', 'alias' => '西安红郡'], // 西安红郡
	'7777817' => ['database' => 'tongchuanshangyemingcheng', 'mode' => 1, 'version' => 'v2', 'alias' => '铜川上野名城'], // 铜川上野名城
	'7777818' => ['database' => 'puyuejinjiangzhixinggongyu', 'mode' => 1, 'version' => 'v2', 'alias' => '徐州锦江之星'], // 徐州锦江之星
	'7777819' => ['database' => 'wanzicaiwuguanli', 'mode' => 1, 'version' => 'v2', 'alias' => '西安万资财务'], // 西安万资财务
	'7777820' => ['database' => 'huaxucaiwuzixun', 'mode' => 1, 'version' => 'v2', 'alias' => '西安华旭财税'], // 西安华旭财税
	// 黄小辉代理
	'7777795' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 黄小辉1
	'7777831' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 黄小辉2
	// 成都刘耀园代理
	'7777839' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777840' => ['database' => 'jinrong', 'mode' => 1, 'version' => 'v2', 'alias' => '金融'], // 金融
	'7777841' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '智能机器人'], // 智能机器人
	'7777842' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777843' => ['database' => 'jiaju', 'mode' => 1, 'version' => 'v2', 'alias' => '家具家装'], // 家具家装
	'7777844' => ['database' => 'jianzaoshipeixun', 'mode' => 1, 'version' => 'v2', 'alias' => '建造师培训'], // 建造师培训
	'7777845' => ['database' => 'gupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资'], // 股票投资
	'7777846' => ['database' => 'chaye', 'mode' => 1, 'version' => 'v2', 'alias' => '茶叶'], // 茶叶
	'7777847' => ['database' => 'chuncui', 'mode' => 1, 'version' => 'v2', 'alias' => '纯粹科技'], // 纯粹科技
	'7777848' => ['database' => 'zhuangshi', 'mode' => 1, 'version' => 'v2', 'alias' => '装饰'], // 装饰
	'7777849' => ['database' => '58supin', 'mode' => 1, 'version' => 'v2', 'alias' => '58速聘'], // 58速聘
	'7777850' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	// 苏州代理
	'7777851' => ['database' => 'jinrong', 'mode' => 1, 'version' => 'v2', 'alias' => '金融'], // 金融
	'7777852' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777854' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777855' => ['database' => 'jiaju', 'mode' => 1, 'version' => 'v2', 'alias' => '家具家装'], // 家具家装
	'7777856' => ['database' => 'jianzaoshipeixun', 'mode' => 1, 'version' => 'v2', 'alias' => '建造师培训'], // 建造师培训
	'7777872' => ['database' => 'gupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资'], // 股票投资
	'7777873' => ['database' => 'chaye', 'mode' => 1, 'version' => 'v2', 'alias' => '茶叶'], // 茶叶
	'7777874' => ['database' => 'zhuangshi', 'mode' => 1, 'version' => 'v2', 'alias' => '装饰'], // 装饰
	'7777876' => ['database' => '58supin', 'mode' => 1, 'version' => 'v2', 'alias' => '58速聘'], // 58速聘
	'7777877' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	// 广州代理
	'7777878' => ['database' => 'jinrong', 'mode' => 1, 'version' => 'v2', 'alias' => '金融'], // 金融
	'7777879' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	// 深圳王永峰
	'7777882' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777883' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	'7777884' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777970' => ['database' => 'taikangbaoxian', 'mode' => 1, 'version' => 'v2', 'alias' => '泰康保险'], // 泰康保险
	// 沈总代理测试
	'7777896' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777897' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	'7777898' => ['database' => 'jiaju', 'mode' => 1, 'version' => 'v2', 'alias' => '家具家装'], // 家具家装
	'7777899' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777900' => ['database' => 'gupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资'], // 股票投资
	'7777971' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款呼入'], // 金融贷款
	'7777972' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒呼入'], // 白酒
	'7777973' => ['database' => 'gupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资呼入'], // 股票投资
	// 杨总群泰代理
	'7777915' => ['database' => 'quntai', 'mode' => 1, 'version' => 'v2', 'alias' => '机器人'], // 上海言通机器人
	'7777924' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777925' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	'7777926' => ['database' => '58supin', 'mode' => 1, 'version' => 'v2', 'alias' => '58速聘'], // 58速聘
	'7777927' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777928' => ['database' => 'jiaju', 'mode' => 1, 'version' => 'v2', 'alias' => '家装家具'], // 家装家具
	// 江苏常州代理
	'7777929' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '机器人'], // 上海言通机器人
	'7777930' => ['database' => 'changzhoufangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777931' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	'7777932' => ['database' => 'zhuangshi', 'mode' => 1, 'version' => 'v2', 'alias' => '装饰'], // 装饰
	'7777933' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777934' => ['database' => 'gupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资'], // 股票投资
	// 何红文代理
	'7777938' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => '机器人'], // 上海言通机器人
	// 湖北盈享网络(湖北省总代）
	'7777941' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777942' => ['database' => 'baijiu', 'mode' => 1, 'version' => 'v2', 'alias' => '白酒'], // 白酒
	'7777943' => ['database' => 'zhuangshi', 'mode' => 1, 'version' => 'v2', 'alias' => '装饰'], // 装饰
	'7777944' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777945' => ['database' => 'gupiaotouzi', 'mode' => 1, 'version' => 'v2', 'alias' => '股票投资'], // 股票投资
	// 罗（云南代理）
	'7777956' => ['database' => 'fangdichan', 'mode' => 1, 'version' => 'v2', 'alias' => '房地产'], // 房地产
	'7777957' => ['database' => 'jinrongdaikuan', 'mode' => 1, 'version' => 'v2', 'alias' => '金融贷款'], // 金融贷款
	'7777984' => ['database' => 'wankebeichenzhiguang', 'mode' => 1, 'version' => 'v2', 'alias' => '万科北辰之光'], // 万科北辰之光
	'7777988' => ['database' => 'dadajiazhuang', 'mode' => 1, 'version' => 'v2', 'alias' => '哒哒家装'], // 哒哒家装
	
	
	// 待用机器人号码
	
	// '7777989' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => ''], //
	// '7777990' => ['database' => 'shanghaiyantong', 'mode' => 1, 'version' => 'v2', 'alias' => ''], //
];
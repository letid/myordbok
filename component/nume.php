<?php
/*
$o = new nune('4333');
$o->request();
*/
namespace app\component
{
	class nume
	{
		private static $number = array(
			0 => 'သုည', 1 => 'တစ်', 2 => 'နှစ်', 3 => 'သုံး', 4 => 'လေး',
			5 => 'ငါး', 6 => 'ခြောက်', 7 => 'ခုနစ်', 8 => 'ရှစ်', 9 =>'ကိုး'
		);
		private static $digit = array(
			0 => "ဝ", 1 => "၁", 2 => "၂", 3 => "၃", 4 => "၄", 5 => "၅", 6 => "၆", 7 => "၇", 8 => "၈", 9 =>"၉"
		);
		private static $name = array(
			1 => '',
			// 1 => 'ခု',
			2 => 'ဆယ်',
			3 => 'ရာ',
			4 => 'ထောင်',
			5 => 'သောင်း',
			6 => 'သိန်း',
			7 => 'သန်း',
			8 => 'ကု​ဋေ​'
		);
		private static $nameCreakyTone = array(
			2 => 'ဆယ့်',
			// 3 => 'ရာ့',
			3 => 'ရာနှင့်',
			4 => 'ထောင့်'
		);
		private static $conjunction = array(
			'space' => ' ',
			'comma' => '၊ ',
			'and' => 'နှင့်',
			'plus' => 'ပေါင်း',
			'over' => 'ကျော်'
		);
		private static $baseLead = 0;
		public $result = array();
		function __construct($q) {
			$this->q = $q;
		}
		public function request() {
			$qume = str_split($this->q, 8);
			$this->qumeCount = count($qume);
			if ($this->q < 1) {
				$this->result['zero'] = self::$number[0];
			} else {
				$this->result['k8']=$this->translate(8);
				$this->result['k7']=$this->translate(7);
				$this->result['k6']=$this->translate(6);
			}
			$this->result['di']=strtr($this->q, self::$digit);
			return array_filter($this->result);
		}
		private function translate($strlen_by=8)
		{
			$temp = array();
			$rem = array();
			$numePrefix = 0;
			$numeSuffix = array();
			$numeOver= 0;

			$nume = str_split($this->q, $strlen_by);
			$numeOne = str_split($this->q, 1);
			$numeOneCount = count($numeOne);
			$numeCount = count($nume);
			$numeSplit = 8;
			// $temp['nume']=$nume;
			$numeEndCount=strlen(end($nume));
			// $temp['numeEndCount']=$numeEndCount;

			$numeEndCount_is=($numeEndCount == $strlen_by)?true:false;
			$numeCountBase=floor($numeCount-1/8);
			// $temp['numeCountBase']=$numeCountBase;
			if ($numeCount > 1) {
				$rem[]  = self::$name[$strlen_by];
				$numePlus = $strlen_by+$numeCountBase;
				// $temp['_plus_num'] = str_pad('1',$numePlus,'0');
				$numeRest = $numeOneCount-$strlen_by;
				if ($numeCount > 2) {
					$numeOver = true;
					$numeSplit = $numeRest;
					if ($numeRest>8){
						$numePrefix=8;
						$numeSplit = $numeCountBase;
						$numePad = $numeRest % 8;
						$numeDiv = floor($numeRest/8);
						if ($numePad > 0) {
							$numeSplit = $numePad;
						}
						if ($numeDiv>1){
							for ($i = 2; $i <= $numeDiv; $i++) $numeSuffix[]=self::$name[$numePrefix];
						}
					}
					$rem[]=self::padding($numeCount);
				} else {
					$numeSplit = $numeCountBase+$numeEndCount;
					if ($numeSplit >= 6) $numeOver = true;
				}

				if ($numeCountBase>7){
					$rem[]=self::$name[$numePrefix];
				}
				if ($numeOver) $rem[]=self::$conjunction['plus'].self::$conjunction['space'];
				if ($numePrefix) $rem[]=self::$name[$numePrefix];
				$r = self::phrase($this->q, $numeSplit);
				$rem[]=$r[0];

				if ($numeSuffix) {
					$rem[]=implode(self::$conjunction['comma'],$numeSuffix);
				}
				if (count($r)>1) {
					$rem[]=self::$conjunction['space'].self::$conjunction['over'];
				}
			} else if ($numeEndCount <= $strlen_by && $strlen_by==8) {
				return self::chain(self::phrase($this->q));
			}
			return implode('',$rem);

		}
		private function padding($str,$number=1)
		{
			$number = str_pad($number,  $str, "0");
			return self::chain(self::phrase($number));
		}
		private function phrase($number,$strlen_by=8)
		{
			$r=array();
			foreach (str_split($number, $strlen_by)as $k=>$v) $r[]=self::parser($k,$v);
			return array_filter($r);
		}
		private function parser($Keys, $Values, $Methods=array(), $split_by='',$split_last='')
    {
			$base = str_split($Values);
			$baseCount = count($base);
			if ($Keys > 0) {
				self::$baseLead += $baseCount;
				// $this->baseLead += $baseCount;
			}
			$r=array();
			foreach ($base as $k => $num) {
				if ($num > 0) {
					$r[]=array($num, $baseCount-$k);
				}
			}
			$x =array();
			foreach ($r as $k => $v) {
				$vAfter = isset($r[$k+1])?$r[$k+1]:0;
				$vName = $v[0];
				$vBase = $v[1];
				if ($vAfter>0 && isset(self::$nameCreakyTone[$vBase]) ) {
					$base = self::$nameCreakyTone[$vBase];
				} else {
					$base = self::$name[$vBase];
				}
				$nume = self::$number[$vName];
				if (is_callable(array($this,$Methods))) {
					$x[]=call_user_func_array(array($this,$Methods), array($v,$nume,$base));
				} else {
					$x[]=$nume.$base;
				}
			}
			return self::chain($x,$split_by,$split_last);
    }
		private static function chain($n,$x=' ',$y='')
    {
      return implode($y, array_filter(array_merge(array(join($x, array_slice($n, 0, -1))), array_slice($n, -1)), 'strlen'));
    }
  }
}
?>

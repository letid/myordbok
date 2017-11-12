<?
class antRemove
{
	var $file_moby_thesaurus = 'DATABASE/MOBY/moby_thesaurus.txt';
	var $class_moby_thesaurus = 'class.mobythesaurus.php';
	public function home()
	{
		return call_user_func(array($this,$this->action));
	}
	public function thesaurus()
	{
		require_once $this->class_moby_thesaurus;
		if($q=$this->laid or $q=$this->q);
		//if($q and $x = mobythesaurus::GetSynonyms(self::$init['storage.server'].$this->file_moby_thesaurus,$q)) return $x;
		if($q and $x = mobythesaurus::GetSynonyms(self::$init['storage.server'].$this->file_moby_thesaurus,$q)) {
			foreach($x as $d)$l[]=array('t'=>'a', 'd'=>array('href'=>'?q='.$d,'text'=>$d));
			$r['zj'][]=array('t'=>'p', 'l'=>$l);
			return $r;
		}
	}
	public function antonym()
	{
		if($db=self::ant_query($this->q) and $db->total){
			return self::ant_help($db->rows,$this->q);
		}elseif($db=self::der_query($this->q) and $db->total){
			static $f=array();
			foreach($db->rows as $w => $d){
				if($d['word']!=$this->q and $word=$d['word']){
					if(!isset($f[$word]) and $x=self::ant_query($word) and $x->total and $f[$word]=true){
						$r=self::ant_help($x->rows,$word);
					}elseif($derive=$d['derive'] and !isset($f[$derive]) and $y=self::ant_query($derive) and $y->total){
						$r=self::ant_help($y->rows,$derive);
					}
				}
			}
			return $r;
		}
	}
	private function ant_query($q)
	{
		$g=addslashes($q);
		return new sql("t",'fetch_array');
	}
	private function ant_help($data,$q)
	{
		/*
		foreach($data as $w => $d){
			if(strcasecmp($q, $d['w1']) == 0)$r[]=$d['w2'];
				else $r[]=$d['w1'];
		}
		return array_unique(array_filter($r));
		*/

		//$l[]=array('t'=>'i', 'd'=>array('text'=>(count($data) > 1)?'are':'is'));
		foreach($data as $w => $d){
			if(strcasecmp($q, $d['w1']) == 0) $l[]=array('t'=>'a', 'd'=>array('href'=>'?q='.$d['w2'],'text'=>$d['w2']));
				else $l[]=array('t'=>'a', 'd'=>array('href'=>'?q='.$d['w1'],'text'=>$d['w1']));
		}
		$r['zj'][]=array('t'=>'p', 'l'=>$l);
		return array_unique(array_filter($r));
	}
	private function der_query($q)
	{
		$g=addslashes($q);
		return new sql("SELECT
			w.word_id AS id, w.word AS word, de.word AS derive, de.derived_type AS d_type, de.word_type AS w_type, wt.name AS wame, dt.derivation AS dame
		FROM en_derive de
			INNER JOIN en_word w ON w.word_id=de.root_id
			INNER JOIN en_derive_type dt ON dt.derived_type=de.derived_type
			INNER JOIN en_word_type wt ON wt.word_type=de.word_type
				WHERE (de.word='$q' OR w.word='$q') and (de.derived_type <> 0 OR de.word_type = 0);",'fetch_array');
	}
	private function wod_query($q)
	{
		$g=addslashes($q);
		return new sql("SELECT *
		FROM en_word AS w
			WHERE w.word='$g';",'fetch_array');
	}
	public function thesaurus_wordweb()
	{
		if($db=self::thesaurus_wordweb_query($this->q) and $db->total){
			while($r=$db->result->fetch_assoc())$d[$r['wame']][]=$r['word'];
			return $d;
		}
	}
	private function thesaurus_wordweb_query($q)
	{
		$g=addslashes($q);
		return new sql("SELECT DISTINCT w2.word, wt.name AS wame
		FROM en_sense AS w1,en_sense AS w2
			INNER JOIN en_word_type wt ON wt.word_type=w2.word_type
				WHERE w1.equiv_word='$g' AND w1.ID=w2.ID AND w1.word_sense!=w2.word_sense
				ORDER BY w2.word_type,w2.word;");
	}
}

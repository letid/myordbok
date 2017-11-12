<?php
namespace app\dictionary
{
  trait traitMathematic
  {
    private function requestMathematic($q)
    {
      $o = new \app\component\math;
      if($e= $o->evaluate($q) and $q != $e){
        if($v=$o->vars()):
          foreach($v as $key=>$val) $r['Equation'][]=array(
            'math equat'=>sprintf('<em>%s</em> is <b>%d</b>', $key,$val)
          );
        else:
          $r['Equation'][]=array(
            'math equat'=>sprintf('<em>%d</em> is equal to <b>%s</b>', $q,number_format($e))
          );
        endif;
        $r['Evaluation'][]= array('math eval'=>$e);
        if($e !=$o->e($q))$r['Synonym'][]=array('synonym'=>$o->e($q));
        if($f=$o->funcs())$r['EvalMath'][]=$f;
        return $r;
      }
    }
  }
}

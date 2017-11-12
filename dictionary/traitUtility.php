<?php
namespace app\dictionary
{
  trait traitUtility
  {
    private function requestNumeric($q)
    {
      $nume = new \app\component\nume($q);
      $nune = new \app\component\nune($q);
      $r=array();
      $r['Numeric'] = array(
        array_filter($nume->request()),
        array('english'=>$nune->request())
      );
      return $r;
    }
    private function requestRoman($q)
    {
      // TODO: working...
    }
  }
}

<?php
namespace app\dictionary
{
  trait traitMoby
  {
    private function requestMobyThesaurus($q)
    {
      if (self::$fileMobyThesaurus) {
        if (!self::isSentence($q)) {
          $o = new \app\component\moby(\app\avail::$config['storage.root'].self::$fileMobyThesaurus);
          if ($x=$o->synonyms($q)) {
            return array_unique(array_filter(array_map('trim', $x)));
            // if (count($x))
          }
        }
      } else {
        return sprintf('todo: ...see Thesaurus for %1$s', self::linkHtml(array($q)));
      }
    }
    private function requestMobyPartsOfSpeech($q)
    {
      if (self::$fileMobyPartsofspeech) {
        if (!self::isSentence($q)){
          $o = new \app\component\moby(\app\avail::$config['storage.root'].self::$fileMobyPartsofspeech);
          if ($x=$o->partsOfSpeech($q)) {
            // return array_unique(array_keys($x));
            return $x;
          }
        }
      } else {
        return sprintf('todo: ...see Parts of speech for %1$s', self::linkHtml(array($q)));
      }
    }
  }
}

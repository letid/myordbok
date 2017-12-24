<?php
namespace app\dictionary
{
  trait traitSetting
  {
    public $q;
    static private $fileMobyThesaurus = '/database/moby/thesaurus.txt';
    static private $fileMobyPartsofspeech = '/database/moby/partofspeech.txt';

    static private $ruleTranslateAPI = false;
    static private $ruleTranslateAccess = 'AIzaSyCXDAPSNcVG40pN7VfCjEW-r93VWbfnSHA';
    static private $ruleTranslateInputData = false;
    static private $ruleImageAPI =false;
    static private $ruleImageAccess = 'ABQIAAAAk0-qzrfhcMoXzVpLqNNZghQFSQtheH-ugMmNUC1exYiAINr_mhQm2LEy4BlTLh51QWPBB9ckI2M0pg';

    static private $ruleAntonmy = true;
    static private $ruleDerivation = true;

    static private $ruleCriteria = array(0=>'q',1=>'q%',2=>'%q',3=>'%q%');
    static private $ruleRestrictedKeywords = array('gangbang','incest','femdom');

    static private $langCurrent ='en';
    static private $langDefault = 'en';
    static private $total = array();
    static private $row = array();

    static private $rowGrammarMoby = array(
      'N'=>'Noun',
      'p'=>'Plural',
      'h'=>'Noun Phrase',
      'V'=>'Verb (usu participle)',
      't'=>'Verb (transitive)',
      'i'=>'Verb (intransitive)',
      'A'=>'Adjective',
      'v'=>'Adverb',
      'C'=>'Conjunction',
      'P'=>'Preposition',
      '!'=>'Interjection',
      'r'=>'Pronoun',
      'D'=>'Definite Article',
      'I'=>'Indefinite Article',
      'o'=>'Nominative'
    );
    static private $rowStatus = array(
      0=>'Draft',
      1=>'Active',
      2=>'Okey',
      100=>'American History',
      101=>'Mathematic Glossary (Intermediate School Level)',
      102=>'Mathematic Glossary (Elementary School Level)',
      103=>'Medical Glossary/Terms (2nd edition)'
    );

    static private $columnWord = 'word';
    static private $columnSense = 'sense';
    static private $columnExam = 'exam';
    static private $columnType = 'tid';
  }
}

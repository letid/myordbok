<?php
namespace app\dictionary
{
  trait traitSetting
  {
    public $q;
    static private $fileMobyThesaurus = '/DATABASE/MOBY/thesaurus.txt';
    static private $fileMobyPartsofspeech = '/DATABASE/MOBY/partofspeech.txt';

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
    static private $rowGrammar  = array(
      1=>'Noun', #0
      16=>'Verb', #1
      4=>'Intransitive',
      5=>'Transitive',
      12=>'Auxiliary verb',
      3=>'Adjective', #2
      6=>'Adverb', #3
      14=>'Abbreviation', #8
      8=>'Conjunction', #5
      22=>'Determiner',
      24=>'Predeterminer',
      23=>'Contraction of', #12
      10=>'Exclamation',
      11=>'Indefinite article',
      9=>'Interjection',
      20=>'Comb Form', #10
      7=>'Preposition', #4
      15=>'Prefix',
      2=>'Pronoun', #6
      13=>'Symbol',
      18=>'Adjective & Adverb',
      19=>'Adjective & Noun',
      21=>'Adjective & Pronoun',
      26=>'Conjunction & Adverb',
      27=>'Preposition & Conjunction',
      28=>'Noun & Pronoun',
      44=>'Exclamation & Noun',
      25=>'Verb & Noun',
      29=>'Cardinal number',
      30=>'Ordinal number',
      31=>'Interrogative adjective',
      32=>'Interrogative adverb',
      33=>'Interrogative pronoun',
      34=>'Relative adverb',
      35=>'Relative adjective',
      36=>'Relative pronoun',
      37=>'Relative conjunction',
      38=>'Adverb & Preposition',
      39=>'Adverb, Adjective & Preposition',
      40=>'Modal verb',
      41=>'Possessive adjective',
      42=>'Possessive pronoun',
      43=>'Infinitive marker',
      17=>'Suffix',
      100=>'Idiom',
      101=>'Synonym',
      102=>'Antonym',
      113=>'Country',
      104=>'Capital city',
      105=>'Plural Noun',
      106=>'Phrase', #11
      107=>'Prefix',
      108=>'Slang',
      109=>'Verb present tense',
      110=>'Verb past tense'
    );

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

    static private $columnSource = 'source';
    static private $columnExam = 'exam';
    static private $columnState = 'state';
    static private $columnEnglish = 'define';
  }
}

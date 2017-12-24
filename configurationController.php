<?php
namespace app
{
  class configurationController extends \letId\request\configuration
  {
    protected $dictionaries = array(
      'International'=>array(
      	 'en'=>'English',
      	 'iw'=>'Hebrew',
      	 'el'=>'Greek',
      	 'pt'=>'Portuguese',
      	 'fr'=>'French',
      	 'nl'=>'Dutch',
      	 'ar'=>'Arabic',
      	 'es'=>'Spanish'
       ),
      'Europe'=>array(
      	 'no'=>'Norwegian',
      	 'fi'=>'Finnish',
      	 'ro'=>'Romanian',
      	 'pl'=>'Polish',
      	 'sv'=>'Swedish',
      	 'da'=>'Danish',
      	 'de'=>'German',
      	 'ru'=>'Russian'
       ),
      'Asia'=>array(
      	'ja'=>'Japanese',
      	'zh'=>'Chinese',
      	'ko'=>'Korean',
      	'ms'=>'Malay',
      	'tl'=>'Filipion',
      	'vi'=>'Vietnamese',
      	'th'=>'Thai',
      	'hi'=>'Hindi'
      )
    );
    protected $grammar = array(
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
    /**
    * application's directory rewrite! src, lang,temp
    */
    protected $rewrite = array(
      'src'=>'resource'
    );
    /**
    * application's directory
    */
    protected $directory = array(
      'template'=>'template',
      'language'=>'language'
    );
    /**
    * application's setting
    */
    protected $setting = array(
      // 'build' => '30.05.17.9.36',
    	// 'version' => '3.2.67',
    	// 'name' => 'MyOrdbok',
    	// 'copyright' => '2017',
    	// 'description' => 'online Myanmar dictionary',
      // NOTE: individual
      // 'visitsPrevious' => 27812305234506
      // 'locale' => 'en',
      // 'lang' => 'en',
    );
  }
}

<?php
namespace app\map;
use app;
class fonts extends mapController
{
  static private $location = 'MYANMAR.FONTS';
	static private $fontParam = 'font';
	static private $txt = '.txt';
	static private $json = '.json';
	static private $download = 'download';
	static private $restrict = 'restrict';
  public function __construct()
  {
    $this->timeCounter = app\avail::timer();
    // app\avail::log('visits')->counter();
    app\avail::log()->counter();
    $this->storage_fonts = app\avail::$config['storage.root'].'/'.self::$location;
    // $this->page_current = app\avail::$http.'/'.app\avail::$uri[0];
    $this->page_current = '/'.app\avail::$uri[0].'/';
  }
  public function classConcluded()
  {
    app\versoController::menu()->requestOne('page');
    app\versoController::menu()->requestOne('privacy');
    app\versoController::menu()->requestOne('user');
    // app\versoController::menu()->requestOne('definition');
    // app\versoController::menu()->requestOne('password');
    app\verseController::menu()->request();
    $this->timerfinish = $this->timeCounter->finish();
  }
  public function home()
  {
    // NOTE: ?font=
    $font = isset($_GET[self::$fontParam])?$_GET[self::$fontParam]:null;
    $fonts_detail_template = null;
    /*
    // NOTE: generate
    if (isset($_GET['generate'])) return $this->generating($_GET['generate'],$font);
    // NOTE: download
    if ($font && isset(app\avail::$uri[1]) && app\avail::$uri[1] == self::$download) $this->downloading($font);
    // NOTE: detail
    if ($font && $this->viewing($font)) {
      // TODO: array value 1 is given, as template generator not accept as temple file name without value
      $fonts_detail_template = array(1);
    } else {
      $this->Title='Myanmar fonts';
      $this->Description='Myanmar Unicode and fonts';
      $this->Keywords='Myanmar fonts';
      // TODO: remove -> app\avail::content('Myanmar fonts')->set('Title');
    }
    */
    if (isset($_GET['generate'])) {
      // NOTE: generate
      return $this->generating($_GET['generate'],$font);
    }
    if ($font) {
      if (isset(app\avail::$uri[1]) && app\avail::$uri[1] == self::$download) {
        // NOTE: download
        $this->downloading($font);
      }
      if ($this->viewing($font)) {
        // TODO: array value 1 is given, as template generator not accept as temple file name without value
        $fonts_detail_template = array(1);
      } else {
        $this->Title='Myanmar fonts';
        $this->Description='Myanmar Unicode and fonts';
        $this->Keywords='Myanmar fonts';
      }
    } else {
      $this->Title='Myanmar fonts';
      $this->Description='Myanmar Unicode and fonts';
      $this->Keywords='Myanmar fonts';
      // TODO: remove -> app\avail::content('Myanmar fonts')->set('Title');
    }
    return array(
      'layout'=>array(
        // TODO: remove -> 'Title'=>'Myanmar fonts',
        // TODO: remove -> 'Description'=>'Myanmar fonts',
        // TODO: remove -> 'Keywords'=>'using the {name} service',
        'page.id'=>'myanmar-fonts',
        'page.class'=>'myanmar-fonts',
        'page.content'=>array(
          'layout.bar'=>array(),
          'fonts'=>array(
            'fonts.detail'=>$fonts_detail_template,
            'fonts.secondary.list'=>$this->listing('secondary'),
            'fonts.external.list'=>$this->listing('external')
          ),
          'layout.footer'=>array()
        )
      )
    );

  }
  private function viewing($font)
	{
    // NOTE: external?font=$fontName
    $fileFont = $this->storage_fonts.'/'.app\avail::$uri[1].'/'.$font;
    // $fileRestrict = $this->storage_fonts.'/'.self::$restrict.self::$json;
    $fileContent = $this->storage_fonts.'/'.app\avail::$uri[1].self::$json;
		if (file_exists($fileFont)) {
      $jsonContent = $this->jsonReadPlus($fileContent,$font,'view');
			$infoTable = array(
				0 => 'Copyright',
				1 => array('Font Family'),
				2 => array('Font Subfamily'),
				3 => 'Unique identifier',
				4 => 'Full name',
				5 => array('Version'),
				6 => 'Postscript name',
				7 => 'Note',
				8 => 'Company',
				9 => 'Owner',
				10 => 'Description',
				11 => 'URL',
				12 => 'URL',
				13 => 'License',
				14 => 'URL',
				// 15 => '',
				16 => 'Name'
				// 17 => ''
			);
      $ttf = new app\component\ttfinfo;
      $ttf->setFile($fileFont);
      $infoHtml = array();
      $toggleMenu = array();
      $toggleContent = array();
			foreach($ttf->readFile() as $k => $d)
			{
        $infoText = null;
				if(isset($infoTable[$k])){

          $info = preg_replace('~\r\n?~', "\n", implode($d));
          $info_paragraphs = explode("\n\n",$info);

          $infoName = is_array($infoTable[$k])?$infoTable[$k][0]:$infoTable[$k];
          $infoNameClass = strtolower(str_replace(' ','-',$infoName));
          // $r[$name] = $info;
          if (count($info_paragraphs) > 1) {
            // NOTE: is paragraph
            $infoText = array();
            foreach(array_filter($info_paragraphs) as $elementText) {
              // NOTE: replace more than 2 dashes to just one dash
              $elementText = preg_replace('/---+/', "--\n", $elementText);
              $elementArray = explode("\n",$elementText);
              $elementFirstLine=$elementArray[0];
              // ctype_upper($elementFirstLine) || mb_strtoupper($elementFirstLine, 'utf-8') == $elementFirstLine
              if (ctype_upper($elementFirstLine) || mb_strtoupper($elementFirstLine, 'utf-8') == $elementFirstLine){
                $h3 = array_shift($elementArray);
                if ($h3)$infoText[] = array(
                  'h3'=>array(
                    'text'=>$h3
                  )
                );
              }
              if ($elementArray) {
                $infoText[] = array(
                  'p'=>array(
                    'text'=>implode(' ',$elementArray)
                  )
                );
              }
            }
          } else {
            // NOTE: is not paragraph
            if (filter_var($info, FILTER_VALIDATE_URL) == true) {
              // NOTE: URL
              $infoText = array(
                'a'=>array(
                  'text'=>$info,
                  'attr'=>array(
                    'href'=>$info,
                    'target'=>'blank'
                  )
                )
              );
            } else {
              // NOTE: TEXT
              if (trim($info) !== "") {
                $tag = ($k > 0 and $k < 6 )?'h'.$k:'p';
                $infoText = array(
                  $tag=>array(
                    'text'=>$info
                  )
                );
                if ($k == 1) {
                  $infoNameId=$info;
                  $infoTitle=str_replace('_',' ',$info);
                  $infoKeywords=str_replace('_',',',$info);
                  $infoDescription=$info;
                } elseif ($k == 7) {
                  $infoDescription=$info;
                } elseif ($k == 4) {
                  $infoDescription=$info;
                }
              }
            }
          }
          if ($infoText) {
            if ($k == 10 || $k == 13) {
              // NOTE: Description, License
              $toggleMenu[] = array(
                'li'=>array(
                  'text'=>$infoName,
                  'attr'=>array(
                    'class'=>$infoNameClass,
                    'data-toggle'=>$infoNameClass
                  )
                )
              );
              $toggleContent[] = array(
                'div'=>array(
                  'text'=>$infoText,
                  'attr'=>array(
                    'class'=>$infoNameClass
                  )
                )
              );
            } else {
              $infoHtml[] = array(
                'div'=>array(
                  'text'=>$infoText,
                  'attr'=>array(
                    'class'=>$infoNameClass
                  )
                )
              );
            }
          }
				}
				// NOTE: end each
			}
      $this->Title=$infoTitle;
      $this->Keywords=$infoKeywords;
      $this->Description=$infoDescription;
      /*
      if (array_key_exists($font,$jsonContent)){
        // NOTE: check property exists
        if (array_key_exists('restrict',$jsonContent[$font])===false) {
          // NOTE: check is restricted
          $toggleMenu[] = array(
            'li'=>array(
              'text'=>array(
                'a'=>array(
                  'text'=>'Download',
                  'attr'=>array(
                    'href'=>$this->urlDownload(app\avail::$uri[1],$font)
                  )
                )
              ),
              'attr'=>array(
                'class'=>'download'
              )
            )
          );
        }
        $jsonContent[$font]['view'] = $jsonContent[$font]['view'] + 1;
        $this->jsonWrite($fileContent,json_encode($jsonContent));
      }
      */
      if ($this->jsonRestrict($jsonContent,$font)) {
        $toggleMenu[] = array(
          'li'=>array(
            'text'=>array(
              'a'=>array(
                'text'=>'Download',
                'attr'=>array(
                  'href'=>$this->urlDownload(app\avail::$uri[1],$font)
                )
              )
            ),
            'attr'=>array(
              'class'=>'download'
            )
          )
        );
      }
      $moreHtml='';
      if ($toggleMenu) {
        // NOTE: to prevent unnecessary empty div, if toggleHeader is available and toggleContent is not
        if ($toggleContent) {
          $toggleContent = array(
            'div'=>array(
              'text'=>$toggleContent,
              'attr'=>array(
                'class'=>'container'
              )
            )
          );
        }
        $moreHtml=array(
          'div'=>array(
            'text'=>array(
              'div'=>array(
                'text'=>array(
                  'ul'=>array(
                    'text'=>$toggleMenu,
                    'attr'=>array(
                      'class'=>'menu'
                    )
                  ),
                  $toggleContent
                ),
                'attr'=>array(
                  'class'=>'toggle'
                )
              )
            ),
            'attr'=>array(
              'class'=>'row more'
            )
          )
        );
      }
      $this->fonts_info = app\avail::html(array(
        array(
          'div'=>array(
              'text'=>$infoHtml,
              'attr'=>array(
                'class'=>'row info'
              )
          )
        ),
        $moreHtml
      ));
      return true;
		}

	}
  /**
  * NOTE: ?generate=$path&font=$fontFileName
  * HACK: $path -> primary, external, secondary
  * HACK: $fontName -> add or remove from restriction
  */
  private function generating($path,$font2Restrict=null)
	{
    $this->responseType='text';
    $directory = $this->storage_fonts.'/'.$path.'/';
    $fileRestrict = $this->storage_fonts.'/'.self::$restrict.self::$json;
    $fileContent = $this->storage_fonts.'/'.$path.self::$json;

    if (file_exists($directory)) {
      $jsonRestrict = $this->jsonRead($fileRestrict,true);
      $jsonContent = file_exists($fileContent)?$this->jsonRead($fileContent,true):array();
      // $jsonRestrict = json_decode(file_get_contents($fileRestrict),true);
      // $jsonContent = json_decode(file_get_contents($fileContent),true);
      $ttf = new app\component\ttfinfo;
      $ttf->setDir($directory);
      $ttf->readDir();
      $fonts = array();
      $fontsCount = count($ttf->data);
      $fontRestrictCount = 0;
      $msg = '';
			foreach($ttf->data as $k => $v){
				$fontFileName = basename($k);
				$i = 0;
				foreach ($v as $row => $x){
					$d = implode($x);
					if (++$i == 6) break;
					if ($i == 4 or $i == 3 ) {
					} else if ($i == 1) {
						$fontName = ($row == 1)?$d:'';
					} else if ($i == 2) {
						$fontFamily = ($row == 2)?$d:'';
					} else {
						$fontVersion = $d;
					}
				}
        $fontView = isset($jsonContent[$fontFileName]['view'])?$jsonContent[$fontFileName]['view']:0;
        $fontDownload = isset($jsonContent[$fontFileName]['download'])?$jsonContent[$fontFileName]['download']:0;
        $fontContent[$fontFileName] = array(
          'name'=>$fontName,
          'version'=>$fontVersion,
          'family'=>$fontFamily,
          'view'=>$fontView,
          'download'=>$fontDownload
        );
        $status = '';
				if($font2Restrict && $fontFileName==$font2Restrict){
					if(isset($jsonRestrict[$fontName])){
						 unset($jsonRestrict[$fontName]);
						$status = "\t remove from restrict - ";
					}else{
						$is_adding = NULL;
						$jsonRestrict[$fontName]=1;
						$status = "\t add to restrict - ";
					}
				}
				if (isset($jsonRestrict[$fontName])){
           $fontContent[$fontFileName]['restrict']=$jsonRestrict[$fontName];
					if($font2Restrict and $fontName==$font2Restrict){
						$status .= "success - ";
					}else{
						$status .= "- restricted - ";
					}
					$fontRestrictCount++;
				}
        $msg .= "$status {$fontName} ($fontFileName) view:$fontView, download:$fontDownload \n";
			}
      $msg .= "\n................................\n";
      $msg .= $path.self::$json." -> ";
      if($this->jsonWrite($fileContent,$fontContent)){
      	$msg .= "total {$fontsCount}, restricted {$fontRestrictCount}\n";
      }else{
      	$msg .= "seem we have no writting permission!\n";
      }
      $msg .= self::$restrict.self::$json." -> ";
      if($this->jsonWrite($fileRestrict,$jsonRestrict)){
      	$msg .= "done";
      }else{
      	$msg .= "seem we have no writting permission!";
      }
      $msg .= "\n................................";
    } else {
      $msg .= "{$path} -> no such directory exists!";
    }
    return $msg;
	}
  // private function build_sorter($key) {
  //     return function ($a, $b) use ($key) {
  //         return strnatcmp($a[$key], $b[$key]);
  //     };
  // }
  private function listingSort($a, $b)
  {
    return ($b['view'] + $b['download']) - ($a['view'] + $a['download']);
  }
  // NOTE: done down here
  private function listing($type)
  {
    $r = array();
    $file = $this->storage_fonts.'/'.$type.self::$json;
    if (file_exists($file)) {
      $json = $this->jsonRead($file,true);
      uasort($json, array($this,'listingSort'));
      foreach($json as $fileName => $o){
        $o['viewUrl'] = $this->urlDetail($type,$fileName);
        $o['downloadUrl'] = array_key_exists('restrict',$o)?'#':$this->urlDownload($type,$fileName);
        $totalView = $o['view'] + $o['download'];
        $o['viewStatus']= ($totalView > 0)?'y':'n';
        $o['total'] = $totalView;
        $r[]=$o;
      }
      // $json = $this->jsonRead($file,false);
      // foreach($json as $fileName => $o){
      //   $l['detail'] = $this->urlDetail($type,$fileName);
      //   if(property_exists($o, 'restrict')){
      //     $l['download'] = '#';
      //     $l['downloadStatus'] = 'n';
      //   } else {
      //     $l['download'] = $this->urlDownload($type,$fileName);
      //     $l['downloadStatus'] = 'y';
      //   }
      //   $l['name'] = $o->name;
      //   $l['version'] = $o->version;
      //   $l['family'] = $o->family;
      //   $totalView = $o->view + $o->download;
      //   if ($totalView > 0) {
      //     $l['viewStatus'] = 'y';
      //   } else {
      //     $l['viewStatus'] = 'n';
      //   }
      //   $l['data-total'] = $totalView;
      //   $l['data-view'] = $o->view;
      //   $l['data-download'] = $o->download;
      //   $r[]=$l;
      // }
    }
    return $r;
  }
  private function downloading($font)
  {
    // NOTE: download/secondary?font=m-myanmar1.TTF
    /*
    $dir 		= $this->uri;
    $dir[0] 	= "https://googledrive.com/host/0B6VPRirQoaTYdzFnVWhnWDg3S28/";
    unset($dir[1]);
    $dir[] 		= ($font)?$font:$installer;
    $file 		= implode("/",$dir);
    header("Location: $file");
    */

    // TODO: remove
    $file = $this->storage_fonts.'/'.app\avail::$uri[2].'/'.$font;
    $fileContent = $this->storage_fonts.'/'.app\avail::$uri[2].self::$json;
    // TODO: remove end
    if (file_exists($file)) {
      $json=$this->jsonReadPlus($fileContent,$font,'download');
      if ($json && $this->jsonRestrict($json,$font)===false) return true;
      $name= basename($file);
      $size=filesize($file);
      // header("Content-type: application/force-download");
      header("Content-Transfer-Encoding: Binary");
      header("Content-length: $size");
      header("Content-disposition: attachment; filename=$name");
      readfile($file);
    }
  }
  private function jsonWrite($file,$json)
  {
    $handle = fopen($file, "w");
    return (fwrite($handle, json_encode($json)) === false)? false : true;
    fclose($handle);
  }
  private function jsonReadPlus($file,$font,$status='download')
  {
    if (file_exists($file)) {
      $json = $this->jsonRead($file);
      if (array_key_exists($font,$json)) {
        $json[$font][$status] = $json[$font][$status] + 1;
        $this->jsonWrite($file,$json);
      }
      return $json;
    }
  }
  private function jsonRestrict($json,$font)
  {
    if (array_key_exists($font,$json)){
      // NOTE: check restricted
      return array_key_exists('restrict',$json[$font])===false;
    }
  }
  private function jsonRead($file,$status=true)
  {
    return json_decode(file_get_contents($file),$status);
  }
  private function urlDownload($type,$fileName)
  {
    return $this->page_current.self::$download.'/'.$type.'?'.http_build_query(array(self::$fontParam=>$fileName));
  }
  private function urlDetail($type,$fileName)
  {
    return $this->page_current.$type.'?'.http_build_query(array(self::$fontParam=>$fileName));
  }
}

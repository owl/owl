<?php



class NGram{

    /*
     * Convert String into N-Gramed string 
     */
    public static function convert($str, $n = 2){
        $res = array();
        $str = self::removeTag($str);
        $str = self::stripCrLf($str);
        $len = mb_strlen($str, 'UTF8');
    
        $index = 0;
        while(true){
            $res[] = mb_substr($str,$index,$n, 'UTF8');
            $index++;
            if($index+$n > $len) break;
        }
        return implode(' ', $res);
    }
    
    
    /**
     *  remove all cr+lf from string
     */
    private static function stripCrLf($str){
        return preg_replace("/[\r\n]+/", "", $str);
    }

    private static function removeTag($str){
        $parser = new CustomMarkdown;
        $parser->enableNewlines = true;
        return strip_tags($parser->parse($str));
    }

}

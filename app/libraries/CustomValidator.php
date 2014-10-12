<?php

class CustomValidator extends Illuminate\Validation\Validator {
	/**
	 * Validate that an attribute contains only alphabetic characters.
	 * uオプションを(unicode)を外す。オーバーライド。
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlpha($attribute, $value)
	{
		return preg_match('/^\pL+$/', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters.
	 * uオプションを(unicode)を外す。オーバーライド。
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaNum($attribute, $value)
	{
		return preg_match('/^[\pL\pN]+$/', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters, dashes, and underscores.
	 * uオプションを(unicode)を外す。オーバーライド。
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaDash($attribute, $value)
	{
		return preg_match('/^[\pL\pN_-]+$/', $value);
	}

	protected function validateAlphaComma($attribute, $value)
	{
		return preg_match('/^[\pL\pN\s　_,-]+$/u', $value);
	}

    /**
     * 半角英字&スペース
     */
    protected function validateAlphaSpace($attribute, $value) {
        return preg_match('/^[\pL\s]+$/',$value);
    }

    /**
     * 予約語
     */
    protected function validateReservedWord($attribute, $value) {

        $words = array(
            'index','home','top','help','about','security','contact',
            'connect','support','faq','form','mail','update','mobile',
            'phone','portal','tour','tutorial','navigation','navi',
            'manual','doc','company','store','shop','topic','news',
            'information','info','howto','pr','press','release','sitemap',
            'plan','price','business','premium','member','term','privacy',
            'rule','inquiry','legal','policy','icon','image','img','photo',
            'css','stylesheet','style','script','src','js','javascript',
            'dist','asset','source','static','file','flash','swf','xml',
            'json','sag','cgi','account','user','item','entry','article',
            'page','archive','tag','category','event','contest','word',

            'product','project','download','video','blog','diary','site',
            'popular','i','my','me','owner','profile','self','old','first',

            'last','start','end','special','design','theme','propose',
            'book','read','organization','community','group','all','status',
            'search','explore','share','feature','upload','rss','atom',

            'widget','api','wiki','bookmark','captcha','comment','jump',
            'ranking','setting','config','tool','connect','notify','recent',
            'report','system','sys','message','msg','log','analysis','query',
            'call','calendar','friend','graph','watch','cart','activity',
            'password','auth','session','register','login','logout',
            'signup','signin','signout','forgot','admin','root','secure',

            'get','show','create','edit','update','post','destroy','delete',
            'remove','reset','error','new','dashboard','recruit','join',
            'offer','career','corp','school','developer','dev','test','bug',
            'code','guest','app','maintenance','roc','id','bot','game',
            'forum','contribute','usage','feed','ad','service','official',
            'language','repository','spec','license','asct','dictionary',
            'dict','version','ver','gift','alpha','beta','tux','year',
            'public','private','default','request','req','data','master',
            'die','exit','eval','issue','thread','diagram','undef','nan',
            'null','empty','0','templates','items','likes','stocks'
);

        foreach($words as $word) {
            if ($value ===  $word) {
                return false;
            }
        }
        return true;
    }
}

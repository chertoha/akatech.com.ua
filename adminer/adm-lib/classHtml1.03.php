<?php

class DOM {
    public $title = '<title>Html Page</title>';
    public $keywords = '<meta name="keywords" content="Перечень ключевых слов">';
    public $description = '<meta name="description" content="краткое описание страницы">';
    public $encoding = '<meta charset=utf8>';
    public $css = [];
    public $js = [];
    public $content ='';
    
    public function __construct($tit,$encode) {
        $this->SetTitle($tit);
        $this->SetEncoding($encode);
        $this->keywords = '';
        $this->description = '';
    }//c-tor
    
    public function SetTitle($str){
        $this->title = '<title>'.$str.'</title>';
    }//SetTitle
    
    public function SetEncoding($str){
        $this->encoding = '<meta charset='.$str.'>';
    }//SetTitle
    
    public function AddCSS($relative_path){ 
            $this->css[] = "<link href=\"$relative_path\" rel=\"stylesheet\" type=\"text/css\" >";
    }//AddCSS()
    
    public function AddJS($relative_path){ 
            $this->js[] = "<script src=\"$relative_path\"></script>";        
    }//AddCSS()
    
    
    public function Render(){
        $htmlText = '<!DOCTYPE html>';
        $htmlText.= '<html><head>';
        $htmlText.= $this->title;
        $htmlText.= $this->keywords;
        $htmlText.= $this->description;
        $htmlText.= $this->encoding;
        
        foreach ($this->css as $value){
            $htmlText.= $value;
        }
        
        $htmlText.= '</head><body>';
        $htmlText.= $this->content;
        
        foreach ($this->js as $value){
            $htmlText.= $value;
        }
        
        $htmlText.= '</body></html>';
        
        echo $htmlText;
    }//Render()
    
    
    
    
}//class DOM


 
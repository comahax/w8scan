<?php
/*
 * 指纹识别
 */
class WebDNA_Model {
    function __construct(){
        $this->filename = EMLOG_ROOT.'/w7scan/data/cms.json';
        if(file_exists($this->filename)){
            $str = file_get_contents($this->filename);//将整个文件内容读入到一个字符串中
            $this->_data = json_decode($str,true);
        }
    }
    function getall(){
        return count($this->_data);
    }

    function getdata($index = 0,$num = 10){
        
        $back_arr = array_slice(array_reverse($this->_data),$index*10,$num);
        foreach($back_arr as $key=>$v){
            $index = $this->getIndexByArr($v);
            $back_arr[$key]["index"] = $index;
        }
        return $back_arr;
    }

    function insert($name = '',$url = '',$re = '',$md5 = ''){
        $temp = array(
            "url" => $url,
            "name" => $name,
            "re" => $re,
            "md5" => $md5
        );
        $this->_data[] = $temp;
        $data = json_encode($this->_data);
        file_put_contents($this->filename,$data);
    }

    function delete($index){
        array_splice($this->_data, $index, 1);
        $data = json_encode($this->_data);
        file_put_contents($this->filename,$data);
        // array_splice($this->_data, $index, 1); 
    }

    function search($key){
        $back_arr = array();
        foreach($this->_data as $val){
            if(stripos($val["name"], $key) !== false){
                $index = $this->getIndexByArr($val);
                $val["index"] = $index;
                $back_arr[] = $val;
            }
        }
        return $back_arr;
    }

    function getIndexByArr($arr){
        return array_search($arr,$this->_data);
    }
}